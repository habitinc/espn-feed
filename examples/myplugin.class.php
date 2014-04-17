<?php

include('AllSpark.class.php');

class MyPlugin extends AllSpark
{
	public function __construct(){
		//If you're overriding __construct, ensure that you call it's parent's initializer
		parent::__construct();
		$this->listen_for_api_action('my_api_action', 'do_api_action');	
	}

	//function that will be called when visiting the /my_api_action URL
	protected function do_api_action(){
			
	}
}
?>