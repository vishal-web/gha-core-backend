<?php
	class Dashboard extends CI_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function index() {
			$data['headline'] = 'Dashboard'; 
			$data['view_file'] = 'backend/dashboard';

			$query = $this->common_model->dbselect('gha_registration');
			
			$this->load->view('backend/backend-layout', $data);
		}
	}

?>