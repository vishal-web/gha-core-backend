<?php
class Homepage extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function course() { 
		
		$update_id = (int)$this->uri->segment(4);

		$headline = 'Add New Homepage';
		if ($update_id > 0) {
			$headline = 'Update Homepage Details';
			$getData = $this->common_model->dbselect('gha_homepage', ['id' => $update_id, 'type' => 'homepage_course'])->result_array();
			if (empty($getData)) {
				redirect(base_url().'development/homepage/course');
			} else {
				$data = $getData[0];
			}
		}

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if ($this->input->post('submit') == 'submit') {
			if($this->form_validation->run('admin_homepage_create')) {
				$do_upload = $this->do_upload('featured_image', './uploads/homepage/course');

				$insert_data = [
					'course_id' => 	$this->input->post('course_id'), 
					'description' => 	$this->input->post('description'),
					'status' => 	$this->input->post('status'),
					'type' => 'homepage_course',
					'created_at' => Date('Y-m-d H:i:s'),
				];
				

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
						$query = $this->common_model->dbupdate('gha_homepage',$insert_data,['id' => $update_id]);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Homepage details has been successfully updated.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					} else {
						$query = $this->common_model->dbinsert('gha_homepage', $insert_data);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Homepage has been successfully added.');
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
			redirect(base_url().'development/homepage/course');
		}
		
		$select_data = ['*', '(SELECT title FROM gha_courses WHERE id = course_id) as course_title'];
		$condition['type'] = 'homepage_course';
		$query = $this->common_model->dbselect('gha_homepage',$condition, $select_data); 
		$data['query'] = $query->result_array();
		$data['form_location'] = current_url();
		$data['course_dd'] = $this->get_courses_dd();
		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
		

		$headline = 'Add Featured Course';
		if ($update_id > 0) {
			$headline = 'Update Course Details';
		}

		$data['headline'] = 'Homepage Trending Courses'; 
		$data['view_file'] = 'backend/homepage/course';
		$data['edit_url'] = base_url().'development/homepage/course';

		$data['headline_top'] = $headline;  
		$data['update_id'] = $update_id;
		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	public function banner() { 
		
		$update_id = (int)$this->uri->segment(4);

		$headline = 'Add New Homepage';
		if ($update_id > 0) {
			$headline = 'Update Homepage Details';
			$getData = $this->common_model->dbselect('gha_homepage', ['id' => $update_id, 'type' => 'homepage_banner'])->result_array();
			if (empty($getData)) {
				redirect(base_url().'development/homepage/banner');
			} else {
				$data = $getData[0];
			}
		}

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if ($this->input->post('submit') == 'submit') {
			if($this->form_validation->run('admin_homepage_banner')) {
				$do_upload = $this->do_upload('featured_image', './uploads/homepage/banner');
				$insert_data['type'] = 'homepage_banner';
				$insert_data['created_at'] = Date('Y-m-d H:i:s');
				$insert_data['status'] = $this->input->post('status');
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
						$insert_data['updated_at'] = Date('Y-m-d H:i:s');
						$query = $this->common_model->dbupdate('gha_homepage',$insert_data,['id' => $update_id]);
					
						if ($insert_data['status'] == 1) {
							$this->updated_banners($update_id);
						}

						if ($query) {
							$this->session->set_flashdata('flash_message', 'Homepage banner has been successfully updated.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					} else {
						$query = $this->common_model->dbinsert('gha_homepage', $insert_data);

						if ($insert_data['status'] == 1) {
							$this->updated_banners($this->db->insert_id());
						}

						if ($query) {
							$this->session->set_flashdata('flash_message', 'Homepage banner has been successfully added.');
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
			redirect(base_url().'development/homepage/banner');
		}

		$condition['type'] = 'homepage_banner';
		$query = $this->common_model->dbselect('gha_homepage',$condition); 
		$data['query'] = $query->result_array();


		$data['form_location'] = current_url(); 
		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
		 
		$headline = 'Add Banner';
		if ($update_id > 0) {
			$headline = 'Update Banner';
		}

		$data['headline'] = 'Homepage Banner'; 
		$data['view_file'] = 'backend/homepage/banner';
		$data['edit_url'] = base_url().'development/homepage/banner';

		$data['headline_top'] = $headline;  
		$data['update_id'] = $update_id;
		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	private function updated_banners($banner_id) {
	
		$condition['type'] = 'homepage_banner';
		$condition['id !='] = $banner_id;

		$query = $this->common_model->dbselect('gha_homepage',$condition)->result_array();  

		if (!empty($query)) {
			foreach ($query as $row) {
				$updateCondition['type'] = 'homepage_banner';
				$updateCondition['id'] = $row['id']; 
				$updateData['status'] = 0;
				$this->common_model->dbupdate('gha_homepage',$updateData,$updateCondition);
			}
		}
	}

	public function is_url_title_exists($url_title, $update_id) {
		$condition['url_title'] = $url_title;
		if ($update_id > 0) {
			$condition['id !='] = $update_id;
		}

		$query = $this->common_model->dbselect('gha_homepage',$condition)->result_array();
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