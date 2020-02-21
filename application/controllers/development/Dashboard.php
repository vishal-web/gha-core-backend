<?php
	class Dashboard extends Backend_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function index() {
			$data['headline'] = 'Dashboard'; 
			$data['view_file'] = 'backend/dashboard';
			$data['totalActiveUserCount'] = $this->getUserCount(1);
			$data['totalPaymentCount'] = $this->getPaymentCount(1);

			$this->load->view('backend/backend-layout', $data);
		}


		private function getUserCount($status) {
			$condition['status'] = $status;
			$selectData = "count('id') as totalCount";
			$query = $this->common_model->dbselect('gha_registration', $condition, $selectData);
			return $query->row()->totalCount;
		}

		private function getPaymentCount($status) {
			$condition['status'] = $status;
			$selectData = "count('id') as totalCount";
			$query = $this->common_model->dbselect('gha_payment', $condition, $selectData);
			return $query->row()->totalCount;
		}

	}

?>