<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Public_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index() {
		$this->homepage = TRUE;
		$data['view_file'] = 'frontend/search/index';
		$this->load->view($this->layout, $data);
	}

	public function get_result() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$srchTxt = $this->input->get('srchTxt'); 

		$jsonResult['status'] = false;

		if (!empty($srchTxt)) {
			$data['query'] = $this->make_search_results($srchTxt);
			$jsonResult['status'] = true;
			$jsonResult['result'] = $this->load->view('frontend/search/index', $data, TRUE);
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($jsonResult)); 
	}


	private function make_search_results($text) { 
		$this->db->select('title, url_title');
		$this->db->where(['status' => 1, 'upcoming_course' => 0]);
		$this->db->like('title',$text,'both');
		$this->db->limit(10);
		return $this->db->get('gha_courses')->result_array(); 
	}
}
