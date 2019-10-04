<?php 
	

	class Google { 
		public function __construct() {
			$CI =& get_instance();
			$CI->load->library('session');
			$CI->load->helper('url');
			$CI->config->item('google');
			
			require_once FCPATH.'vendor/autoload.php';

			$this->client = new Google_Client();
			$this->client->setClientId($CI->config->item('client_id', 'google'));
			$this->client->setClientSecret($CI->config->item('client_secret', 'google'));
			$this->client->setRedirectUri(base_url($CI->config->item('redirect_uri', 'google')));
			$this->client->setAccessType('online');
			$this->client->setApprovalPrompt('auto');
			$this->client->setScopes(
				array(
					"https://www.googleapis.com/auth/plus.login",
					"https://www.googleapis.com/auth/plus.me",
					"https://www.googleapis.com/auth/userinfo.email",
					"https://www.googleapis.com/auth/userinfo.profile"
				)
			);
			$this->oauth2 = new Google_Service_Oauth2($this->client);
		}

		public function getUrl() {
			return $this->client->createAuthUrl();
		}

		public function getAuthenticate($code) {
			return $this->client->authenticate($code);
		}

		public function getAccessToken() {
			return $this->client->getAccessToken();
		}

		public function setAccessToken() {
			return $this->client->setAccessToken();
		}

		public function revokeToken() {
			return $this->client->revokeToken();
		}

		public function getUserInfo() {
			return $this->oauth2->userinfo->get();
		}
	}
?>