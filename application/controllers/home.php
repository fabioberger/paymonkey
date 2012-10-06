<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	public function index(){
		$this->title = "PayMonkey";
		$this->css[] = "home.css";
		$this->_render('pages/homepage');
	}

	public function reference(){
		$this->title = "Yaaaaa";
		$this->keywords = "arny, arnodo";
		$this->_render('pages/home');
	}

	public function pick_friends() {
		$this->load->library('facebook');
		$facebook = New Facebook();
		$friends = $facebook->getFriends();
		$this->css[] = "pick_friends.css";
		$this->javascript[] = "pick_friends.js";
		$this->data['friends'] = $friends;
		$this->_render('pages/pick_friends');
	}

	public function add_friends() {

		$friends = $this->input->post('allfriends');

		$this->data['friends'] = $friends;
		$this->title = "Dashboard";
		$this->_render('pages/dashboard');
	}
}