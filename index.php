<?php
/*
Plugin Name: ESPN Feed
Plugin URI: http://habithq.ca
Description: Allows you to pull ESPN news data from their API
Version: 1.0
Author: Habit
Author URI: http://habithq.ca
*/

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly.');
}

require_once 'espn.class.php';

//Below is the public API for this plugin. 
//Nothing outside this file is guaranteed to be safe to use in your theme

function espn_get_nhl_headlines(){
	return ESPNPlugin::getInstance()->get_nhl_headlines();
}

function espn_get_nfl_headlines(){
	return ESPNPlugin::getInstance()->get_nfl_headlines();
}

function espn_get_nba_headlines(){
	return ESPNPlugin::getInstance()->get_nba_headlines();
}

function espn_get_ncaa_football_headlines(){
	return ESPNPlugin::getInstance()->get_ncaa_football_headlines();
}

function espn_get_mlb_headlines(){
	return ESPNPlugin::getInstance()->get_mlb_headlines();
}