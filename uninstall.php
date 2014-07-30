<?php

//http://codex.wordpress.org/Function_Reference/register_uninstall_hook
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

delete_option( 'ESPNPluginapi_key' );
delete_option( 'ESPNPluginapi_key_is_ok' );
