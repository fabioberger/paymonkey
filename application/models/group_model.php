<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_model extends CI_Model {
	
	function __construct()
	    {
	        parent::__construct();
			$this->load->database();
	    }

	 function create_group($userid) {

	 	$data = array(
	 		'lead_userid' => $userid,
	 		'payment' => 0,
	 		'num_payees' => 0
	 		);

	 	$insert = $this->db->insert('groups', $data);

	 	if(!$insert) { return false; } 
		
		$group_id = $this->db->insert_id();

		return $group_id;

	 }

	 function add_group_payer($groupid, $userid) {

	 	$this->db->select('paymentid');
		$this->db->where('userid', $userid);
		$this->db->where('groupid', $groupid);
		$query = $this->db->get('group_payers');

		$result = $query->num_rows();

		if($result == 0) { 

		 	$data = array(
		 		'userid' => $userid,
		 		'groupid' => $groupid,
		 		'paid' => 0
		 		);

		 	$insert = $this->db->insert('group_payers', $data);

		 	if(!$insert) { return false; }

		 } 

	 	return true;

	 }

	 function add_num_payees($group_id, $number_payers) {

	 	$data = array(
	 		'num_payers' => $number_payers
	 		);

	 	$this->db->where('groupid', $group_id);
	 	$this->db->update('groups', $data);

	 }

}