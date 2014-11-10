<?php


if( ! class_exists( 'AllSpark' ) )
    require_once 'AllSpark/AllSpark.class.php';

require_once 'vendor/autoload.php';

class ESPNPlugin extends AllSpark {
	
	
	protected $settings_url = "espn-feed";
	
	
	private $option_keys = array(
		'api_key',
		'api_key_is_ok'
	);
	
	function admin_enqueue_scripts($url){
		if( 'settings_page_espn-feed' == $url )
			wp_enqueue_style( 'allspark' );
	}
	
	function handle_form_post_for_url($url){
		if( 'settings_page_espn-feed' == $url ) {
			$this->set_api_key($_POST['api_key']);
			$this->test_api();
		}
	}
	
	protected function set_api_key($key){
		return update_option(__CLASS__ . 'api_key', $key);
	}
	
	protected function get_api_key(){
		return get_option(__CLASS__ . 'api_key');
	}
	
	protected function test_api(){
		$result = $this->do_api_call( 'http://api.espn.com/v1/sports', false );
		$okay = ( $result && isset( $result->status ) && 'success' == $result->status );
		update_option( __CLASS__ . 'api_key_is_ok', $okay );
		return $okay;
	}
	
	/* Public API Bits */
	public function get_nhl_headlines(){
		return $this->do_rss_call( 'http://sports.espn.go.com/espn/rss/nhl/news' );
	}
	
	public function get_nfl_headlines(){
		return $this->do_rss_call( 'http://sports.espn.go.com/espn/rss/nfl/news' );
	}
	
	public function get_nba_headlines(){
		return $this->do_rss_call( 'http://sports.espn.go.com/espn/rss/nba/news' );
	}
	
	public function get_ncaa_football_headlines(){
		return $this->do_rss_call( 'http://sports.espn.go.com/espn/rss/ncf/news' );
	}
	
	public function get_mlb_headlines(){
		return $this->do_rss_call( 'http://sports.espn.go.com/espn/rss/mlb/news' );
	}
	
	private function do_rss_call( $url, $cacheFor = 60){
		try{
			$key = sha1($url);
		
			//If we don't have a transient, OR we want to ignore the cache
			if( ! get_transient( $key ) || $cacheFor === false ){
		
				$feed = new SimplePie();
				$feed->enable_cache(false);
				$feed->set_feed_url($url);
				$feed->init();
		
				$headlines = array();
		
				foreach ($feed->get_items() as $item){
					$headline = new stdClass();
					$headline->headline = $item->get_title();
					$headline->description = $item->get_content();
					$headline->link = $item->get_permalink();
			
					$headlines[] = $headline;
				}
			
				set_transient( $key, $headlines, $cacheFor );
			}
		
			return get_transient( $key );
		}
		catch(Exception $ex){
			return false;
		}
	}
	
	private function do_api_call( $url, $cacheFor=60 ){
		$key = sha1($url);
		$url .= "?apikey=" . $this->get_api_key();
		
		//If we don't have a transient, OR we want to ignore the cache
		if( ! get_transient( $key ) || $cacheFor === false ){
			$response = wp_remote_get( $url );
			$reply = json_decode( $response['body'] );
			
			$headlines = array();
			if( isset( $reply->headlines ) )
				$headlines = $reply->headlines;
			
			set_transient( $key, $headlines, $cacheFor );
		}
		
		return get_transient( $key );
	}
}


ESPNPlugin::getInstance();
