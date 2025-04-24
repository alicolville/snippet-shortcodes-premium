<?php

defined('ABSPATH') or die("Jog on!");

// Fetch the existing license from WP Options and run it through validation again.
function yk_ss_cron_licence_check() {
;
	$existing_license = yk_ss_license();

	yk_ss_license_apply( $existing_license );
}
add_action( 'daily', 'yk_ss_cron_licence_check' );
add_action( 'sh-cd-upgrade', 'yk_ss_cron_licence_check' );
add_action( 'yk-ss-upgrade', 'yk_ss_cron_licence_check' );