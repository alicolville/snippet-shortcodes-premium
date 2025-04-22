<?php

/**
 * Is the main plugin enabled?
 * @return bool
 */
function yk_ss_is_main_plugin_enabled() {
    return defined( 'SH_CD_ABSPATH' );
}