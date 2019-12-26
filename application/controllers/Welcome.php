<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Public_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation'); 
		$this->load->library('Google');
		$this->generate_navbar();
	}


	public function run_custom_ghahealth_query() {
		$this->load->helper('form');

		$submit = $this->input->post('submit');
		$query = $this->input->post('query');
		if ($submit === 'Submit' && $query) {
			$mysql_query = $this->db->query($query);

			echo '<pre>';
			print_r($mysql_query->result_array());
			echo '</pre>';
			// die();
		}
		
		$query = $this->input->post('query');


		echo form_open(current_url());
		echo form_label('Query : ').'<br>';
		echo form_textarea('query').'<br>';;
		echo form_submit('submit', 'Submit');
		echo form_close();
	}

	public function index() {
		$this->homepage = TRUE;

		$data['homepage_banner'] = $this->get_homepage_content('homepage_banner');
		$data['homepage_course'] = $this->get_homepage_content('homepage_course');
		$data['homepage_reviews'] = $this->get_student_reviews();
		$data['homepage_upcoming_courses'] = $this->get_upcoming_courses();
		
		$data['view_file'] = 'frontend/home/index';
		$this->load->view($this->layout, $data);
	}

	private function get_homepage_content($content_type) {
		
		if ($content_type == 'homepage_banner') {
			$condition['type'] = $content_type;
			$condition['status'] = 1;
			$query = $this->common_model->dbselect('gha_homepage',$condition)->result_array();
		}
		
		if ($content_type == 'homepage_course') {
			$condition['h.type'] = $content_type;
			$condition['h.status'] = 1;
			$condition['c.status'] = 1;
			$join = [
				['type' => 'left', 'condition' => 'h.course_id = c.id', 'table' => 'gha_courses c']
			];

			$select_data = ['h.*', 'c.title as course_title','c.url_title'];
			$query = $this->common_model->dbselect('gha_homepage h',$condition, $select_data, null, $join)->result_array();
		}
		
		return $query;
	}

	private function get_student_reviews() {
		$select_data = [
      "CONCAT(reg.firstname, ' ', reg.lastname) as name", 
      'reg.email', 
      'reg.profile_picture', 
      'rev.id',
      'rev.review',
      'rev.status',
      'rev.created_at',
    ];
    $join = [
      ['type' => 'left', 'condition' => 'reg.id = rev.user_id', 'table' => 'gha_registration reg']
    ];
    $start = 0;
    $condition['rev.status'] = 1;

    $query = $this->common_model->dbselect('gha_reviews rev', $condition, $select_data, $start, $join);
    return $query->result_array(); 
	}

	private function get_upcoming_courses() {
		$query = $this->common_model->dbselect('gha_courses', ['upcoming_course' => 1]);
    return $query->result_array(); 
	}

	public function ghaadmin() {
		echo "ghaAdmin Panel will be here";
	}

	public function login() {

		$submit = $this->input->post('submit');
		
		if ($submit == 'submit') {
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			if ($this->form_validation->run()) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$condition = ['email' => $email, 'password' => $password];

				$query = $this->common_model->dbselect('gha_registration', $condition)->result_array();

				if (!empty($query)) {
					$session_data = [
						'user_logged_in' => true,
						'user_id' => $query[0]['id'],
						'user_name' => $query[0]['firstname'],
						'user_email' => $query[0]['email'],
						'logged_in_date' => date('Y-m-d H:i:s a'),
					];

					$this->logged_in_history($query[0]['id'], 'user');

					$this->session->set_userdata('logged_in_user_data', $session_data);
					$this->move_local_cart_items_to_user_cart();
					redirect('user/dashboard');
				} else {
					$this->session->set_flashdata('flash_message', 'You have entered invalid login details');
					$this->session->set_flashdata('flash_type', 'danger');
					redirect(current_url());
				}

			}	
		}
		
		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
		$data['view_file'] = 'frontend/home/login';
		$this->load->view($this->layout, $data);
	}

	public function register() {

		$submit  = $this->input->post('submit');

		if ($submit === 'submit') {
			$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('profession', 'Profession', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[gha_registration.email]', ['is_unique' => 'Email already exists.']);
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('country', 'Country', 'trim|required');
			$this->form_validation->set_rules('state', 'State', 'trim|required');
			$this->form_validation->set_rules('city', 'City', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			if ($this->form_validation->run()) {
				$insert_data = [
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'),
					'country' => $this->input->post('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city'),
					'phone' => $this->input->post('phone'),
					'profession' => $this->input->post('profession'), 
					'password' => $this->input->post('password'), 
					'created_at' => Date('Y-m-d H:i:s'),
				];			

				$query = $this->common_model->dbinsert('gha_registration', $insert_data);

				if ($query) {
					$this->session->set_flashdata('flash_message', 'You have been successfully registred with us.');
					$this->session->set_flashdata('flash_type', 'success');
					redirect(current_url());
				}
			}
		}
		
		$data['google_login_url'] = $this->google->getUrl();
		$data['country'] = $this->input->post('country');
		$data['state'] = $this->input->post('state');
		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
		$data['country_dropdown'] = $this->get_country_dropdown();
		$data['state_dropdown'] = $this->get_state_dropdown((int)$data['country']);
		$data['city_dropdown'] = $this->get_city_dropdown((int)$data['state']);
		$data['profession_dropdown'] = $this->get_profession_dropdown();
		$data['view_file'] = 'frontend/home/register';
		$this->load->view($this->layout, $data);
	}

	public function forgot_password() {
		$this->session->unset_userdata('otp');
		$submit = $this->input->post('submit');
		
		if ($submit == 'submit') {
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			if ($this->form_validation->run()) {
				$email = $this->input->post('email'); 
				$condition = ['email' => $email]; 
				$query = $this->common_model->dbselect('gha_registration', $condition)->result_array();

				if (!empty($query)) {
					$session_data = [
						'user_logged_in' => true,
						'user_id' => $query[0]['id'],
						'user_name' => $query[0]['firstname'],
						'user_email' => $query[0]['email'],
						'logged_in_date' => date('Y-m-d H:i:s a'),
					];
					
					$otp = generate_random_string(6);
					$message = 'You have requested a password change. Your otp is <b>'.$otp.'</b>.<br />';
					$mail_data = ['view_file' => 'mailer/otp_verification', 'message' => $message];
					$mail_message = $this->load->view('mailer/mailer-layout',$mail_data,true);
					$mail_sent = send_mail($query[0]['email'], 'Ghahealth Change Password', $mail_message);
					
					$otpData = [
						'otp' => $otp,
						'user_id' => $query[0]['id'], 
						'type' => 'changePassword',
						'mail_sent' => $mail_sent,
						'created_at' => Date('Y-m-d H:i:s'),
					];

					
					if ($this->db->insert('gha_otp', $otpData)) {
						$otpData['id'] = $this->db->insert_id();	
						$otpData['user_email'] = $query[0]['email'];	
						$this->session->set_userdata('otp', $otpData);
						$this->session->set_flashdata('flash_message', 'We have sent you an otp on your registered email');
						$this->session->set_flashdata('flash_type', 'success');
					} else {	
						$this->session->set_flashdata('flash_message', 'Something went wrong.');
						$this->session->set_flashdata('flash_type', 'danger');
					}

					redirect('verify-otp');
				} else {
					$this->session->set_flashdata('flash_message', 'Email is not registered with us');
					$this->session->set_flashdata('flash_type', 'danger');
					redirect(current_url());
				} 
			}	
		}

		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
		$data['view_file'] = 'frontend/home/forgot-password';
		$this->load->view($this->layout, $data);
	}

	public function verify_otp() {
		$otp_session_data = $this->session->userdata('otp');
		if (empty($otp_session_data)) {
			redirect('forgotpassword');
		}
	
		$submit = $this->input->post('submit');
		if ($submit == 'submit') {
			$this->form_validation->set_rules('otp', 'otp', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			if ($this->form_validation->run()) {
				$otp = $this->input->post('otp');
				
				$condition['otp'] = $otp;
				$condition['id'] = $otp_session_data['id'];

				$query = $this->common_model->dbselect('gha_otp', $condition)->result_array();
				
				if (!empty($query)) {
					$newpass = generate_random_string('6');
					$updateQuery = $this->common_model->dbupdate('gha_registration', ['password' => $newpass] , ['id' => $otp_session_data['user_id']]);

					$message = 'You have successfully changed your password. Your new password is ' . $newpass;
					$mail_data = ['view_file' => 'mailer/otp_verification', 'message' => $message];
					$mail_message = $this->load->view('mailer/mailer-layout',$mail_data,true);
					$mail_sent = send_mail($otp_session_data['user_email'], 'Ghahealth Change Password', $mail_message);
				
					$this->session->set_flashdata('flash_message', 'Your password has been changed successfully and Please check your mail we have sent your new password on your email.');
					$this->session->set_flashdata('flash_type', 'success'); 
					redirect('login');
				} else {
					$this->session->set_flashdata('flash_message', 'Please enter a valid otp.');
					$this->session->set_flashdata('flash_type', 'danger');
					redirect(current_url());
				} 
			}	
		}

		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
		$data['view_file'] = 'frontend/home/verify-otp';
		$this->load->view($this->layout, $data);		
	}

	public function admin_login() {
		$submit = $this->input->post('submit');
		
		if ($submit == 'submit') {
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
			if ($this->form_validation->run()) {
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				if ($email == 'admin@gmail.com' && $password == 'admin@ghahealth') {
					$set_session = [
						'admin_id' => 1,
						'admin_user_name' => 'admin',
						'admin_logged_in' => true,
						'admin_logged_in_time' => Date('Y-m-d H:i:s'),
					];

					$this->logged_in_history('1', 'admin');
					
					$this->session->set_userdata('logged_in_admin_data', $set_session);

					redirect(base_url().'development/dashboard');
				} else {
					$data['error'] = 1;
					$data['error_message'] = 'Email & password is not correct';
				}
			}
		}

		$data['view_file'] = 'frontend/home/admin-login';
		$this->load->view('frontend/home/admin-login', $data);
	}

	public function get_profession_dropdown() {
		$options[''] = 'Select profession';
		$query = $this->common_model->dbselect('gha_profession')->result_array();
		foreach ($query as $row) {
			$options[$row['id']] = $row['name'];
		}
		return $options;
	}

	public function get_country_dropdown() {
		$query = $this->common_model->dbselect('gha_countries')->result_array();
		$options[''] = 'Select country';
		foreach ($query as $row) {
			$options[$row['id']] = $row['name'];
		}
		return $options;
	}

	public function get_state_dropdown($country_id) {
		$options[''] = 'Select state';
		if ($country_id > 0) {
			$query = $this->common_model->dbselect('gha_states', ['country_id' => $country_id])->result_array();
			foreach ($query as $row) {
				$options[$row['id']] = $row['name'];
			}
		}
		return $options;
	}

	public function get_city_dropdown($state_id) {
		$options[''] = 'Select city';
		if ($state_id > 0) {
			$query = $this->common_model->dbselect('gha_cities', ['state_id' => $state_id])->result_array();
			foreach ($query as $row) {
				$options[$row['id']] = $row['name'];
			}
		}
		return $options;
	}

	// miscellaneous
	public function updateColumn() {

		$mysql_query = "SHOW tables";
		$query = $this->db->query($mysql_query)->result_array();
		
		foreach ($query as $row) {
			// $mysql_query = "SHOW COLUMNS FROM ".$row['Tables_in_kKTPrkjIvj']." LIKE 'started_at'";
			// $column_query = $this->db->query($mysql_query)->result_array();

			$mysql_query = "SHOW CREATE TABLE ".$row['Tables_in_kKTPrkjIvj'];
			$column_query = $this->db->query($mysql_query)->result_array();
			echo $row['Tables_in_kKTPrkjIvj'].'<hr>';
			echo '<pre>';
			print_r($column_query);
			echo '</pre>';
			
			// echo '<pre>';
			// print_r($row['Tables_in_kKTPrkjIvj']);
			// echo '</pre>';

			
			// if (!empty($column_query)) {
			// 	$mysql_query = "ALTER TABLE ".$row['Tables_in_kKTPrkjIvj']." MODIFY started_at DATETIME DEFAULT NULL";
			// 	$alter_query = $this->db->query($mysql_query);
				
			// }
		}

		die();
	}
}
