<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//Load Facebook PHP SDK
include_once "facebook/facebook.php";

class Facebook {

	var $facebook = null; //facebook sdk object
	var $CI = null;
	
	public function __construct()
	{
				$this->CI =& get_instance();
				
				//Load all Facebook Configs
				$this->CI->load->config('facebook');
				
				
			    // Create our FB Application instance.
			    $this->facebook = new FacebookLib(array(
			      'appId'  => $this->CI->config->item('fb_appid'),
			      'secret' => $this->CI->config->item('fb_secret'),
			      'cookie' => true,
			    ));
	}
	
	
	//Gets users Facebook Userid
	public function getUser()
	{

			try
			{
				$user	= $this->facebook->getUser();
			}
			catch( FacebookApiException $exception )
			{
				return false;
			}
			
		return $user;
	
	}
	
	public function postArticle($article) {
		
		$user = $this->getUser();
						
		$params = array('access_token'=>$this->facebook->getAccessToken(), 'article'=>$article);
										
		$return = $this->facebook->api("/$user/news.reads", 'post', $params);
		
		return $return;
		
		
	}
	
	public function keepArticle($article) {
		
		$user = $this->getUser();
						
		$params = array('access_token'=>$this->facebook->getAccessToken(), 'article'=>$article);
										
		$return = $this->facebook->api("/$user/elesecret:keep", 'post', $params);
		
		return $return;
		
		
	}
	
	//delete an action from someone's facebook account
	public function deleteAction($fbid) {
								
		$params = array('access_token'=>$this->facebook->getAccessToken());
										
		$return = $this->facebook->api("/$fbid", 'delete', $params);
		
		return true;
	}
	
	public function postComment($comment, $newsid) {
		
		$user = $this->getUser();
		
		$this->CI->load->model('article_model');
		$article = $this->CI->article_model->getArticleMeta($newsid);
		
		$params = array('access_token'=>$this->facebook->getAccessToken(), 'message' =>$comment, 'picture' => $article['img'], 'link' => $article['url'], 'name' => $article['title']);
										
		$return = $this->facebook->api("/$user/feed", 'post', $params);
		
		return $return;
		
	}
	
	//Get users basic info
	public function getBasicInfo() {
		
		$user = $this->getUser();
		
		$userInfo = $this->facebook->api("/$user");
		
		return $userInfo;
		
	}
	
	//make FQL Query on a user
	//$fields is an array of properties (sex, pic_squre, hometown_location)
	public function getUserInfo( $fields , $fb_userid )
	{
		$fql	= 'select ' . implode( ',' , $fields ) . ' from user where uid=' . $fb_userid;

		$param	= array( 'method'	=> 'fql.query',
						 'query'	=> $fql,
						 'callback'	=> ''
						);
		$result	= $this->facebook->api( $param );

		if( isset($result['pic_square']) && empty($result['pic_square'] ) )
		{
			$result['pic_square']	= rtrim( JURI::root() , '/' ) . '/' . $this->CI->config->item('default_avatar');
		}
		$result	= isset( $result[0] ) ? $result[0] : false;

		return $result;
	}
	
	//Get a users avatar
	public function getUserAvatar() {
		
		$user = $this->getUser();
		
		$fields = array('pic_big');
		
		$fb_array = $this->getUserInfo($fields, $user);
		
		return $fb_array['pic_big'];
	}
	
	//returns an array for the stored user metrics (sex, birthday) as of now
	public function getUserMetrics() {
		
		$user = $this->getUser();
		
		$fields = array('sex', 'birthday_date');
		
		$fb_array = $this->getUserInfo($fields, $user);
		
		return $fb_array;
		
	}

	public function getFriends() {
		
		$user	= $this->facebook->getUser();
		
		try 
		{
			$friends = $this->facebook->api('/me/friends');
			
			return $friends;
		}
		catch (FacebookApiException $e)
		{
			return false;
		}
		
	}

	
	//generates Facebook Login URL
	public function loginUrl() {
		
		$loginUrl   = $this->facebook->getLoginUrl(
	            array(
	                'scope'         => 'email,publish_stream,user_birthday',
	                'redirect_uri'  => $this->CI->config->item('fb_baseurl')
	            )
	    );
	
		return $loginUrl;
		
	}
	

	//generates Facebook Logout URL
	public function logoutUrl() {
		
		return $this->facebook->getLogoutUrl();
		
	}
	
	
}