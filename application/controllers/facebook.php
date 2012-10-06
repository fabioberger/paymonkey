<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends CI_Controller {
		
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
	
	public function app() {
		
		
		
	}
