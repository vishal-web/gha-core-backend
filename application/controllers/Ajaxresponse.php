<?php
	
	class Ajaxresponse extends CI_Controller {
		public function __construct() {
			parent::__construct();
			if (!$this->input->is_ajax_request()) {
				exit('No direct script access allowed');
			}
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

				$insertData = [
					'exam_id' => $exam_id,
					'user_id' => $user_id,
					'started_at' => Date('Y-m-d H:i:s'),
				];

				if ($this->common_model->dbinsert('gha_exams_history',$insertData)) {
					$output['status'] = true;
				}
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}
?>