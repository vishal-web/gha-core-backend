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


		public function get_course_details($url_title) {
			$query = $this->common_model->dbselect('gha_courses',['url_title' => $url_title])->result_array();
			return $query;
		}
	}

?>