<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlib_model extends CI_Model {
	
	function __construct()
	    {
	        parent::__construct();
			$this->load->database();
	    }
	
	function setLoginTime($userid) {
		
		$loginData = array(
			'userid' => $userid,
			'timestamp' => date("Y-m-d H:i:s")
		);
		
		$this->db->insert('login_log', $loginData);
		
		return true;
		
	}
	
	function createUser($name, $email, $username, $password) {
		
		$new_member_insert_data = array(
			'name' => $name,
			'email' => $email,
			'username' => $username,
			'password' => $password
		);
		
		$insert = $this->db->insert('users', $new_member_insert_data);
		
		if(!$insert) { return false; } 
		
		$userid = $this->db->insert_id();
		
		return $userid;
		
	}
	
	function getSimilarUsernames($username) {
		
		$this->db->select('username');
		$this->db->like('username', $username); 
		$query = $this->db->get('users');
		
		return $query->result_array();
	}
	
	function getUsernameCount($username) {
		
		$this->db->where('username', $username);
		$query = $this->db->count_all_results('users');
		
		return $query;
		
	}
	
	function getEmailCount($email) {
		
		$this->db->where('email', $email);
		$query = $this->db->count_all_results('users');
		
		return $query;
		
	}
	
	function getUserData($email) {
		
		//check if input is email or username
		$is_email = strpos($email, '@');
		
		//Get hashed password associated with this email
		$this->db->select('userid, password');
		if($is_email) {
			$this->db->where('email', $email);
		}
		else {
			$this->db->where('username', $email);
		}
		
		$query = $this->db->get('users');
		
		if($query->num_rows() == 0) { return false; }
		
		$result = $query->row();
		
		return $result;
		
	}
	
	//Store the source details of a user (UTM google analytic variables and country ip)
	function store_source($userid) {
		
		$ci =& get_instance();
		$ci->load->helper('gacookie_helper');
		
		$utm_variables = parseGA_utmz();
		
		$data = array(
			'userid' => $userid,
			'utm_source' => $utm_variables['source'],
			'utm_campaign' => $utm_variables['campaign'],
			'utm_medium' => $utm_variables['medium'],
			'utm_content' => $utm_variables['content'],
			'utm_term' => $utm_variables['term'],
			'first_landing' => '(none)',
			'pageref' => '(none)',
			'country' => '(none)',
			'registerdate' => date("Y-m-d H:i:s")
		);

		$this->db->insert('source', $data);
		
		return true;
		
	}
	
	//stores info in fbconnect_id table
	function store_fbconnect_users($userid, $fb_userid) {
		
		$data = array(
		   'connectid' => $fb_userid ,
			'userid' => $userid
		);

		$this->db->insert('fbconnect_users', $data);
		
		return true;
		
	}
	
	//stores info in fbconnect_id table
	function store_openid_users($userid, $openid) {
		
		$data = array(
		   'openid' => $openid ,
			'userid' => $userid,
			'type' => 'google'
		);

		$this->db->insert('openid_users', $data);
		
		return true;
		
	}
	

}