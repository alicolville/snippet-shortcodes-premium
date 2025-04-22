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