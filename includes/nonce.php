<?php

if ( ! class_exists( 'WPSimpleNonce' ) ) {
	require_once( 'WPSimpleNonce.php' );
}

add_shortcode( 'simpleNonce', 'WPSimpleNonce::createNonce' );


function wp_snonce_cleanup() {
	WPSimpleNonce::clearNonces();
}

add_action( 'wp_simple_nonce_cleanup', 'wp_snonce_cleanup' );


function wp_simple_nonce_register_garbage_collection() {
	if ( ! wp_next_scheduled( 'wp_simple_nonce_cleanup' ) ) {
		wp_schedule_event( time(), 'daily', 'wp_simple_nonce_cleanup' );
	}
}

add_action( 'wp', 'wp_simple_nonce_register_garbage_collection' );