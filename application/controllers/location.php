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
		
		$this->data['friends'] = $friends;
		$this->_render('pages/locations');
	}

	
}