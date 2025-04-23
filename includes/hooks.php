<?php

/**
 * Run installer on each version number change or install
 */
function yk_ss_upgrade() {

	if ( true === update_option( 'yk-ss-version-number-2025', YK_SS_PLUGIN_VERSION ) ) {
		do_action( 'yk-ss-upgrade' );
	}
}
add_action('admin_init', 'yk_ss_upgrade');

/**
* Add license page to the admin menu 
*/	
function yk_ss_menu_add_license_page() {

	$text = ( false === sh_cd_is_premium() ) ? __( 'Upgrade to Premium', SH_CD_SLUG ) : __( 'Your License', SH_CD_SLUG );

	add_submenu_page( 'sh-cd-shortcode-variables-main-menu', $text, $text, 'manage_options', 'sh-cd-shortcode-variables-license', 'sh_cd_advertise_pro');
}
add_action( 'sh-cd-admin-menu-upgrade', 'yk_ss_menu_add_license_page');	