<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends MY_Controller {
	
	public function friend_locations(){
		$this->title = "Locations";
		
		$this->load->model('friend_model');
		$userid = $this->session->userdata['userid'];
		$allfriends = $this->input->post('allfriends');
		$temp_friends = explode(",", $allfriends);
		$friends = array();
		for ($i=0; $i < count($temp_friends); $i=$i+2) { 
			if ($temp_friends[$i] != '') {
				$fbid = $temp_friends[$i];
				$name = $temp_friends[($i+1)];
				$friends[$fbid] = $name;
			}
		}

		$this->load->library('facebook');
		$facebook = New Facebook();
		$friend_infos = array();
		foreach($friends as $friend_id => $name) {
			$friend_info = $facebook->getFriendInfo($friend_id);
			$friend_infos[$friend_id] = $friend_info;
		}
		
		$this->data['friend_infos'] = $friend_infos;
		$this->_render('pages/locations');
	}

	
}