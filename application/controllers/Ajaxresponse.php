<?php
	
	class Ajaxresponse extends CI_Controller {
		public $user_id = 0;
		public function __construct() {
			parent::__construct();
			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			}

			if (!empty($this->session->userdata('logged_in_user_data'))) {
				$this->user_id = $this->session->userdata('logged_in_user_data')['user_id'];
			}
		}
		
		public function get_cart_item_count() {
			$uuid = $this->input->cookie('uuid');
			if ($this->user_id > 0) {
				$condition['user_id'] = $this->user_id;
			} else {
				$condition['uuid'] = $uuid;
			}
			$output['cart_items'] = 0; 
			$query = $this->common_model->dbselect('gha_cart',$condition,'COUNT(id) as total')->result_array();
			if (!empty($query)) {
				$output['cart_items'] = $query[0]['total'];
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}

		public function remove_cart_item() {
			$cart_id = (int)$this->uri->segment('3');
			$response['status'] = 0;
			if ($cart_id > 0) {
				if ($this->common_model->dbdelete('gha_cart',['id' => $cart_id])) {
					$response['status'] = 1;
				}
			}
			
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}

		public function add_to_cart() {
			$course_id = (int)$this->input->post('course_id');
			$uuid = $this->input->post('uuid');
			$user_id = $this->user_id;

			$output['status'] = 0;
			$output['message'] = 'Something went wrong';
			if ($course_id > 0 && $uuid) {

				$course_already_in_cart = $this->common_model->dbselect('gha_cart',['course_id' => $course_id, 'uuid' => $uuid])->result_array();
				if (!empty($course_already_in_cart)) {
					$output['message'] = 'Already in cart';
				} else {
					$output['status'] = 1;
					$insertData = ['uuid'=>$uuid, 'course_id'=>$course_id,'user_id'=>$user_id,'created_at'=>Date('Y-m-d H:i:s')];
					if ($this->common_model->dbinsert('gha_cart',$insertData)) {
						$output['message'] = 'Course added into cart';
					}
				}
			}
			
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}

		public function get_states() {
			$country_id = (int)$this->uri->segment(3);
			$output = [];
			if ($country_id > 0) {
				$output = $this->common_model->dbselect('gha_states', ['country_id' => $country_id])->result_array();
			} 
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}

		public function get_cities() {
			$state_id = (int)$this->uri->segment(3);
			$output = [];
			if ($state_id > 0) {
				$output = $this->common_model->dbselect('gha_cities', ['state_id' => $state_id])->result_array();
			} 
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}

		public function removeanswer() {
			$answer = (int)$this->input->post('answer');
			$question = (int)$this->input->post('question');
			$choice = (int)$this->input->post('choice');
			$output['status'] = false;

			if ($answer > 0 && $question > 0 && $choice > 0) {

				
				$query_question = $this->common_model->dbselect('gha_questions', ['id' => $question])->result_array();

				if (!empty($query_question)) {
					$options = unserialize($query_question[0]['options']); 
					if (!empty($options)) {
						unset($options[--$choice]);
						
						$options = serialize($options);
						$this->common_model->dbupdate('gha_questions', ['options' => $options], ['id' => $question]);

						$output['option_msg'] = 'Options Updated Successfully';
					}
				}



				$query = $this->common_model->dbdelete('gha_answers', ['id' => $answer]);
				if ($query) {
					$output['answer_msg']	= 'Answer removed';
					$output['status'] = true;
				}
			}


			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}

		public function examstarted() {
			$output['status'] = false;
			$logged_in_user_data = $this->session->userdata('logged_in_user_data');
			if (!empty($logged_in_user_data)) { 
				$user_id = $logged_in_user_data['user_id'];
				$exam_id = $this->input->post('id');
				$order_product_id = $this->input->post('order_product_id');

				$insertData = [
					'exam_id' => $exam_id,
					'order_product_id' => $order_product_id,
					'user_id' => $user_id,
					'started_at' => Date('Y-m-d H:i:s'),
				];

				if ($this->common_model->dbinsert('gha_exams_history',$insertData)) {
					$this->session->set_userdata('examstarted', true);
					$output['status'] = true;
					$output['id'] = $this->db->insert_id();
				}
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}
	
?>