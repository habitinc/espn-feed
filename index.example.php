<?php
/*
Plugin Name: My Great Plugin
Plugin URI: http://ignitionmedia.ca
Description: Provides some sweet functionality
Version: 1.0
Author: Ignition Media
Author URI: http://ignitiomedia.ca
*/

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly.');
}

require_once 'myplugin.class.php';
$plugin = new MyPlugin();
