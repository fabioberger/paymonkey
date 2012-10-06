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
	/*
	stdClass Object ( [paymentid] => 691 [userid] => 681 [groupid] => 371 [paid] => 0 [paid_date] => 0000-00-00 00:00:00 [pay_amt] => 0 ) stdClass Object ( [paymentid] => 701 [userid] => 1 [groupid] => 371 [paid] => 0 [paid_date] => 0000-00-00 00:00:00 [pay_amt] => 0 ) stdClass Object ( [paymentid] => 711 [userid] => 691 [groupid] => 371 [paid] => 0 [paid_date] => 0000-00-00 00:00:00 [pay_amt] => 0 ) ­
	*/
		$query = $this->db->get_where('payments', array('groupid' => $group_id));
		$users = array();
		foreach ($query->result_array() as $row) {
			$users[$row['userid']] = $row['userid'];
		}
		if (!$users) {
			return array();
		}
		$this->db->select('*');
		$this->db->where_in('userid', $users);
		$query = $this->db->get('users');
		foreach ($query->result_array() as $full_user_data) {
			$users[$full_user_data['userid']] = $full_user_data;
		}
		var_dump($users);
		return $users;
	}
}