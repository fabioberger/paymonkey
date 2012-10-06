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

	public function pick_friends(){
		$this->load->library('facebook');
		$facebook = New Facebook();
		$friends = $facebook->getFriends();
		$this->css[] = "pick_friends.css";
		$this->javascript[] = "pick_friends.js";
		$this->data['friends'] = $friends;
		$this->_render('pages/pick_friends');
	}

	public function add_friends(){
		$allfriends = $this->input->post('allfriends');
		$temp_friends = explode(",", $allfriends);
		foreach($temp_friends as $friend) {
			if($friend != "") {
 				$pieces = explode("|", $friend);
				$friends[$pieces[0]] = $pieces[1];
			}
		}

		$this->data['friends'] = $friends;
		$this->title = "Dashboard";
		$this->_render('pages/dashboard');
	}
	
	public function monkey_form(){
		$this->title = "MonkeyForm";
		$this->css[] = "monkey_form.css";
		$this->javascript[] = "monkey_form.js";
		$this->_render('pages/monkey_form');
	}
}