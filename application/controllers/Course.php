<?php
	class Course extends Public_Controller { 

		public function __construct() {
			parent::__construct();
			$this->generate_navbar();
		}

		public function index() {
			$url_title = $this->uri->segment('2');
			if ($url_title == '') {
				redirect(base_url());
			}
			
			$course_details = $this->get_course_details($url_title);
			if (empty($course_details)) {
				redirect(base_url());
			}

			$this->head_title = $course_details[0]['title'].' - '.$this->head_title; 
			$data['title'] = $course_details[0]['title'];
			$data['course_details'] = $course_details[0];
			$data['view_file'] = 'frontend/home/course-detail';
			$this->load->view($this->layout, $data);
		}

		public function enroll() {
			$url_title = $this->uri->segment('3');
			if ($url_title == '') {
				redirect(base_url());
			}
			
			$course_details = $this->get_course_details($url_title);
			if (empty($course_details)) {
				redirect(base_url());
			}

			// User must have completed his profile for checkout process
			// Otherwise he must complete his profile
			$user_details = $this->get_user_details()[0];
			if ($user_details['country'] == '' || $user_details['state'] == '' || $user_details['city'] == '') {
				redirect(base_url('user/dashboard'));
			}

			// Add course current details
			$order_product = [
				'user_id' => $this->logged_in_user_data['user_id'],     
				'course_id' => $course_details[0]['id'],      
				'course_title' => $course_details[0]['title'],   
				'course_price' => $course_details[0]['price'],   
				'course_duration' => $course_details[0]['duration'],
				'created_at' => Date('Y-m-d H:i:s'),     
				'updated_at' => Date('Y-m-d H:i:s'),   
			];

			// $order_product_id = $this->db->insert_id();
			$data['form_fields'] = '';


			$data['view_file'] = 'frontend/home/payment';
			$this->load->view($this->layout, $data);
		}

		private function get_user_details() {
			if (empty($this->logged_in_user_data)) {
				redirect(base_url());
			}


			$join = [
				[
					'type' => 'left',
					'table' => 'gha_countries c',
					'condition' => 'r.country = c.id'
				],
				[
					'type' => 'left',
					'table' => 'gha_states s',
					'condition' => 'r.state = s.id'
				],
				[
					'type' => 'left',
					'table' => 'gha_cities ct',
					'condition' => 'r.city = ct.id'
				],
			];

			$condition = ['r.id' => $this->logged_in_user_data['user_id']];
			$select_data = ['r.*', 'c.name as country_name', 's.name as state_name', 'ct.name as city_name'];

			$query = $this->common_model->dbselect('gha_registration r',$condition, $select_data, null, $join);
			return $query->result_array();
		}

		public function get_course_details($url_title) {
			$query = $this->common_model->dbselect('gha_courses',['url_title' => $url_title])->result_array();
			return $query;
		}

	}

?>