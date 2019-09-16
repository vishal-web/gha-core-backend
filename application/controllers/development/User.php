<?php
Class User extends Backend_Controller { 
	
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		redirect(current_url().'/manage');
	}

	public function manage() { 
		$data['headline'] = 'Manage Users'; 
		$data['view_file'] = 'backend/user/manage';
		$data['edit_url'] = base_url().'development/user/create';

		$search = trim($this->input->get('search'));			
		$start_date = trim($this->input->get('start_date'));			
		$end_date = trim($this->input->get('end_date'));			

		$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
		$base_url = base_url().'development/user/manage';
		$condition = [];

		if (isset($_GET['search']) || (isset($_GET['start_date']) && isset($_GET['end_date']))) {
			$base_url .= '?query=';
		}

		if ($search !== '') {
			$condition['(r.email LIKE "%'.$search.'%" OR r.phone LIKE "%'.$search.'%")' ] = NULL;
			$base_url .= '&search='.$search; 
		}

		if ($start_date !== '' && $end_date !== '') {
			$condition['(DATE(r.created_at) >= "'.Date('Y-m-d', strtotime($start_date)) .'" AND DATE(r.created_at) <= "'.Date('Y-m-d', strtotime($end_date)).'")' ] = NULL;
			$base_url .= '&start_date='.$start_date.'&end_date='.$end_date; 
		}

		$this->load->library('pagination');
		$order_by = ['field' => 'r.id', 'type' => 'desc'];
		$limit	= 10;
		$total_result	= $this->common_model->dbselect("gha_registration",$condition, "COUNT(id) as Total")->result_array();

		$this->config->load('pagination');
		$config = $this->config->item('case2');
		$config['per_page']		= $limit;
		$config['page_query_string'] = TRUE;
		$config['total_rows']	= $total_result[0]['Total'];
		$config['base_url']		= $base_url;

		$this->pagination->initialize($config);

		$join[0]['type'] = 'left';
		$join[0]['table'] = 'gha_profession p';
		$join[0]['condition'] = 'r.profession = p.id';

		$query = $this->common_model->dbselect('gha_registration r',$condition, null, $per_page, $join, $order_by, $limit); 

		$data['query'] = $query->result_array();

		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	public function create() { 
		$update_id = (int)$this->uri->segment(4);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if ($this->input->post('submit') == 'submit') {
			if($this->form_validation->run('admin_user_create')) { 
				$insert_data = [
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'),
					'profession' => $this->input->post('profession'),
					'country' => $this->input->post('country'),
					'state' => $this->input->post('state'),
					'city' => $this->input->post('city'),
					'profession' => $this->input->post('profession'),
					'phone' => $this->input->post('phone'),
				];

				if ($update_id > 0) {
					$query = $this->common_model->dbupdate('gha_registration',$insert_data,['id' => $update_id]);
					if ($query) {
						$this->session->set_flashdata('flash_message', 'User details has been successfully updated.');
						$this->session->set_flashdata('flash_type', 'success');
						redirect(current_url());	
					}
				} else {
					$query = $this->common_model->dbinsert('gha_registration', $insert_data);
					if ($query) {
						$this->session->set_flashdata('flash_message', 'User has been successfully added.');
						$this->session->set_flashdata('flash_type', 'success');
						redirect(current_url());	
					}
				}
			}
		} else if ($this->input->post('submit') == 'cancel') {
			redirect(base_url().'development/user/manage');
		}

		$headline = 'Add New User';
		$title = 'Add User';
		if ($update_id > 0) {
			$headline = 'Update User Details';
			$title = 'Update Details';
			$getData = $this->common_model->dbselect('gha_registration', ['id' => $update_id])->result_array();
			if (empty($getData)) {
				redirect(base_url().'development/user/create');
			} else {
				$data = $getData[0];
			}
		}

		$data['headline'] = $headline; 
		$country_id = isset($data['country']) ? $data['country'] : (int)$this->input->post('country');
		$state_id = isset($data['state']) ? $data['state'] : (int)$this->input->post('state');

		$data['country_dropdown'] = $this->get_country_dropdown();
		$data['state_dropdown'] = $this->get_state_dropdown($country_id);
		$data['city_dropdown'] = $this->get_city_dropdown($state_id);
		$data['profession_dropdown'] = $this->get_profession_dropdown();

		$data['form_location'] = current_url();

		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');

		$data['title'] = $title;
		$data['view_file'] = 'backend/user/create';

		$this->load->view($this->layout, $data); 
	}

	public function view() { 
		$data['headline'] = 'User Details';
		$data['view_file'] = 'backend/user/view';
		$this->load->view($this->layout, $data); 
	}

	public function check_email_exists($str) {
		$update_id = (int)$this->uri->segment(4);

		if ($str != '') {
			$condition['email'] = $str;
			if ($update_id > 0) {
				unset($condition);
				$condition['id != ' .$update_id . ' AND email = "'.$str.'"'] = null;
			}
	
			$query = $this->common_model->dbselect('gha_registration',$condition)->result_array();

			if (!empty($query)) {

				$this->form_validation->set_message('check_email_exists', 'This email address is already exists');
				return FALSE;
			} else {
				return TRUE;
			}
		}
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


	public function get_profession_dropdown() {
		$options[''] = 'Select profession';
		$query = $this->common_model->dbselect('gha_profession')->result_array();
		foreach ($query as $row) {
			$options[$row['id']] = $row['name'];
		}
		return $options;
	}
}
?>