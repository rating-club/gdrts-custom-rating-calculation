<?php

/*
Plugin Name:       GD Rating System Pro: Custom Rating Calculation
Plugin URI:        https://rating.dev4press.com/
Description:       This is a demo plugin showing how to add a custom rating value (other than just average rating) and use it for ordering and display.
Author:            Milan Petrovic
Author URI:        https://www.dev4press.com/
Text Domain:       gdrts-custom-rating-calculation
Version:           1.0
Requires at least: 5.0
Tested up to:      5.6
Requires PHP:      7.0
License:           GPLv3 or later
License URI:       https://www.gnu.org/licenses/gpl-3.0.html

== Copyright ==
Copyright 2008 - 2020 Milan Petrovic (email: milan@gdragon.info)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

$gdrts_crc_dirname_basic = dirname( __FILE__ ) . '/';
$gdrts_crc_urlname_basic = plugins_url( '/', __FILE__ );

define( 'GDRTS_CRC_PATH', $gdrts_crc_dirname_basic );
define( 'GDRTS_CRC_URL', $gdrts_crc_urlname_basic );

global $_gdrts_crc_core;
$_gdrts_crc_core = false;

/** Hook for the function to load the addon core. */
add_action( 'gdrts_load', 'gdrts_crc_load_addon' );
function gdrts_crc_load_addon() {
	global $_gdrts_crc_core;

	require_once( GDRTS_CRC_PATH . 'gdrts/addon.php' );

	$_gdrts_crc_core = new gdrts_crc_addon();
}

/** @return gdrts_crc_addon|boolean */
function gdrts_custom_rating_calculation() {
	global $_gdrts_crc_core;

	return $_gdrts_crc_core;
}
