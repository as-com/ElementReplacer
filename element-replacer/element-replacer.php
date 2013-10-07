<?php
/**
 * Plugin Name: ElementReplacer
 * Plugin URI: http://andrewsun.com/projects/elementreplacer
 * Description: A plugin to replace elements on your page output
 * Version: 0.1
 * Author: Andrew Sun
 * Author URI: http://andrewsun.com
 * Text Domain: 
 * Domain Path: /languages/
 * License: GPLv3
 */

/**
 * Copyright 2013  Andrew Sun  (email: me@andrewsun.com)
 *
 * Credit: Settings API from mattyza & pmgarman
 * https://twitter.com/mattyza
 * https://twitter.com/pmgarman
 *
 * Built using the Plugin Jump Starter!
 * https://github.com/pmgarman/plugin-jump-starter
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3, as
 * published by the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if( !class_exists( 'ereplacer' ) ) {
	require 'classes/class-ereplacer-settings-api.php';
	require 'classes/class-ereplacer-settings-screen.php';
	require 'classes/class-ereplacer-settings.php';
	require 'classes/class-ereplacer.php';

	global $ereplacer;
	$ereplacer = new ereplacer( __FILE__ );

	load_plugin_textdomain( '', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}