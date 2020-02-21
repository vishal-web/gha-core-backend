<?php
	class Backend_Controller extends CI_Controller {
		public $head_title = 'Global Health Alliance';
		public $layout = 'backend/backend-layout'; 
		public $logged_in_user_data = '';
		public $referrer_url = '';

		function __construct() {
			parent::__construct();
			$this->logged_in_user_data = $this->session->userdata('logged_in_admin_data');
			if (empty($this->logged_in_user_data)) {
				redirect(base_url());
			}

			$this->load->library('user_agent');
			$this->referrer_url = $this->agent->referrer();
		}

		public function do_upload($image, $upload_path, $allowed_types = null, $thumbnail_data = null) {

			$allowed_types = $allowed_types == null || $allowed_types == '' ? 'gif|jpg|png|jpeg' : $allowed_types;
			
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0777, true);
			}

			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = $allowed_types;
			$config['encrypt_name'] = TRUE;
			// $config['max_size'] = 2048;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload($image)) {
				$uploadData['err'] = 1;
				$uploadData['error_message'] = $this->upload->display_errors('<p class="text-danger">','</p>'); 
			} else {
				$file_data = $this->upload->data();
				$uploadData['err'] = 0;
				$uploadData['file_name'] = $file_data['file_name']; 

				if (!empty($thumbnail_data) && $thumbnail_data['create_thumbnail'] == TRUE) {
					if (!is_dir($thumbnail_data['upload_path'])) {
						mkdir($thumbnail_data['upload_path'], 0777, true);
					}
	
					$ratio = null;
					if (isset($thumbnail_data['image_ratio'])) {
						$ratio = $thumbnail_data['image_ratio'];	
					}

					$new_image = $thumbnail_data['upload_path'];
					$this->create_thumbnail($file_data['file_name'], $upload_path, $new_image, $ratio);
				}
			}

			return $uploadData;
		}

		public function create_thumbnail($file_name, $source_image, $new_image, $ratio = null) {
		
			$width = isset($ratio['width']) ? $ratio['width'] : 200;
			$height = isset($ratio['height']) ? $ratio['height'] : 200;

			$this->load->library('image_lib');
			$config['image_library'] = 'gd2'; 
			$config['source_image'] = $source_image.'/'.$file_name;
			$config['new_image'] = $new_image.'/'.$file_name;
			$config['maintain_ratio'] = TRUE; 
			$config['width'] = $width;
			$config['height'] = $height;

			$this->load->library('image_lib', $config);

			$this->image_lib->initialize($config);

			if (!$this->image_lib->resize()) {
				// echo $this->image_lib->display_errors();
			}
		}

		public function multiple_upload($image, $upload_path) {
		
			$count = count($_FILES[$image]['name']);
			$FILES = $_FILES;
			$uploadData = [];

			if (isset($_FILES[$image])) {
				for ($i=0; $i < $count; $i++) { 

					$config['upload_path'] = $upload_path;
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['encrypt_name'] = TRUE;
					// $config['max_size'] = 2048;
					$this->load->library('upload');
					$this->upload->initialize($config);

					$_FILES[$image]['name'] = isset($FILES[$image]['name'][$i]['image']) ? $FILES[$image]['name'][$i]['image'] : '';
					$_FILES[$image]['type'] = isset($FILES[$image]['type'][$i]['image']) ? $FILES[$image]['type'][$i]['image'] : '';
					$_FILES[$image]['tmp_name'] = isset($FILES[$image]['tmp_name'][$i]['image']) ? $FILES[$image]['tmp_name'][$i]['image'] : '';
					$_FILES[$image]['error'] = isset($FILES[$image]['error'][$i]['image']) ? $FILES[$image]['error'][$i]['image'] : '';
					$_FILES[$image]['size'] = isset($FILES[$image]['size'][$i]['image']) ? $FILES[$image]['size'][$i]['image'] : '';

					if (!$this->upload->do_upload('choice')) {
						$uploadData[$i]['err'] = 1;
						$uploadData[$i]['error_message'] = $this->upload->display_errors('<p class="text-danger">','</p>'); 
					} else {
						$uploadData[$i]['err'] = 0;
						$uploadData[$i]['file_name'] = $this->upload->data()['file_name']; 
					}
				}
			}

			return $uploadData;
		}
	}

	class Public_Controller extends CI_Controller {
		public $head_title = 'Global Health Alliance';
		public $layout = 'frontend/frontend-layout';
		public $homepage = FALSE;
		public $navbar = '';
		public $logged_in_user_data = '';
		public $referrer_url = '';
		public $courseList = [];
		public $upcomingCourseList = [];

		public function __construct() {
			parent::__construct();
			$this->logged_in_user_data = $this->session->userdata('logged_in_user_data');
			$this->load->library('mobikwik');
			$this->load->library('user_agent');
			$this->referrer_url = $this->agent->referrer();
			$this->visitor_unique_id();
			$this->load->helper('cookie');
			$this->navbar = $this->generate_navbar();
			$this->courseList = $this->get_all_course();
			$this->upcomingCourseList = $this->get_upcoming_courses();
		}

		public function get_logged_in_user_details() {
			$user_id = 0;
			if (!empty($this->logged_in_user_data)) {
				$user_id = $this->logged_in_user_data['user_id'];
			}

			$condition['id'] = $user_id;
			$query = $this->common_model->dbselect('gha_registration r', $condition)->result_array();

			return $query;
		}

		public function move_local_cart_items_to_user_cart() {
			$uuid = $this->input->cookie('uuid');
			$user_id = 0;
			if (!empty($this->session->userdata('logged_in_user_data'))) {
				$user_id = $this->session->userdata('logged_in_user_data')['user_id'];
			}

			if ($uuid !== '' && $user_id > 0) {
				$updateData['user_id'] = $user_id;
				$condition['uuid'] = $uuid;
				$this->common_model->dbupdate('gha_cart',$updateData, $condition);
			}
		}

		private function visitor_unique_id() {
			$cookie_uuid = $this->input->cookie('uuid');
			if (!$cookie_uuid) {
				$cookie = array(
					'name'   => 'uuid',
					'value'  => md5(time()),
					'expire' => time() + (86400 * 30),
					// 'domain' => '.some-domain.com',
					'path'   => '/',
					// 'secure' => TRUE
				);
		
				$this->input->set_cookie($cookie);
			}
		}

		public function generate_navbar() {
			$get_course = $this->cache->file->get('courses');
			if (!$get_course) {
				$query = $this->common_model->dbselect('gha_courses', ['status'=>1, 'upcoming_course' => 0], null, null, null,['field' => 'title', 'type'=>'asc'])->result_array();
				$this->cache->file->save('courses', $query);
			} else {
				$query = $get_course;
			}


			$html = '';
			if (!empty($query)) {
				
				$count = count($query);
				$divider = ($count / 4);
				$size = 5;

				if ($divider > 5) {
					$size = 6;
				} else if ($divider > 6) {
					$size = 7;
				} else if ($divider > 7) {
					$size = 8;
				} else if ($divider > 8) {
					$size = 9;
				} else if ($divider > 9) {
					$size = 10;
				} else if ($divider > 10) {
					$size = 11;
				} else if ($divider > 11) {
					$size = 12;
				}

				$chunk = array_chunk($query, $size);

				for ($i=0; $i < count($chunk) ; $i++) { 
					$html .= '<div class="col-menu col-md-3"><h6 class="title">Courses</h6><div class="content"><ul class="menu-col">';
					if (!empty($chunk[$i])) {
						foreach ($chunk[$i] as $row) {
							$html .= '<li><a href="'.base_url().'course/'.$row['url_title'].'">'.$row['title'].'</a></li>';
						}
					}
					$html .= '</ul></div></div>';
				}
			}

			

			return $this->navbar = $html;
		}


		public function logged_in_history($logged_in_id, $logged_in_type) {
			$insertData = [
				'logged_in_id' => $logged_in_id,
				'logged_in_type' => $logged_in_type, 
				'created_at' => Date('Y-m-d H:i:s'),
			];
			
			$this->common_model->dbinsert('gha_logged_in_history', $insertData);
		}

		public function do_upload($image, $upload_path, $allowed_types = null) {

			$allowed_types = $allowed_types == null || $allowed_types == '' ? 'gif|jpg|png|jpeg' : $allowed_types;

			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = $allowed_types;
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

		public function get_all_course() {
			$get_course = $this->cache->file->get('courses');
			if (!$get_course) {
				$query = $this->common_model->dbselect('gha_courses', ['status'=>1, 'upcoming_course' => 0], null, null, null,['field' => 'title', 'type'=>'asc'])->result_array();
				$this->cache->file->save('courses', $query);
			} else {
				$query = $get_course;
			}

			return $query;
		}

		public function get_upcoming_courses() {
			$query = $this->common_model->dbselect('gha_courses', ['upcoming_course' => 1]);
			return $query->result_array(); 
		}
	}


	class User_Controller extends CI_Controller {
		public $head_title = 'Global Health Alliance';
		public $layout = 'frontend/frontend-layout';
		public $homepage = FALSE;
		public $navbar = '';
		public $logged_in_user_data = '';
		public $referrer_url = '';
		public $logged_in_user_id = 0;
		public $courseList = [];
		public $upcomingCourseList = [];

		public function __construct() {
			parent::__construct();
			$this->logged_in_user_data = $this->session->userdata('logged_in_user_data');
			$this->load->library('mobikwik');
			$this->load->library('user_agent');
			$this->referrer_url = $this->agent->referrer();

			$logged_in_user_data = $this->session->userdata('logged_in_user_data');
			if (empty($logged_in_user_data)) {
				redirect('login');
			}

			$this->logged_in_user_id = $logged_in_user_data['user_id'];
			$this->navbar = $this->generate_navbar();
			$this->courseList = $this->get_all_course();
			$this->upcomingCourseList = $this->get_upcoming_courses();
		}

		public function generate_navbar() {
			$get_course = $this->cache->file->get('courses');
			if (!$get_course) {
				$query = $this->common_model->dbselect('gha_courses', ['status'=>1], null, null, null,['field' => 'title', 'type'=>'asc'])->result_array();
				$this->cache->file->save('courses', $query);
			} else {
				$query = $get_course;
			}

			$html = '';
			if (!empty($query)) {
				
				$count = count($query);
				$divider = ($count / 4);
				$size = 5;

				if ($divider > 5) {
					$size = 6;
				} else if ($divider > 6) {
					$size = 7;
				} else if ($divider > 7) {
					$size = 8;
				} else if ($divider > 8) {
					$size = 9;
				} else if ($divider > 9) {
					$size = 10;
				} else if ($divider > 10) {
					$size = 11;
				} else if ($divider > 11) {
					$size = 12;
				}

				$chunk = array_chunk($query, $size);

				for ($i=0; $i < count($chunk) ; $i++) { 
					$html .= '<div class="col-menu col-md-3"><h6 class="title">Courses</h6><div class="content"><ul class="menu-col">';
					if (!empty($chunk[$i])) {
						foreach ($chunk[$i] as $row) {
							$html .= '<li><a href="'.base_url().'course/'.$row['url_title'].'">'.$row['title'].'</a></li>';
						}
					}
					$html .= '</ul></div></div>';
				}
			}

			

			return $this->navbar = $html;
		}


		public function do_upload($image, $upload_path, $allowed_types = null) {

			$allowed_types = $allowed_types == null || $allowed_types == '' ? 'gif|jpg|png|jpeg' : $allowed_types;

			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = $allowed_types;
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

		public function get_logged_in_user_details() {

			$join = [
				[
					'type' => 'left',
					'condition' => 'c.id = r.country', 
					'table' => 'gha_countries c'
				],
				[
					'type' => 'left',
					'condition' => 's.id = r.state', 
					'table' => 'gha_states s'
				],
				[
					'type' => 'left',
					'condition' => 'ct.id = r.city', 
					'table' => 'gha_cities ct'
				],
				[
					'type' => 'left',
					'condition' => 'p.id = r.profession', 
					'table' => 'gha_profession p'
				],
			];

			$select_data = ['r.*', 'c.name as country_name', 's.name as state_name', 'ct.name as city_name', 'p.name as profession_name'];
			$query = $this->common_model->dbselect('gha_registration r', ['r.id' => $this->logged_in_user_id], $select_data, null, $join)->result_array();

			return $query;
		}

		public function get_all_course() {
			$get_course = $this->cache->file->get('courses');
			if (!$get_course) {
				$query = $this->common_model->dbselect('gha_courses', ['status'=>1, 'upcoming_course' => 0], null, null, null,['field' => 'title', 'type'=>'asc'])->result_array();
				$this->cache->file->save('courses', $query);
			} else {
				$query = $get_course;
			}

			return $query;
		}

		public function get_upcoming_courses() {
			$query = $this->common_model->dbselect('gha_courses', ['upcoming_course' => 1]);
			return $query->result_array(); 
		}
	}

?>