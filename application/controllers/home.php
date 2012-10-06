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
		$this->load->model('friend_model');

		$allfriends = $this->input->post('allfriends');
		$temp_friends = explode(",", $allfriends);
		for ($i=0; $i < count($temp_friends); $i=$i+2) { 
			if($temp_friends[$i] != '') {
				$fbid = $temp_friends[$i];
				$name = $temp_friends[($i+1)];
				$friends[$fbid] = $name;
				$this->friend_model->add_friend($name, $fbid);
			}
		}


		$this->data['friends'] = $friends;
		$this->title = "Dashboard";
		$this->_render('pages/dashboard');
	}
	
	public function monkey_form(){
		$this->title = "MonkeyForm";
		$this->css[] = "datepicker.css";
		$this->css[] = "monkey_form.css";
		$this->javascript[] = "bootstrap-datepicker.js";
		$this->javascript[] = "monkey_form.js";
		$this->_render('pages/monkey_form');
	}
}