<?php

/**
 * Is the main plugin enabled?
 * @return bool
 */
function yk_ss_is_main_plugin_enabled() {

    // Using this constant as it wouldn't exist in the main plugin pre-split
    return defined( 'SH_CD_GET_PREMIUM_LINK' ); 
}