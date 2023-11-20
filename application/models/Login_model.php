<?php defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendors/autoload.php';
class Login_model extends CI_Model {
	private $fb_app_id = '2502322560038825';
	private $fb_app_secret = 'ea032ac4128c4be5ac995df8b71319a4';
	private $fb_version = 'v5.0';
	private $fb_callback = 'member/fb_callback';

	private $g_CLIENT_ID = '16568070192-on37ujqtbr9muklp0ti63shepps9e8fg.apps.googleusercontent.com';
	private $g_CLIENT_SECRET = 'KncEd8x4zDTMpdGKXcELBJEA';
	private $g_CLIENT_REDIRECT_URL = 'member/g_callback';

	private $loginpage = 'login';

	private $member_table = 'user';

	function __construct(){
		parent::__construct ();

		$this->g_CLIENT_REDIRECT_URL = base_url().$this->g_CLIENT_REDIRECT_URL;
	}

	public function login($data){
		$data["isLogin"] = $this->encryption->encrypt(md5("uLogIn"));

		$this->session->set_userdata($data);
	}

	public function is_login(){
		if (!($this->session->isLogin && $this->encryption->decrypt($this->session->isLogin) == md5("uLogIn"))) {
			header("Location: ".base_url());
		}
	}

	public function register($data, $is_exist = FALSE){
		if ($is_exist) {
			$this->db->where(array("email"=>$data['email']));
			return $this->db->update($this->member_table, $data);
		}else{
			return $this->db->insert($this->member_table, $data);
		}
	}

	/*
	GOOGLE LOGIN
	 */
	
	public function g_login(){
		$login_url = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me') . '&redirect_uri=' . urlencode($this->g_CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . $this->g_CLIENT_ID . '&access_type=online';

		header("Location: ".$login_url);
	}

	public function g_callback(){
		if($this->input->get("code")) {
			try {
				// Get the access token 
				$data = $this->g_GetAccessToken($this->g_CLIENT_ID, $this->g_CLIENT_REDIRECT_URL, $this->g_CLIENT_SECRET, $this->input->get("code"));
				$user_info = $this->g_GetUserProfileInfo($data['access_token']);
				return array(
					"name"	=>	$user_info['displayName'],
					"id"	=>	$user_info['id'],
					"email"	=>	$user_info['emails'][0]['value'],
					"pic"	=>	$user_info['image']['url']
				);
			}
			catch(Exception $e) {
				echo $e->getMessage();
				exit();
			}
		}
	}

	private function g_GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {	
		$url = 'https://accounts.google.com/o/oauth2/token';			
		
		$curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		curl_setopt($ch, CURLOPT_POST, 1);		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);	
		$data = json_decode(curl_exec($ch), true);
		$http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to receieve access token');
			
		return $data;
	}

	private function g_GetUserProfileInfo($access_token) {	
		$url = 'https://www.googleapis.com/plus/v1/people/me';			
		
		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, $url);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
		$data = json_decode(curl_exec($ch), true);
		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);		
		if($http_code != 200) 
			throw new Exception('Error : Failed to get user information');
			
		return $data;
	}

	/*
	FB LOGIN
	 */
	
	public function fb_login(){
		if (!session_id()) {
		    session_start();
		}
		$fb = new Facebook\Facebook([
            'app_id' => $this->fb_app_id,
		    'app_secret' => $this->fb_app_secret,
		    'default_graph_version' => $this->fb_version,
        ]);

        $helper = $fb->getRedirectLoginHelper();

		$permissions = ['public_profile','email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(base_url().$this->fb_callback, $permissions);
        header("Location: ".$loginUrl);
	}

	public function fb_callback(){
		$fb = new Facebook\Facebook([
            'app_id' => $this->fb_app_id,
		    'app_secret' => $this->fb_app_secret,
		    'default_graph_version' => $this->fb_version,
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
        	//嚴格模式下，要代入callback的url
        	$accessToken = $helper->getAccessToken(base_url().$this->fb_callback);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
	        echo 'Graph returned an error: ' . $e->getMessage();
	        header("Location: ".base_url().$this->loginpage);
	        exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
        	echo 'Facebook SDK returned an error: ' . $e->getMessage();
        	header("Location: ".base_url().$this->loginpage);
        	exit;
        }

        if (! isset($accessToken)) {
	        if ($helper->getError()) {
	            header('HTTP/1.0 401 Unauthorized');
	            echo "Error: " . $helper->getError() . "\n";
	            echo "Error Code: " . $helper->getErrorCode() . "\n";
	            echo "Error Reason: " . $helper->getErrorReason() . "\n";
	            echo "Error Description: " . $helper->getErrorDescription() . "\n";
	            header("Location: ".base_url().$this->loginpage);
	        } else {
	            header('HTTP/1.0 400 Bad Request');
	            echo 'Bad request';
	        }
	        exit;
        }

		$response = $fb->get('/me?fields=id,name,email,picture.type(large)', $accessToken->getValue());
		$user = $response->getGraphUser();
		return $user;
		// $user['name'];
		// $user['id'];
		// $user['email'];
	}
}