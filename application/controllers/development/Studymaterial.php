<?php
class Studymaterial extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function manage() { 
		$data['headline'] = 'Manage Material'; 
		$data['view_file'] = 'backend/studymaterial/manage';
		$data['edit_url'] = $data['add_url'] = base_url().'development/studymaterial/create'; 

		$search = trim($this->input->get('search'));			
		$start_date = trim($this->input->get('start_date'));			
		$end_date = trim($this->input->get('end_date'));			

		$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
		$base_url = base_url().'development/studymaterial/manage';
		$condition = [];

		if (isset($_GET['search']) || (isset($_GET['start_date']) && isset($_GET['end_date']))) {
			$base_url .= '?query=';
		}

		if ($search !== '') {
			$condition['(sm.email LIKE "%'.$search.'%" OR sm.phone LIKE "%'.$search.'%")' ] = NULL;
			$base_url .= '&search='.$search; 
		}

		if ($start_date !== '' && $end_date !== '') {
			$condition['(DATE(sm.created_at) >= "'.Date('Y-m-d', strtotime($start_date)) .'" AND DATE(sm.created_at) <= "'.Date('Y-m-d', strtotime($end_date)).'")' ] = NULL;
			$base_url .= '&start_date='.$start_date.'&end_date='.$end_date; 
		}

		$this->load->library('pagination');
		$order_by = ['field' => 'sm.id', 'type' => 'desc'];
		$limit	= 10;
		$total_result	= $this->common_model->dbselect("gha_study_material",$condition, "COUNT(id) as Total")->result_array();

		$this->config->load('pagination');
		$config = $this->config->item('case2');
		$config['per_page']		= $limit;
		$config['page_query_string'] 	= TRUE;
		$config['total_rows']	= $total_result[0]['Total'];
		$config['base_url']		= $base_url;

		$this->pagination->initialize($config);

		$join = [
			[
				'type' => 'LEFT',
				'table' => 'gha_courses c',
				'condition' => 'c.id = sm.course_id',
			]
		];
		$select_data = ['c.title as course_title', 'sm.*'];
		$query = $this->common_model->dbselect('gha_study_material sm',$condition, $select_data, $per_page,$join, $order_by, $limit); 
		$data['query'] = $query->result_array();

		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	public function create() { 
		$update_id = (int)$this->uri->segment(4);

		$headline = 'Add New Study Material';
		if ($update_id > 0) {
			$headline = 'Update Study Material Details';
			$getData = $this->common_model->dbselect('gha_study_material', ['id' => $update_id])->result_array();
			if (empty($getData)) {
				redirect(base_url().'development/studymaterial/create');
			} else {
				$data = $getData[0];
			}
		}

		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if ($this->input->post('submit') == 'submit') {
			if($this->form_validation->run('admin_studymaterial_create')) {

				$material_type = $this->input->post('material_type');

				$insert_data = [
					'course_id' => 	$this->input->post('course_id'),
					'type' => 	$this->input->post('material_type'), 
					'status' => 	$this->input->post('status'),
					'created_at' => Date('Y-m-d H:i:s'),
				];
				
				$study_material = $this->input->post('study_material');

				$image_err = 0;

				if (in_array($material_type, ['ppt','pdf','img','doc'])) {
					$allowed_types = $material_type == 'pdf' ? 'pdf|csv' : null;
					$upload_path = './uploads/studymaterial';
					
					if ($material_type == 'pdf') {
						$upload_path .= '/pdf';
					} else if ($material_type == 'img') {
						$upload_path .= '/img';
					}

					$do_upload = $this->do_upload('featured_image', $upload_path, $allowed_types);
					
					if ($update_id > 0) {
						if (isset($_FILES['featured_image']['name']) && $_FILES['featured_image']['name'] !== '' ) {
							$image_err = $do_upload['err']; 
							$featured_image = isset($do_upload['file_name']) ? $do_upload['file_name'] : $data['study_material'];
						} else {
							$featured_image = $data['study_material'];
						}
					} else {
						$image_err = $do_upload['err'];
						$featured_image = isset($do_upload['file_name']) ? $do_upload['file_name'] : '';
					}

					$study_material = $featured_image;
				}

				$insert_data['study_material'] = $study_material;

				if ($image_err == 0 ) {
					if ($update_id > 0) {
						$query = $this->common_model->dbupdate('gha_study_material',$insert_data,['id' => $update_id]);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Study Material details has been successfully updated.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					} else {
						$query = $this->common_model->dbinsert('gha_study_material', $insert_data);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Study Material has been successfully added.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					}	
				} else { 
					$data['featured_image_error'] = $do_upload['error_message'];
				}
			}
		}
					
		if ($this->input->post('submit') == 'cancel') {
			redirect(base_url().'development/studymaterial/manage');
		}


		$data['headline'] = $headline;  
		$data['form_location'] = current_url();
		$data['course_dd'] = $this->get_courses_dd();
		$data['material_dd'] = get_material_dd();

		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
 
		$data['view_file'] = 'backend/studymaterial/create';
		$data['update_id'] = $update_id;
		$this->load->view($this->layout, $data); 
	}

	public function is_url_title_exists($url_title, $update_id) {
		$condition['url_title'] = $url_title;
		if ($update_id > 0) {
			$condition['id !='] = $update_id;
		}

		$query = $this->common_model->dbselect('gha_study_material',$condition)->result_array();
		return !empty($query) ? true : false;
	}

	public function generate_url_title($url_title, $update_id) {
		$random_string = $this->generate_random_string(6);
		$url_title .= '-'.strtolower($random_string); 


		$is_url_title_exists = $this->is_url_title_exists($url_title, $update_id);
		if ($is_url_title_exists) {
			$this->generate_url_title($url_title, $update_id);
		} else {
			return $url_title;
		}
	}

	public function donot_change_course($str) {
		$update_id = (int)$this->uri->segment('4');
		if ($update_id > 0) {
			$condition['id'] = $update_id;
			$condition['course_id'] = $str;
			$query = $this->common_model->dbselect('gha_study_material',$condition)->result_array();
			if (empty($query)) {
				$this->form_validation->set_message('donot_change_course','You are not allowed to change course while doing update.');
				return FALSE;
			}
		}

		return TRUE;
	}

	public function generate_random_string($length = 8) {
		$characters = '123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
		  $randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	private function get_courses_dd() {
		$order_by['field'] = 'title';
		$order_by['type'] = 'asc';
		$query = $this->common_model->dbselect('gha_courses',  ['status' => 1],null,null,null,$order_by)->result_array();
		$options[''] = 'Choose Course';
		if (!empty($query)) {
 			foreach ($query as $row) {
 				$options[$row['id']] = $row['title'];
			}	
		}

		return $options;
	}
}
?>