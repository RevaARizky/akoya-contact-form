<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('app', plugin_assets_url('/dist/app.css'), [], null);
    wp_enqueue_script('app', plugin_assets_url('/dist/app.js'), ['jquery'], null, true);

    wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css', [], null);
    wp_enqueue_script('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js', ['jquery'], null, true);

    wp_enqueue_script('package', plugin_assets_url('/dist/package.js'), ['jquery'], null, true);
});

add_action('wp_footer', function() {
    $time = time();
    echo "<script>";
    echo "window.timeNow = $time*1000";
    echo "</script>";
});