<?php

/**
 * Laravel Mix Assets helper
 */
function assets_url($path)
{
    $theme_dir = WP_PLUGIN_DIR . '/contact-form-extra-field/assets';
    if (file_exists($theme_dir . '/hot') && WP_SITEURL == "http://localhost") {
        // var_dump(WP_SITEURL);
        // $url = file_get_contents($theme_dir . '/hot');
        
        return "//localhost:8080{$path}";
    }
    
    $manifestPath = $theme_dir . '/mix-manifest.json';
    $manifest = json_decode(file_get_contents($manifestPath), true);
    
    if (isset($manifest[$path])) {
        return WP_CONTENT_URL . '/plugins/contact-form-extra-field/assets' . $manifest[$path];
    } else {
        return WP_CONTENT_URL . '/plugins/contact-form-extra-field/assets' . $path;
    }
}
