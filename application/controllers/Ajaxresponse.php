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
			$output['status'] = false;

			if ($answer > 0) {
				$query = $this->common_model->dbdelete('gha_answers', ['id' => $answer]);
				if ($query) {
					$output['status'] = true;
				}
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}
?>