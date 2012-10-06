<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Friend_model extends CI_Model {

	function __construct()
	    {
	        parent::__construct();
			$this->load->database();
	    }


	function add_friend($name, $fbid) {

		$this->db->select('name');
		$this->db->where('fbid', $fbid);
		$query = $this->db->get('users');

		$result = $query->num_rows();

		if($result == 0) { 

			$new_member_insert_data = array(
				'name' => $name,
				'email' => '',
				'username' => '',
				'password' => '',
				'fbid' => $fbid
			);
			
			$insert = $this->db->insert('users', $new_member_insert_data);
			
			if(!$insert) { return false; } 

		}
		
		return true;

	}


}

?>