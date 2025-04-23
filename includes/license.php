<?php

	defined('ABSPATH') or die('Jog on!');
	
	/**
	 * Let the main plugin know whether we have a Premium license or not
	 */
	add_filter( 'sh-cd-license-is-premium', function() { 
		return (bool) get_option( 'sh-cd-license-valid', false );
	});

	/**
	 *	Check an existing license's hash is still valid
	 **/
	function yk_ss_license_validate( $license ) {

		if ( true === empty( $license ) ) {
			return __( 'License missing', 'snippet-shortcodes-premium' );
		}

		// Decode license
		$license = yk_ss_license_decode( $license );

		if ( true === empty( $license ) ) {
			return __( 'Could not decode / verify license', 'snippet-shortcodes-premium' );
		}

		// Does site hash in license meet this site's actual hash?
		if ( true === empty( $license['site-hash'] ) ) {
			return __( 'Invalid license hash', 'snippet-shortcodes-premium' );
		}

		// Match this site hash?
		if ( sh_cd_generate_site_hash() !== $license['site-hash']) {
			return __( 'This license doesn\'t appear to be for this site (no match on site hash).', 'snippet-shortcodes-premium' );
		}

		// Valid date?
		$today_time = strtotime( date( 'Y-m-d' ) );
		$expire_time = strtotime( $license['expiry-date'] );

		if ( $expire_time < $today_time ) {
			return __( 'This license has expired.', 'snippet-shortcodes-premium' );
		}

		return true;
	}

	/**
	 * Validate and decode a license
	 **/
	function yk_ss_license_decode( $license ) {

		if( true === empty( $license ) ) {
			return NULL;
		}

		// Base64 and JSON decode
		$license = base64_decode( $license );

		if( false === $license ) {
			return NULL;
		}

		$license = json_decode( $license, true );

		if( true === empty( $license ) ) {
			return NULL;
		}

		// Validate hash!
		$verify_hash = md5( 'yeken.uk' . $license['type'] . $license['expiry-days'] . $license['site-hash'] . $license['expiry-date'] );

		return ( $license['hash'] == $verify_hash && false === empty( $license ) ) ? $license : NULL;
	}


	/**
	 * Validate and apply a license
	 **/
	function yk_ss_license_apply( $license ) {

		// Validate license
		$license_result = yk_ss_license_validate($license);

		if( true === $license_result ) {

			update_option( 'sh-cd-license', $license );
			update_option( 'sh-cd-license-valid', true );

			return true;
		}

		return false;
	}

	/**
	 * Remove a license
	 **/
	function yk_ss_license_remove() {

		delete_option( 'sh-cd-license' );
		delete_option( 'sh-cd-license-valid' );
	}

	/**
	 * Fetch license
	 *
	 * @return mixed
	 */
	function yk_ss_license() {
		return get_option( 'sh-cd-license', '' );
	}