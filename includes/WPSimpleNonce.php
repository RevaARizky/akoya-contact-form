<?PHP
Class WPSimpleNonce {

	const option_root ='wp-snc';

	public static function createNonce($name) {

		if (is_array($name)) {
			if (isset($name['name'])) {
				$name = $name['name'];
			}

			else {
				$name = 'nonce';
			}
		}

		$id = self::generate_id();
		$name = substr($name, 0,17).'_'.$id;

		$nonce = md5( wp_salt('nonce') . $name . microtime(true));
		self::storeNonce($nonce,$name);
		return array("name"=>$name, "value"=>$nonce);
	}



	public static function createNonceField($name='nonce') {

		if (is_array($name)) {

			if (isset($name['name'])) {
				$name = $name['name'];
			}

			else {
				$name = 'nonce';
			}
		}

		// Issue #11: Remove Deprecated Code
		// Replacing FILTER_SANITIZE_STRING (which is deprecated as of PHP 8.1)
		// ... with a call to htmlentities(). According to PHP documentation,
		// ... FILTER_SANITIZE_STRING should be replaced with htmlspecialchars().
		// ... However, after further research, it seems that htmlentities() is
		// ... recommended for a more complete conversion of special characters.
		// ... Morever, further testing shows that htmlentities() yields the same
		// ... output as the original output generated by using FILTER_SANITIZE_STRING.
		// Userful links:
		// https://www.php.net/manual/en/filter.filters.sanitize.php
		// https://www.php.net/manual/en/function.htmlspecialchars.php
		// https://www.php.net/manual/en/function.htmlentities.php
		$name   = htmlentities($name);

		$nonce  = self::createNonce($name);
		$nonce['value'] = '<input type="hidden" name="' . $nonce['name'] . '" value="'.$nonce['value'].'" />';
		return $nonce;
	}


	public static function checkNonce( $name, $value ) {

		if (empty($name) || empty($value)) {
			return false;
		}

		// Issue #11: Remove Deprecated Code
		// NOTE: Read comment above for details regarding the same issue
		$name = htmlentities($name);

		$nonce = self::fetchNonce($name);
		$returnValue = ($nonce===$value);
		return $returnValue;
	}


	public static function  storeNonce($nonce, $name) {

		if (empty($name)) {
			return false;
		}

		add_option(self::option_root.'_'.$name,$nonce);
		add_option(self::option_root.'_expires_'.$name,time()+86400);
		return true;
	}


	protected static function  fetchNonce($name) {

		$returnValue = get_option(self::option_root.'_'.$name);
		$nonceExpires = get_option(self::option_root.'_expires_'.$name);

		self::deleteNonce($name);

		if ($nonceExpires<time()) {
			$returnValue = null;
		}

		return $returnValue;
	}


	public static function deleteNonce($name) {

		$optionDeleted = delete_option(self::option_root.'_'.$name);
		$optionDeleted = $optionDeleted && delete_option(self::option_root.'_expires_'.$name);
		return (bool)$optionDeleted;
	}


	public static function clearNonces($force=false) {

		if ( defined('WP_SETUP_CONFIG') or defined('WP_INSTALLING') ) {
			return;
		}

		global $wpdb;

		$sql = $wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name like '%s'", self::option_root.'_expires_%');

		$rows = $wpdb->get_results($sql);

		$noncesDeleted = 0;

		foreach ( $rows as $singleNonce ) {

			if ($force || ($singleNonce->option_value < time())) {

				$name = substr($singleNonce->option_name, strlen(self::option_root.'_expires_'));
				$noncesDeleted += (self::deleteNonce($name)?1:0);
			}
		}

		return (int)$noncesDeleted;
	}


	protected static function generate_id() {

		require_once( ABSPATH . 'wp-includes/class-phpass.php');
		$hasher = new PasswordHash( 8, false );
		return md5($hasher->get_random_bytes(100,false));
	}

}
