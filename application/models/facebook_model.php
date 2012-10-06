<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook_model extends CI_Model {
	
	function __construct()
	    {
	        parent::__construct();
			$this->load->database();
	    }
	
	//check if the given user has already Facebook Connected
	function check_fbconnect_user($fb_userid)
	{
		$this->db->select('userid');
		$this->db->where('connectid', $fb_userid);
		$query = $this->db->get('fbconnect_users');
		
		if($query->num_rows() >= 1) {
			$result = $query->row();
			return $result->userid;
		}
		
		return false;
		
	}
	
	//store users facebook metric data
	public function storeUserMetrics($userid, $userData) {
		
		$bday = explode("/", $userData['birthday_date']);
		
		$date = date("Y-m-d H:i:s", mktime(0, 0, 0, $bday[1], $bday[0], $bday[2]));
		
		$data = array(
		               	'userid' => $userid,
						'sex' => $userData['sex'],
						'birthday' => $date
		            );

		$this->db->insert('fbconnect_userdata', $data);
		
		return true;
		
	}
	
	public function storeFBAction($actiontype, $newsid, $userid, $fbid) {
		
		$date = date("Y-m-d H:i:s");

		$data = array(
		               	'userid' => $userid,
						'actiontype' => $actiontype,
						'newsid' => $newsid,
						'fbid' => $fbid,
						'date' => $date
		            );

		$this->db->insert('fb_actions', $data);

		return true;

	}
	
	public function getFBActions($userid, $number) {
		
		$query = $this->db->query("SELECT newsid, MONTHNAME(date) as month, DAY(date) as day, actionid FROM sw_fb_actions WHERE userid = '$userid' ORDER BY UNIX_TIMESTAMP(date) DESC LIMIT 0, $number");
		$result = $query->result();
		
		return $result;
	}
	
	//gets the action FB Id from actions table
	public function getFBId($actionid) {
		
		$query = $this->db->query("SELECT fbid FROM sw_fb_actions WHERE actionid = '$actionid'");
		$result = $query->row();
		
		return $result->fbid;
		
	}
	
	public function delete_fb_action($actionid) {
		
		$this->db->delete('fb_actions', array('actionid' => $actionid));
		
		return true;
		
	}
	
}

