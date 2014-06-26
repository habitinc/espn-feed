<?php

include('AllSpark.class.php');

class ESPNPlugin extends AllSpark
{
	
	protected $settings_url = "espn-feed";
	private $option_keys = array(
		'api_key',
		'api_key_is_ok'
	);
	
	public function admin_menu(){
		$self = $this;
	
		$ret = add_options_page( 'ESPN Feed', 'ESPN Feed', 'moderate_comments', $this->settings_url, function() use($self){
			$self->addUI('ui/admin.php');
		});	
	}

	function enqueue_items_for_url($url){
		switch($url){
			case 'settings_page_espn-feed':
				wp_enqueue_style( 'allspark' );
			break;
		}
	}
	
	function handle_form_post_for_url($url){
		switch($url){
			case 'settings_page_espn-feed':
				$this->set_api_key($_POST['api_key']);
				$this->test_api();
			break;
		}
	}
		
	function pluginWillBeDeleted(){
	
		//Clean up all the option keys
		foreach($this->option_keys as $key){
			delete_option(__CLASS__ . $key);
		}
	}
	
	/* Public API Bits */
	public function get_nhl_headlines(){
		return $this->do_api_call('http://api.espn.com/v1/sports/hockey/nhl/news/headlines')->headlines;
	}
	
	public function get_nfl_headlines(){
		return $this->do_api_call('http://api.espn.com/v1/sports/football/nfl/news/headlines')->headlines;
	}
	
	public function get_nba_headlines(){
		return $this->do_api_call('http://api.espn.com/v1/sports/basketball/nba/news/headlines')->headlines;
	}
	
	public function get_ncaa_football_headlines(){
		return $this->do_api_call('http://api.espn.com/v1/sports/football/college-football/news/headlines')->headlines;
	}
	
	public function get_mlb_headlines(){
		return $this->do_api_call('http://api.espn.com/v1/sports/baseball/mlb/news/headlines')->headlines;
	}
	
	protected function set_api_key($key){
		return update_option(__CLASS__ . 'api_key', $key);
	}
	
	protected function get_api_key(){
		return get_option(__CLASS__ . 'api_key');
	}
	
	protected function test_api(){
		$val = ($this->do_api_call('http://api.espn.com/v1/sports/news/headlines/top', false) !== false);
		update_option(__CLASS__ . 'api_key_is_ok', $val);
		return $val;
	}
	
	private function do_api_call($url, $cacheFor = 60){
		
		$key = sha1($url);
		$url .= "?apikey=" . $this->get_api_key();
				
		//If we don't have a transient, OR we want to ignore the cache
		if(!get_transient($key) || $cacheFor === false){
			$response = wp_remote_get( $url );
			set_transient($key, json_decode($response['body']), $cacheFor);
		}
		
		return get_transient($key);
	}
}

//Fire it up
ESPNPlugin::getInstance();

?>