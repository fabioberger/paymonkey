<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserLib {
	
	var $CI = null;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('user_model');
		$this->CI->load->model('userlib_model');
	}

	public function getUser($userid) {

		if(empty($userid) || !is_int($userid)) return false;

		$user = $this->CI->user_model->getDetails($userid);

		return $user;
	}

	public function getPaid($userid, $groupid) {

		if(empty($groupid) || !is_int($groupid)) return false;
		if(empty($userid) || !is_int($userid)) return false;

		$paid = (float) $this->CI->user_model->getPaid($userid, $groupid);

		return $paid;
	}

	public function getIndividualAmount($groupid) {

		if(empty($groupid) || !is_int($groupid)) return false;

		$total_amt = (float) $this->CI->user_model->getTotalAmt($groupid);
		$num_payers = (float) $this->CI->user_model->getNumPayers($groupid);

		$amt = $total_amt / $num_payers;

		return $amt;
	}

	public function setEmail($userid, $email) {

		if(empty($userid) || !is_int($userid)) return false;

		$success = $this->CI->user_model->setEmail($userid, $email);

		return $success;
	}


	public function setPaid($payerid, $groupid, $paid, $unix_time) {

		if(empty($payerid) || !is_int($payerid)) return false;
		if(empty($groupid) || !is_int($groupid)) return false;

		$success = $this->CI->user_model->setPaid($payerid, $groupid, $paid, $unix_time);

		return $success;
	}
	
	
	public function loginWithUserid($userid) {
		
		//$this->CI->userlib_model->setLoginTime($userid);
		
		$data = array(
			'userid' => $userid,
			'is_logged_in' => true
		);
		$this->CI->session->set_userdata($data);
		
		if($this->CI->session->userdata('userid') == 0) {
			return false;
		}
		
		return true;
		
	}
	
	//both login and check if there is an action to perform after signup
	public function loginAndCheck($userid) {
		
		$this->loginWithUserid($userid);
		$newsid = $this->checkReminderActions($userid);
		
		return $newsid;
	}
	
	public function validate($email, $plaintext_password)
	{
			
		//get password and userid associated with email/username	
		$userData = $this->CI->userlib_model->getUserData($email);
		if($userData == false) { return false; }
		
		//Explode password to get salt and hash and user helper to encrypt plaintext password
		$parts	= explode(':', $userData->password);
		$crypt	= $parts[0];
		$salt	= @$parts[1];
		
		$this->CI->load->helper('password_helper');
		
		$testcrypt = getCryptedPassword($plaintext_password, $salt);
		
		//Check it the two passwords are the same
		if($crypt == $testcrypt) {
			
			return $userData->userid;
			
		}
		
		return false;
		
	}
	
	//create a wall user
	//type is kind of signup (facebook, google, normal)
	//$thirdpartid is either the connectid or openid if needed
	public function create_member($name, $email, $password)
	{
		
		//check username uniqueness
		$temp_username = strtolower(str_replace(" ", ".", $name));
		$username = $this->check_username($temp_username);
				
		//create encrypted password
		$password = $this->create_encrypted_password($password);
		
		//Insert the userdata into DB and return the userid
		$userid = $this->CI->userlib_model->createUser($name, $email, $username, $password);
		
		//store user source
		//$this->CI->userlib_model->store_source($userid);
		
		//Add first Login
		//$this->CI->userlib_model->setLoginTime($userid);
		
		return $userid;
				
	}
	
	//create password entry (salt and encryption)
	private function create_encrypted_password($password) {
		
		$this->CI->load->helper('password_helper');
		
		$salt  = md5((rand()*rand()));
		$crypt = getCryptedPassword($password, $salt);
		$password = $crypt.':'.$salt;
		
		return $password;
		
	}
	
	public function checkReminderActions($userid) {
		
		$reminder_cookie = $this->CI->input->cookie('reminder', TRUE);
		
		if($reminder_cookie == "") { return 0; }
		
		$reminder = explode('|', $reminder_cookie);
		
		$type = $reminder[0];
		
		$newsid = $reminder[1];
		
		//load article model
		$this->CI->load->model('article_model');
		
		setcookie("reminder", "", time() - 3600, "/", ".5feeds.com");
		
		if($type == 'lift') {
			//Add lift point, vote, collection
			$this->CI->article_model->addArticleLift($newsid, $userid);
			return $newsid;
		}
		elseif($type == 'comment') {
			$comment = urldecode($reminder[2]);
			//Add comment to article
			$comment_posted = $this->CI->article_model->addComment($newsid, $userid, $comment);
			return $newsid;
		}
		
		return 0;
		
	}
	
	public function check_username($username) {
		
		//get number of times the username appears in the DB
		$usernameCount = $this->CI->userlib_model->getUsernameCount($username);
		
		if($usernameCount >= 1) {
			
			$similarUsernames = $this->CI->userlib_model->getSimilarUsernames($username);
			
			$largestNumber = 1;
			foreach ($similarUsernames as $result) {
				$unPieces = explode($username, $result['username']);
				$potentialNum = array_pop($unPieces);
				if(is_numeric($potentialNum) && $potentialNum > $largestNumber) {
					$largestNumber = $potentialNum;
				}
			}
			
			$nextNumber = $largestNumber + 1;
			
			return $username.$nextNumber;
			
		}
		
		return $username;
		
	}
	
	//checks if email already in use. If yes, returns true
	public function check_email($email) {
		
		$emailCount = $this->CI->userlib_model->getEmailCount($email);
		
		if($emailCount >= 1) {
			return true;
		}
		
		return false;
		
	}
	
	public function store_fbconnect($userid, $fbconnectid) {
		
		$this->CI->userlib_model->store_fbconnect_users($userid, $fbconnectid);
		
		return true;
	}
	
	public function store_openid($userid, $openid) {
		
		$this->CI->userlib_model->store_openid_users($userid, $openid);
		
		return true;
		
	}
	
	
}
