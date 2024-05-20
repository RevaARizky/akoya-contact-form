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