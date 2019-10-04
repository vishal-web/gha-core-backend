<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Public_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation'); 
		$this->load->library('Google');

		$this->generate_navbar();
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

	public function index() {
		$this->homepage = TRUE;

		$data['homepage_banner'] = $this->get_homepage_content('homepage_banner');
		$data['homepage_course'] = $this->get_homepage_content('homepage_course');
		$data['view_file'] = 'frontend/home/index';
		$this->load->view($this->layout, $data);
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
					
					// $this->session->set_userdata('logged_in_user_data', $session_data);

					// redirect('user/dashboard');
				} else {
					$this->session->set_flashdata('flash_message', 'This email is not registered with us');
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
