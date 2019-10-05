<?php
class Course extends Backend_Controller {
	
	public function __construct() {
		parent::__construct();
	}

	public function test() {
		$dir  = './uploads/course/thumb';
		if (is_writable($dir)) {
			echo 'Yes';
		} else {
			echo 'No';
		}

		// $image = '7f9fd61b2714077fb4df4f8c7d6f2269.png';
		// $this->create_thumbnail($image);
	}

	public function manage() { 
		$data['headline'] = 'Manage Courses'; 
		$data['view_file'] = 'backend/course/manage';
		$data['edit_url'] = base_url().'development/course/create';

		$search = trim($this->input->get('search'));			
		$start_date = trim($this->input->get('start_date'));			
		$end_date = trim($this->input->get('end_date'));			

		$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
		$base_url = base_url().'development/course/manage';
		$condition = [];

		if (isset($_GET['search']) || (isset($_GET['start_date']) && isset($_GET['end_date']))) {
			$base_url .= '?query=';
		}

		if ($search !== '') {
			$condition['(email LIKE "%'.$search.'%" OR phone LIKE "%'.$search.'%")' ] = NULL;
			$base_url .= '&search='.$search; 
		}

		if ($start_date !== '' && $end_date !== '') {
			$condition['(DATE(created_at) >= "'.Date('Y-m-d', strtotime($start_date)) .'" AND DATE(created_at) <= "'.Date('Y-m-d', strtotime($end_date)).'")' ] = NULL;
			$base_url .= '&start_date='.$start_date.'&end_date='.$end_date; 
		}

		$this->load->library('pagination');
		$order_by = ['field' => 'id', 'type' => 'desc'];
		$limit	= 10;
		$total_result	= $this->common_model->dbselect("gha_courses",$condition, "COUNT(id) as Total")->result_array();

		$this->config->load('pagination');
		$config = $this->config->item('case2');
		$config['per_page']		= $limit;
		$config['page_query_string'] 	= TRUE;
		$config['total_rows']	= $total_result[0]['Total'];
		$config['base_url']		= $base_url;

		$this->pagination->initialize($config);

		$query = $this->common_model->dbselect('gha_courses',$condition, null, $per_page,null, $order_by, $limit); 
		$data['query'] = $query->result_array();

		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	public function create() { 
		$update_id = (int)$this->uri->segment(4);

		$headline = 'Add New Course';
		if ($update_id > 0) {
			$headline = 'Update Course Details';
			$getData = $this->common_model->dbselect('gha_courses', ['id' => $update_id])->result_array();
			if (empty($getData)) {
				redirect(base_url().'development/course/create');
			} else {
				$data = $getData[0];
				if ($data['related_courses'] !== '') {
					$data['related_courses'] = unserialize($data['related_courses']);
				}
			}
		}

		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if ($this->input->post('submit') == 'submit') {
			if($this->form_validation->run('admin_course_create')) {
				$thumbnail_data['create_thumbnail'] = TRUE;
				$thumbnail_data['upload_path'] = './uploads/course/thumb'; 
				$do_upload = $this->do_upload('featured_image', './uploads/course', null, $thumbnail_data);

				$related_courses = $this->input->post('related_courses');
				$related_courses = !empty($related_courses) ? serialize($related_courses) : '';

				$insert_data = [
					'title' => 	$this->input->post('title'),
					'price' => 	$this->input->post('price'),
					'duration' => 	$this->input->post('duration'),
					'description' => 	$this->input->post('description'),
					'status' => 	$this->input->post('status'),
					'related_courses' => $related_courses,
					'created_at' => Date('Y-m-d H:i:s'),
				];
 
				$url_title = url_title(strtolower($this->input->post('title')));
				$is_url_title_exists = $this->is_url_title_exists($url_title, $update_id);
				$insert_data['url_title'] = $is_url_title_exists ? $this->generate_url_title($url_title, $update_id) : $url_title;
				

				$image_err = 0;

				if ($update_id > 0) {
					if (isset($_FILES['featured_image']['name']) && $_FILES['featured_image']['name'] !== '' ) {
						$image_err = $do_upload['err']; 
						$featured_image = isset($do_upload['file_name']) ? $do_upload['file_name'] : $data['featured_image'];
					} else {
						$featured_image = $data['featured_image'];
					}
				} else {
					$image_err = $do_upload['err'];
					$featured_image = isset($do_upload['file_name']) ? $do_upload['file_name'] : '';
				}

				$insert_data['featured_image'] = $featured_image;

				if ($image_err == 0) {
					if ($update_id > 0) {
						$query = $this->common_model->dbupdate('gha_courses',$insert_data,['id' => $update_id]);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Course details has been successfully updated.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					} else {
						$query = $this->common_model->dbinsert('gha_courses', $insert_data);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Course has been successfully added.');
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
			redirect(base_url().'development/course/manage');
		}

		$data['select2_option'] = TRUE;
		$data['related_courses_options'] = $this->get_courses_dd();

		$data['headline'] = $headline; 
		$data['editor'] = true;
		$data['form_location'] = current_url();

		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');

		$data['headline'] = $headline;
		$data['view_file'] = 'backend/course/create';
		$data['update_id'] = $update_id;
		$this->load->view($this->layout, $data); 
	}

	public function is_url_title_exists($url_title, $update_id) {
		$condition['url_title'] = $url_title;
		if ($update_id > 0) {
			$condition['id !='] = $update_id;
		}

		$query = $this->common_model->dbselect('gha_courses',$condition)->result_array();
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
		$update_id = (int)$this->uri->segment('4');
		$condition['status'] = 1;
		if ($update_id > 0) {
			$condition['id !='] = $update_id;
		}
	
		$order_by['field'] = 'title';
		$order_by['type'] = 'asc';
		$query = $this->common_model->dbselect('gha_courses', $condition,null,null,null,$order_by)->result_array();
		if (!empty($query)) {
 			foreach ($query as $row) {
 				$options[$row['id']] = $row['title'];
			}	
		}

		return $options;
	}
}
?>