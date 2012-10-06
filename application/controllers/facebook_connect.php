<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook_connect extends CI_Controller {
		
	public function __construct()
	{
		parent::__construct();
		//load in the facebook library
		$this->load->library('facebook');
		$this->load->library('imagelibrary');
		$this->load->model('user_model');
		
		$this->avatar_dir = "/var/www/resources/images/user_thumb/";
		$this->avatar_dir_link = base_url() . "resources/images/user_thumb/";
		$this->thumb_postfix = "_thumb";
	}
	
	public function post_comment() {
		
		$comment = "I cant believe this just happened!";
		$newsid = 1716;
		
		$facebook = New Facebook();
		
		$result = $facebook->postComment($comment, $newsid);
		
		print_r($result);
		/*
		if($result != false) {
			echo "success!";
		}
		else {
			echo "failed";
		}
		*/
		
	}
	
	
	public function connect() {
		
		$facebook = new Facebook();
		
		$fb_userid = $facebook->getUser();

		if( $fb_userid )
		{
			// Proceed knowing you have a logged in user who's authenticated.
			//now validate the user on our end
			$validated = $this->_validateUser($fb_userid);
			if($validated == true) {
					redirect('/'); 
				}
		}
		else {
			//error logging in user
			$this->session->set_userdata('error', 'failed');
			redirect('/');
		}	
		
	}
	
	//validate a user (check if registered then log them in)
	public function _validateUser($fb_userid) {
		
		$facebook = new Facebook();
		
		$this->load->library('userLib');
		$userLib = new UserLib();
		
		$this->load->model('facebook_model');
		
		//load users details
		$userInfo = $facebook->getBasicInfo();
		
		//check if already Facebook connected
		$userid = $this->facebook_model->check_fbconnect_user($fb_userid);
		
		//check if user with this email exists
		$email_used = $userLib->check_email($userInfo['email']);
		
		//if email but not FB connect, tell them to use normal credentials to login
		if($email_used == true && $userid == false) {
			return "already";
		}
		
		//If user is a facebook connected user, login user
		if($userid != 0) {
			
			//login the old user
			return $userLib->loginWithUserid($userid);
			
		}
		
		//If not, create user
		$userid = $this->create_user($fb_userid, $userInfo);

		//login the new user
		return $userLib->loginWithUserid($userid);
		
		
	}
	
	private function create_user($fb_userid, $userInfo) {
		
		$facebook = new Facebook();
		$this->load->library('userLib');
		$userLib = new UserLib();
		
		$name = $userInfo['name'];
		$email = $userInfo['email'];
		
		//make a randomly generated password
		$password = md5(rand());
		
		//creates both user and joomla user
		$userid = $userLib->create_member($name, $email, $password);
		
		$userLib->store_fbconnect($userid, $fb_userid);
		
		//import users avatar/thumb
		$this->processFacebookPhotos($userid);
		
		//store fb metrics (age/gender)
		//$userMetrics = $facebook->getUserMetrics();
		//$this->facebook_model->storeUserMetrics($userid, $userMetrics);
		
		return $userid;
		
	}
	
	//process and store user avatar and thumb
	private function processFacebookPhotos($userid) {
		
		$facebook = new Facebook();
		
		//grab and process FB profile photo as avatar
		$avatar_basic = array('full_url' => '', 'thumb_url' => '');
		
		//set users avatar & thumb
		$avatar_remote = $facebook->getUserAvatar();
		if($avatar_remote) {
			$avatar_basic['full_url'] = $avatar_remote;
			$avatar = $this->processFBAvatar($avatar_remote, $userid);
			
			if(!$avatar) $avatar = $avatar_basic;
		}
		
		$this->user_model->setAvatar($userid, $avatar['full_url']);
		$this->user_model->setThumb($userid, $avatar['thumb_url']);
		
		return true;
		
	}
	
	
	public function login_redirect() {
		
		$facebook = new Facebook();
		
		$loginUrl = $facebook->loginUrl();
		
		redirect($loginUrl);
		//echo $loginUrl;
		
	}
	
	public function processFBAvatar($avatar_url, $userid) {
		
		if($avatar_url=="") return false;
		if(!is_numeric($userid) || $userid == "0") return false;
		
		$imagelibrary = new Imagelibrary();
		
		if(!$imagelibrary->checkURLIsImage($avatar_url)) return false;
			
		$imgname = "user".$userid.".jpg";
		$thumbname = "user".$userid.$this->thumb_postfix.".jpg";
		
		$image_target = $this->avatar_dir . $imgname;
		$thumb_target = $this->avatar_dir . $thumbname;
		
		$local_imgpath = $imagelibrary->storeRemoteImage($avatar_url, $this->avatar_dir, true, $imgname);
		
		if(!$local_imgpath) return false;
		
		if(!$imagelibrary->createAvatar($local_imgpath, $image_target, $format="jpg")) return false;
		if(!$imagelibrary->createThumb($local_imgpath, $thumb_target, $format="jpg")) return false;
		
		$local_url = $this->avatar_dir_link . $imgname;		
		$thumb_url = $this->avatar_dir_link . $thumbname;
		
		$avatar['full_url']  = $local_url;
		$avatar['thumb_url'] = $thumb_url;
		
		return $avatar;
	}
	
}