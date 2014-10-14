<?php
/*
Plugin Name: Custom Field Suite - Synchronize
Plugin URI: https://wordpress.org/plugins/custom-field-suite/
Description: Synchronize postmeta with CFS
Version: 0.1
Author: Matt Gibbs
Author URI: https://facetwp.com/

Copyright 2014 Matt Gibbs

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/

defined( 'ABSPATH' ) or exit;

class CFS_Synchronize
{

    function __construct() {
        add_action( 'init', array( $this, 'init' ), 12 );
    }


    /**
     * Initialize classes and WP hooks
     */
    function init() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }


    /**
     * Register the FacetWP settings page
     */
    function admin_menu() {
        add_submenu_page( 'edit.php?post_type=cfs', 'Synchronize', 'Synchronize', 'manage_options', 'cfs-sync', array( $this, 'settings_page' ) );
    }


    /**
     * Route to the correct edit screen
     */
    function settings_page() {
        include( dirname( __FILE__ ) . '/templates/page-settings.php' );
    }
}


$cfs_sync = new CFS_Synchronize();
