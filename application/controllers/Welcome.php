<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public $head_title = 'Gloobal Health Alliance';
	public $layout = 'frontend/frontend-layout';
	public $homepage = FALSE;

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation'); 
	}

	public function index() {
		$this->homepage = TRUE;
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
				];			

				$query = $this->common_model->dbinsert('gha_registration', $insert_data);

				if ($query) {
					$this->session->set_flashdata('flash_message', 'You have been successfully registred with us.');
					$this->session->set_flashdata('flash_type', 'success');
					redirect(current_url());
				}
			}
		}
		

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
		$data['view_file'] = 'frontend/home/forgot_password';
		$this->load->view($this->layout, $data);
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

	public function get_city_dropdown(int $state_id) {
		$options[''] = 'Select city';
		if ($state_id > 0) {
			$query = $this->common_model->dbselect('gha_cities', ['state_id' => $state_id])->result_array();
			foreach ($query as $row) {
				$options[$row['id']] = $row['name'];
			}
		}
		return $options;
	}
}
