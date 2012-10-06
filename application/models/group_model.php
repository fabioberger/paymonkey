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
	 		'total_amt' => 0,
	 		'num_payers' => 0
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
		$query = $this->db->get('payments');

		$result = $query->num_rows();

		if($result == 0) { 

		 	$data = array(
		 		'userid' => $userid,
		 		'groupid' => $groupid,
		 		'paid' => 0
		 		);

		 	$insert = $this->db->insert('payments', $data);

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

	 function add_group_details($group_id, $date, $amount, $paypal_email) {

	 	$data = array(
	 		'total_amt' => $amount,
	 		'paypal_email' => $paypal_email,
	 		'date' => $date
	 		);

	 	$this->db->where('groupid', $group_id);
	 	$this->db->update('groups', $data);


	 }

	function get_group_members($group_id) {
		$this->db->select('userid');
		$this->db->where('groupid', $group_id);
		$query = $this->db->get('payments');
		$result = $query->row_data();
		print_r($result);
		return array();
	}
}