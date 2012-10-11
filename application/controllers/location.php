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

		$this->load->library('GMap');

		$this->gmap->GoogleMapAPI();

		// valid types are hybrid, satellite, terrain, map
		$this->gmap->setMapType('terrain');

		$this->load->library('facebook');
		$facebook = New Facebook();
		//Add yourself
		$user_info = $facebook->getFriendInfo('me');
		$user_fb_id = $user_info['id'];
		$this->gmap->addMarkerByAddress($user_info['location']['name'], "", $user_info['name'], "", "http://graph.facebook.com/$user_fb_id/picture");
		$friend_infos = array();
		foreach($friends as $friend_id => $name) {
			$friend_info = $facebook->getFriendInfo($friend_id);
			$friend_infos[$friend_id] = $friend_info;
			if(array_key_exists('location', $friend_info)) {
			$this->gmap->addMarkerByAddress($friend_info['location']['name'], "", $friend_info['name'], "", "http://graph.facebook.com/$friend_id/picture");
			}
		}

		$this->data['headerjs'] = $this->gmap->getHeaderJS();
		$this->data['headermap'] = $this->gmap->getMapJS();
		$this->data['onload'] = $this->gmap->printOnLoad();
		$this->data['map'] = $this->gmap->printMap();
		$this->data['sidebar'] = $this->gmap->printSidebar();

		/* END google maps */
		
		$this->data['friend_infos'] = $friend_infos;
		$this->_render('pages/locations');
	}

	
}