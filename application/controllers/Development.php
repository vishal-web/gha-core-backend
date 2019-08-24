<?php
	
	Class Development extends CI_Controller {

		public function __constructor() {
			parent::__construct();
			$this->load->library('form_validation');
		}

		public function dashboard() {
			$data['headline'] = 'Dashboard'; 
			$data['view_file'] = 'backend/dashboard';

			$query = $this->common_model->dbselect('gha_registration');
			
			$this->load->view('backend/backend-layout', $data);
		}

		public function userList() { 
			$data['headline'] = 'Manage Users'; 
			$data['view_file'] = 'backend/user/user-list';
			$data['edit_url'] = base_url().'development/usercreate';

			$search = trim($this->input->get('search'));			
			$start_date = trim($this->input->get('start_date'));			
			$end_date = trim($this->input->get('end_date'));			

			$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
			$base_url = base_url().'development/userlist';
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
			$total_result	= $this->common_model->dbselect("gha_registration",$condition, "COUNT(id) as Total")->result_array();

			$this->config->load('pagination');
			$config = $this->config->item('case2');
			$config['per_page']		= $limit;
			$config['page_query_string'] 	= TRUE;
			$config['total_rows']	= $total_result[0]['Total'];
			$config['base_url']		= $base_url;

			$this->pagination->initialize($config);

			$query = $this->common_model->dbselect('gha_registration',$condition, null, $per_page,null, $order_by, $limit); 
			$data['query'] = $query->result_array();

			$data['form_location'] = current_url();
			$this->load->view('backend/backend-layout', $data); 
		}

		public function userCreate() { 
			$update_id = (int)$this->uri->segment(3);
			
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
				redirect(base_url().'development/usercreate');
			}

			$headline = 'Add New User';
			$title = 'Add User';
			if ($update_id > 0) {
				$headline = 'Update User Details';
				$title = 'Update Details';
				$getData = $this->common_model->dbselect('gha_registration', ['id' => $update_id])->result_array();
				if (empty($getData)) {
					redirect(base_url().'development/usercreate');
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
			$data['view_file'] = 'backend/user/user-create';

			$this->load->view('backend/backend-layout', $data); 
		}

		public function userView() { 
			$data['headline'] = 'User Details';
			$data['view_file'] = 'backend/user/user-view';
			$this->load->view('backend/backend-layout', $data); 
		}

		public function courseList() { 
			$data['headline'] = 'Manage Courses'; 
			$data['view_file'] = 'backend/course/course-list';
			$data['edit_url'] = base_url().'development/coursecreate';

			$search = trim($this->input->get('search'));			
			$start_date = trim($this->input->get('start_date'));			
			$end_date = trim($this->input->get('end_date'));			

			$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
			$base_url = base_url().'development/courselist';
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
			$this->load->view('backend/backend-layout', $data); 
		}

				public function courseCreate() { 
			$update_id = (int)$this->uri->segment(3);

			$headline = 'Add New Course';
			if ($update_id > 0) {
				$headline = 'Update Course Details';
				$getData = $this->common_model->dbselect('gha_courses', ['id' => $update_id])->result_array();
				if (empty($getData)) {
					redirect(base_url().'development/coursecreate');
				} else {
					$data = $getData[0];
				}
			}

			
 			$this->load->library('form_validation');
 			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
 			if ($this->input->post('submit') == 'submit') {
				if($this->form_validation->run('admin_course_create')) {
					$do_upload = $this->do_upload('featured_image', './uploads/backend/course');

					$insert_data = [
						'title' => 	$this->input->post('title'),
						'price' => 	$this->input->post('price'),
						'duration' => 	$this->input->post('duration'),
						'description' => 	$this->input->post('description'),
						'url_title' =>	url_title(strtolower($this->input->post('title'))),
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
				redirect(base_url().'development/courselist');
			}


			$data['headline'] = $headline; 
			
			$data['form_location'] = current_url();

			$data['flash_message'] = $this->session->flashdata('flash_message');
			$data['flash_type'] = $this->session->flashdata('flash_type');

			$data['headline'] = $headline;
			$data['view_file'] = 'backend/course/course-create';
			$data['update_id'] = $update_id;
			$this->load->view('backend/backend-layout', $data); 
		}


		public function categoryList() { 
			$data['headline'] = 'Manage Categories'; 
			$data['view_file'] = 'backend/category/category-list';
			$data['edit_url'] = base_url().'development/categorycreate';

			$search = trim($this->input->get('search'));			
			$start_date = trim($this->input->get('start_date'));			
			$end_date = trim($this->input->get('end_date'));			

			$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
			$base_url = base_url().'development/categorylist';
			$condition['parent_id'] = 0;

			if (isset($_GET['search']) || (isset($_GET['start_date']) && isset($_GET['end_date']))) {
				$base_url .= '?query=';
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
			$data['table_head_title'] = 'Existing Categories';
			$data['form_location'] = current_url();
			$this->load->view('backend/backend-layout', $data); 
		}

		public function categoryCreate() { 
			$update_id = (int)$this->uri->segment(3);

			$headline = 'Add New Category';
			if ($update_id > 0) {
				$headline = 'Update Category Details';
				$getData = $this->common_model->dbselect('gha_courses', ['id' => $update_id])->result_array();
				if (empty($getData)) {
					redirect(base_url().'development/categorycreate');
				} else {
					$data = $getData[0];
				}
			}

			
 			$this->load->library('form_validation');
 			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
 			if ($this->input->post('submit') == 'submit') {
				if($this->form_validation->run('admin_category_create')) {
					$do_upload = $this->do_upload('featured_image', './uploads/backend/category');

					$insert_data = [
						'title' => 	$this->input->post('title'),
						'price' => 	$this->input->post('price'),
						'duration' => 	$this->input->post('duration'),
						'description' => 	$this->input->post('description'),
						'url_title' =>	url_title(strtolower($this->input->post('title'))),
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
							$query = $this->common_model->dbupdate('gha_courses',$insert_data,['id' => $update_id]);
							if ($query) {
								$this->session->set_flashdata('flash_message', 'Category details has been successfully updated.');
								$this->session->set_flashdata('flash_type', 'success');
								redirect(current_url());	
							}
						} else {
							$query = $this->common_model->dbinsert('gha_courses', $insert_data);
							if ($query) {
								$this->session->set_flashdata('flash_message', 'Category has been successfully added.');
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
				redirect(base_url().'development/categorylist');
			}


			$data['headline'] = $headline; 
			
			$data['form_location'] = current_url();

			$data['flash_message'] = $this->session->flashdata('flash_message');
			$data['flash_type'] = $this->session->flashdata('flash_type');

			$data['headline'] = $headline;
			$data['view_file'] = 'backend/category/category-create';
			$data['table_head_title'] = 'Category Details';
			$data['update_id'] = $update_id;
			$this->load->view('backend/backend-layout', $data); 
		}

		public function questionList() { 
			$data['headline'] = 'Manage Questions'; 
			$data['view_file'] = 'backend/question/question-list';
			$data['edit_url'] = base_url().'development/questioncreate';

			

			$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
			$base_url = base_url().'development/questionlist';
			$condition = [];

			$this->load->library('pagination');
			$order_by = ['field' => 'id', 'type' => 'desc'];
			$limit	= 10;
			$total_result	= $this->common_model->dbselect("gha_questions",$condition, "COUNT(id) as Total")->result_array();

			$this->config->load('pagination');
			$config = $this->config->item('case2');
			$config['per_page']		= $limit;
			$config['page_query_string'] 	= TRUE;
			$config['total_rows']	= $total_result[0]['Total'];
			$config['base_url']		= $base_url;

			$this->pagination->initialize($config);

			$query = $this->common_model->dbselect('gha_questions',$condition, null, $per_page,null, $order_by, $limit); 
			$data['query'] = $query->result_array();

			$data['form_location'] = current_url();
			$this->load->view('backend/backend-layout', $data); 
		}

		public function questionCreate() {
			$update_id = (int)$this->uri->segment(3);
		
			$headline = 'Add New Question';
			if ($update_id > 0) {
				$headline = 'Update Question Details';
				$getData = $this->common_model->dbselect('gha_questions', ['id' => $update_id])->result_array();
				if (empty($getData)) {
					redirect(base_url().'development/questioncreate');
				} else {
					$data = $getData[0]; 
				}
			}

			
 			$this->load->library('form_validation');
 			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

 			$submit = $this->input->post('submit');

 			if ($submit == 'submit') {

				if($this->form_validation->run('admin_question_create')) {
					$choice = $this->input->post('choice');
					if (!empty($choice)) {
						foreach ($choice as $key => $row) {
							if (trim($row['answer']) == '') {
								unset($choice[$key]);
							}
						}
					}

					$insert_data = [
						'question_title' => $this->input->post('question_title'),
						'is_multiple_choice' => 	$this->input->post('is_multiple_choice'),
						'updated_at' => Date('Y-m-d H:i:s a'),
						'options' => serialize($choice)
					];

					if ($update_id > 0) {
						$query = $this->common_model->dbupdate('gha_questions',$insert_data,['id' => $update_id]);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Question details has been successfully updated.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					} else {
						$query = $this->common_model->dbinsert('gha_questions', $insert_data);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Question has been successfully added.');
							$this->session->set_flashdata('flash_type', 'success');
							
							redirect(current_url());
						}
					}
				}
			}

			if ($this->input->post('submit') == 'cancel') {
				redirect(base_url().'development/questionlist');
			}

			if ($update_id > 0 && $submit !== 'submit') {
				$choice = !empty(unserialize($data['options'])) ? unserialize($data['options']) : [];			
			} else {
				$choice = $this->input->post('choice');
				if (!empty($choice)) {
					foreach ($choice as $key => $row) {
						if (trim($row['answer']) == '') {
							unset($choice[$key]);
						}
					}
				}
			}


			$data['choice'] = $choice;

			$data['headline'] = $headline; 
			
			$data['form_location'] = current_url();
		

			$data['flash_message'] = $this->session->flashdata('flash_message');
			$data['flash_type'] = $this->session->flashdata('flash_type');

			$data['headline'] = $headline;
			$data['view_file'] = 'backend/question/question-create';

			$this->load->view('backend/backend-layout', $data); 
		}

		public function do_upload($image, $upload_path) {
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['encrypt_name'] = TRUE;
			// $config['max_size'] = 2048;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($image)) {
				$uploadData['err'] = 1;
				$uploadData['error_message'] = $this->upload->display_errors('<p class="text-danger">','</p>'); 
			} else {
				$uploadData['err'] = 0;
				$uploadData['file_name'] = $this->upload->data()['file_name']; 
			}

			return $uploadData;
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

		public function get_profession_dropdown() {
			$options[''] = 'Select profession';
			$query = $this->common_model->dbselect('gha_profession')->result_array();
			foreach ($query as $row) {
				$options[$row['id']] = $row['name'];
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

		public function check_email_exists($str) {
			$update_id = (int)$this->uri->segment(3);

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
	}
?>