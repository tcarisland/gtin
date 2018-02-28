<?php
/*
Plugin Name: GTIN
Plugin URI: http://www.tcarisland.com
Description: A GTIN database searcher
Version: 1.0
Author: Thor Arisland
Author URI: http://www.tcarisland.com
License: Free for personal use
*/

require_once "sqlfunctions.php";

add_action( 'wp_enqueue_scripts', 'gtin_deps' );

function get_gtin() {
    $template = file_get_contents(plugin_dir_url(__FILE__) . "template.html");
    $retval = $template;
    return $retval;
}

function gtin_deps() {
    wp_enqueue_script("gtin_script", plugin_dir_url(__FILE__) . "js/gtin.js", array('jquery'), null, false);
}

add_shortcode('GTIN_PLUGIN', 'get_gtin');

?>