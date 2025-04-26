<?php

defined('ABSPATH') or die('Jog on!');

/**
 * Check the core plugin has been enabled, if not, display message
 */
function yk_ss_prompt_to_install_standard_plugin() {

	if ( true === defined( 'SH_CD_GET_PREMIUM_LINK' ) ) {
		return;
	}

	printf('<div class="notice notice-error yk-ss-notice-missing-core-plugin">
				<p><strong>%1$s</strong>: %2$s</p>
			</div>',
			esc_html( YK_SS_PLUGIN_NAME ),
			__( 'To access the premium features, you’ll also need to install and activate the core plugin, "Snippet Shortcodes". You can either install the plugin via the plugins screen or by downloading it from <a href="https://wordpress.org/plugins/shortcode-variables/" target="_blank">WordPress.org</a>.', YK_SS_SLUG )
    );
}
add_action( 'admin_notices', 'yk_ss_prompt_to_install_standard_plugin' );