<?php

	class Authentication extends Public_Controller {

		public function __construct() {
			parent::__construct();
			$this->load->library('google');
		}

		public function google() {
			$code = $this->input->get('code');
			if ($code == '') {
				redirect(base_url());
			}

			if ($this->google->getAuthenticate($code)) {
				$userInfo = $this->google->getUserInfo(); 
				$checkUser = $this->common_model->dbselect('gha_registration',['oauth_provider' => 'google', 'oauth_uid' => $userInfo['id']])->result_array();

				if (empty($checkUser)) {
					$insert_data = [
						'oauth_provider' => 'google',
						'oauth_uid' => $userInfo['id'],
						'firstname' => $userInfo['name'], 
						'email' => $userInfo['email'],
						'profile_picture' => isset($userInfo['picture']) ? $userInfo['picture'] : '',
						'profession' => 4, 
						'status' => 1,
						'created_at' => Date('Y-m-d H:i:s'),
					];

					$regUser = $this->common_model->dbselect('gha_registration',['email' => $userInfo['email']])->result_array();
					
					if (empty($regUser)) {			
						$query = $this->common_model->dbinsert('gha_registration', $insert_data);
						if ($query) {
							$insert_id = $this->db->insert_id();
						}
					} else {
						$insert_id = $regUser[0]['id'];	
						$this->common_model->dbupdate('gha_registration',['oauth_provider' => 'google', 'oauth_uid' => $userInfo['id']], ['id' => $insert_id]);
					}
					
					$checkUser = $this->common_model->dbselect('gha_registration',['id' => $insert_id])->result_array();
				}

				$session_data = [
					'user_logged_in' => true,
					'user_id' => $checkUser[0]['id'],
					'user_name' => $checkUser[0]['firstname'],
					'user_email' => $checkUser[0]['email'],
					'logged_in_date' => date('Y-m-d H:i:s a'),
				];

				$this->session->set_userdata('logged_in_user_data', $session_data);

				$this->logged_in_history($checkUser[0]['id'], 'user');
				$this->move_local_cart_items_to_user_cart();
				if ($checkUser[0]['city'] == 0 || $checkUser[0]['state'] == 0 || $checkUser[0]['country'] == 0) {
					redirect('user/profile');
				}
				
				redirect('user/dashboard');
			}else {
				redirect(base_url());
			}
		} 

		public function facebook() {

		}
	}
?>