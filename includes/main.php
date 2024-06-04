<?php

function form_entries_post_type() {
    $args = array(
        'public'    => true,
        'label'     => __( 'Form Entries', 'textdomain' ),
        'menu_icon' => 'dashicons-book',
    );
    register_post_type( 'form-entry', $args );
}
add_action( 'init', 'form_entries_post_type' );



add_filter('wpcf7_autop_or_not', '__return_false');

if(isset($_GET['test'])) {
    add_action('wp_head', function() {
        echo "<style>.getTest {display: block!important;}</style>";
    });
} else {
    add_action('wp_head', function() {
        echo "<style>.getTest {display: none!important;}</style>";
    });
}

function akoya_wpcf7_before_send_mail_function( $contact_form, $abort, $submission ) {

    if('reservation-form' != $contact_form->name()){
        return $contact_form;
	}
    if(!$submission->get_posted_data('treatpack')) {
        return $contact_form;
    }
    $treatment_str = '';
    $treatment_arr = array();
    // Get title for each treatment then replace email body with titles
    foreach($submission->get_posted_data('treatpack') as $index => $treat) {
        if($index) {
            $treatment_str .= ', ';
        }
        $treatment_str .= get_the_title($treat);
        $treatment_arr[$treat] = (int) get_field('price', $treat);
    }

    $mail = $contact_form->prop('mail');

    $mail['body'] = preg_replace('/\[treatpack\]/', $treatment_str, $mail['body']);

    $contact_form->set_properties( array( 'mail' => $mail ) );
    if(!preg_match('/\[pricetotal\]/',$mail['body'])) {
        return $contact_form;
    }
    // Check promocode 
    // Whether has promocode or not will calculate price
    // then replace email body with total

    if($submission->get_posted_data('promo-code')) {
        $loop = new WP_Query(array(
            'post_type' => 'discount',
            'name' => $submission->get_posted_data('promo-code'),
            'post_status' => 'publish'
        ));
        if($loop->have_posts()) {
            while($loop->have_posts()) {
                $loop->the_post();
                foreach($treatment_arr as $id => $price) {
                    if($id == get_field('treatment', get_the_id())) {
                        $treatment_arr[$id] = (int) get_field('price_to');
                    }
                }
            }
        }
    }

    $priceTotal = 0;

    foreach($treatment_arr as $price) {
        $priceTotal = $priceTotal + $price;
    }

    $mail['body'] = preg_replace('/\[pricetotal\]/', $priceTotal,$mail['body']);
    $contact_form->set_properties( array( 'mail' => $mail ) );
    return $contact_form;
    
}
add_filter( 'wpcf7_before_send_mail', 'akoya_wpcf7_before_send_mail_function', 10, 3 );
