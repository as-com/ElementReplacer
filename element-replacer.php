<?php
/**
 * Plugin Name: ElementReplacer
 * Plugin URI: http://andrewsun.com/programs/elementreplacer/
 * Description: Replaces elements in the page
 * Version: 0.1
 * Author: Andrew Sun
 * Author URI: http://andrewsun.com/
 * License: GPL3
 */

function ereplacer_callback($buffer) {
  // modify buffer here, and then return the updated code
  return $buffer;
}

function ereplacer_buffer_start() { ob_start("ereplacer_callback"); }

function ereplacer_buffer_end() { ob_end_flush(); }

add_action('wp_head', 'ereplacer_buffer_start');
add_action('wp_footer', 'ereplacer_buffer_end');

?>