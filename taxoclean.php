<?php

/*
 * Plugin Name: Taxoclean
 * Plugin URI: https://www.taxoclean.com
 * Description: Helps you to cleanup your taxonomies
 * Version: 1.0.3
 * Author: Artwhere
 * Author URI: https://www.artwhere.eu
 * License: GPLv3
 * Text Domain: taxoclean
 *
 *
*/

/*
Taxoclean is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.
Taxoclean is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Taxoclean. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
*/

require_once __DIR__ . '/vendor/autoload.php';

add_action( 'init', function() {
	load_plugin_textdomain( 'taxoclean', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
});

include_once "includes/activation.php";
include_once "includes/ajax.php";
include_once "includes/functions.php";

add_action( "admin_menu", function() {
	require_once __DIR__ .'/vendor/autoload.php';
	include_once "includes/translations.php";
	include_once "includes/wp_add_to_menu.php";
	include_once "includes/tabs/taxoclean_l.php";
	include_once "includes/tabs/taxoclean_o.php";
	include_once "includes/tabs/taxoclean_s.php";
	include_once "includes/tabs/taxoclean_l_ignores.php";
	include_once "includes/tabs/taxoclean_a.php";
});