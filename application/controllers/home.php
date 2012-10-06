<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

	public function index(){

		$this->title = "PayMonkey";
		$this->_render('pages/homepage');

	}
	
	public function reference(){	
		
		/*
		 *set up title and keywords (if not the default in custom.php config file will be set) 
		 */
		$this->title = "Yaaaaa";
		$this->keywords = "arny, arnodo";
		
		$this->_render('pages/home');
	}

	public function pick_friends() {

		$this->load->library('facebook');

		$facebook = New Facebook();

		$friends = $facebook->getFriends();

		$this->data['friends'] = $friends;

		$this->_render('pages/pick_friends');


	}


	
}