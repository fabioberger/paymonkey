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
		$this->_render('pages/reference');
	}

	public function pick_friends(){
		$this->title = "Pick Friends";
		$this->css[] = "pick_friends.css";
		$this->javascript[] = "pick_friends.js";
		$this->load->library('facebook');
		$facebook = New Facebook();
		$friends = $facebook->getFriends();
		$this->data['friends'] = $friends;
		$this->_render('pages/pick_friends');
	}
	
	public function monkey_form(){
		$this->title = "MonkeyForm";
		$this->css[] = "datepicker.css";
		$this->css[] = "monkey_form.css";
		$this->javascript[] = "bootstrap-datepicker.js";
		$this->javascript[] = "monkey_form.js";
		
		$this->load->model('friend_model');
		$this->load->model('group_model');
		$userid = $this->session->userdata['userid'];
		$group_id = $this->group_model->create_group($userid);
		$allfriends = $this->input->post('allfriends');
		$temp_friends = explode(",", $allfriends);
		$friends = array();
		for ($i=0; $i < count($temp_friends); $i=$i+2) { 
			if ($temp_friends[$i] != '') {
				$fbid = $temp_friends[$i];
				$name = $temp_friends[($i+1)];
				$friends[$fbid] = $name;
				$friend_userid = $this->friend_model->add_friend($name, $fbid);
				$this->group_model->add_group_payer($group_id, $friend_userid);
			}
		}
		$num_users = count($friends);
		$this->group_model->add_num_payees($group_id, $num_users);
		
		$this->data['group_id'] = $group_id;
		$this->_render('pages/monkey_form');
	}

	public function dashboard() {
		$this->title = "Monkey Dashboard";
		$this->css[] = "dashboard.css";
		
		$date = $this->input->post('date');
		$amount = $this->input->post('amount');
		$paypal_email = $this->input->post('paypal_email');
		$group_id = $this->input->post('group_id');
		$this->load->model('group_model');
		$this->group_model->add_group_details($group_id, $date, $amount, $paypal_email);
		
		$this->data['members'] = $this->group_model->get_group_members($group_id);
		$this->_render('pages/dashboard');
	}
}