<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Plugin Name: Snippet Shortcodes - Premium features
 * Description: The Premium version of Snippet Shortcodes. This plugin is required for the Premium version to work.
 * Version: 1.0
 * Requires at least:   6.0
 * Tested up to: 		6.8
 * Requires PHP:        7.4
 * Author:              Ali Colville
 * Author URI:          https://www.YeKen.uk
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         snippet-shortcodes-premium
 */

/*  Copyright 2025 YeKen.uk

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'YK_SS_ABSPATH', plugin_dir_path( __FILE__ ) );

define( 'YK_SS_PLUGIN_VERSION', '1.0' );
define( 'YK_SS_PLUGIN_NAME', 'Snippet Shortcodes - Premium' );
define( 'YK_SS_SLUG', 'snippet-shortcodes-premium' );

include_once YK_SS_ABSPATH . 'includes/functions.php';

add_action( 'plugins_loaded', function() {

    include_once YK_SS_ABSPATH . 'includes/standard-plugin-check.php';

    if ( yk_ss_is_main_plugin_enabled() ) {

        include_once YK_SS_ABSPATH . 'includes/cron.php';
        include_once YK_SS_ABSPATH . 'includes/hooks.php';
        include_once YK_SS_ABSPATH . 'includes/license.php';
        include_once YK_SS_ABSPATH . 'includes/shortcode.presets.premium.php';
        include_once YK_SS_ABSPATH . 'includes/pages/page.license.php';
        
    }

});    

