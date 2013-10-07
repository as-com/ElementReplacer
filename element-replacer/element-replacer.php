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
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function ereplacer_callback($buffer) {
  /* Simple HTML DOM */
  include trailingslashit(dirname( __FILE__ )) . "includes/simplehtmldom.php";
  
  $ereplacer_outputhtml = str_get_html($buffer);
  // $ereplacer_outputhtml->find(".copyright", 0)->innertext = "Enchanced via magic!";
  foreach($ereplacer_outputhtml->find(get_option('ereplacer_selectors')) as $elm) {
    $elm->innertext=get_option('ereplacer_innertext');
  }

  return $ereplacer_outputhtml;
}

function ereplacer_buffer_start() { ob_start("ereplacer_callback"); }
function ereplacer_buffer_end() { ob_end_flush(); }


function ereplacer_plugin_settings() {
    add_menu_page('ElementReplacer Settings', 'ElementReplacer', 'administrator', 'ereplacer_settings', 'ereplacer_display_settings');
}

function ereplacer_display_settings() {
  $selectors = (get_option('ereplacer_selectors') != '') ? get_option('ereplacer_selectors') : '';
  $innertext = (get_option('ereplacer_innertext') != '') ? get_option('ereplacer_innertext') : '';
  
  echo '<div class="wrap"><form action="options.php" method="post" name="options">';
  echo '<div id="icon-plugins" class="icon32"><br></div>';
  echo '<h2>ElementReplacer Settings</h2>';
  echo wp_nonce_field('update-options');
  echo '<label>Selector</label><input type="text" name="ereplacer_selectors" value="' . $selectors . '" /><br>';
  echo '<label>Innertext</label><input type="text" name="ereplacer_innertext" value="' . $innertext . '" />';
  
  echo '<input type="hidden" name="action" value="update" />';
  echo '<input type="hidden" name="page_options" value="ereplacer_selectors,ereplacer_innertext" />';
  echo '<input type="submit" name="Submit" value="Update" /></form></div>';

}


// Actions
add_action('wp_head', 'ereplacer_buffer_start');
add_action('wp_footer', 'ereplacer_buffer_end');
add_action('admin_menu', 'ereplacer_plugin_settings');

?>