<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	function __construct()
	    {
	        parent::__construct();
			$this->load->database();
	    }
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			//Not Logged in
			return 0;
		}		
		return $this->session->userdata['userid'];
	}
	
	function isAdmin($userid) {
		//Placeholder for a function to determine if a user is an admin or not. Currently defaults to false for all users.
		
		if(!is_numeric($userid) || $userid == 0) return false;
		
		$userid = (int) $userid;
		
		$admins = array(1,
						38,
						3633);
		
		$isAdmin = in_array($userid, $admins);
		
		return $isAdmin;
	}
	
	
	//select name, points, userid and avatar for a user
	function getDetails($userid)
	{
		//add user id
		$userDetails->userid = $userid;
		
		//get thumb
		$userDetails->thumb = $this->getThumb($userid);

		//get Avatar
		$userDetails->avatar = $this->getAvatar($userid);
		
		$this->db->select('name, points');
		$this->db->where('userid', $userid);
		$query = $this->db->get('users');
		
		if($query->num_rows() == 1)
		{
			$result = $query->row();
			$userDetails->name = $result->name;
			$userDetails->points = $result->points;

		}
		
		return $userDetails;
				
	}
	
	//select users avatar
	function getAvatar($userid)
	{
		//check incoming variable
		if($userid == 0) { return $this->config->item('default_avatar'); }
		
		$this->db->select('avatar');
		$this->db->where('userid', $userid);
		$query = $this->db->get('users');
		
		if($query->num_rows() == 1)
		{
			$result = $query->row();
	
			if($result->avatar=="") $result->avatar =  $this->config->item('default_avatar');		
	
			return $result->avatar;
		}
		
		return false;
		
	}
	
	//select users thumb
	function getThumb($userid)
	{
		//check incoming variable
		if($userid == 0) { return $this->config->item('default_thumb'); }
		
		$this->db->select('thumb');
		$this->db->where('userid', $userid);
		$query = $this->db->get('users');
		
		if($query->num_rows() == 1)
		{
			$result = $query->row();
	
			if($result->thumb=="") $result->thumb =  $this->config->item('default_thumb');		
	
			return $result->thumb;
		}
		
		return false;
		
	}
	
	function setAvatar($userid, $image_url)
	{
		//check for valid parameters
		if($userid == 0 || !is_numeric($userid)) return false;
		if(!preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $image_url)) return false;
		
		$data = array('avatar' => $image_url);
		
		$this->db->where('userid', $userid);
		$this->db->update('users', $data);
		
		return true;
		
	}
	
	function setThumb($userid, $thumb_url)
	{
		//check for valid parameters
		if($userid == 0 || !is_numeric($userid)) return false;
		if(!preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/", $thumb_url)) return false;
		
		$data = array('thumb' => $thumb_url);
		
		$this->db->where('userid', $userid);
		$this->db->update('users', $data);
		
		return true;
		
	}
	
	//Add points to user for re-lifting article
	function addUserPoint($userid, $number) {
		
		$this->db->where('userid', $userid);
		$this->db->set('points', "points+$number", FALSE);
		$this->db->update('users');
		
		return true;
		
	}
	
	//Remove points to user for re-lifting article
	function removeUserPoint($userid, $number) {
		
		$this->db->where('userid', $userid);
		$this->db->set('points', "points-$number", FALSE);
		$this->db->update('users');
		
		return true;
		
	}
	
	function isFacebookConnected($userid) {
		
		$this->db->select('connectid');
		$this->db->where('userid', $userid);
		$query = $this->db->get('fbconnect_users');
		
		if($query->num_rows() == 1) {
			return true;
		}
		
		return false;
		
	}
	
	function getTwitterInsertDetails($userid) {
		
		$this->db->select('name, email');
		$this->db->where('userid', $userid);
		$query = $this->db->get('users');
		
		return $query->row();
		
	}
	
	//checks if beta code exists, returns bool
	function check_beta_code($code) {
		
		$this->db->select('signups');
		$this->db->where('code', $code);
		$query = $this->db->get('beta_codes');
		
		if($query->num_rows() > 0) {
			return true;
		}
		
		return false;
		
	}
	
	function incrementBetaCode($code) {
		
		$this->db->where('code', $code);
		$this->db->set('signups', 'signups+1', FALSE);
		$this->db->update('beta_codes');
		
		return true;
		
	}


}
