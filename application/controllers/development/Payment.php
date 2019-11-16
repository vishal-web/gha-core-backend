<?php
class Payment extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function manage() { 
		$data['headline'] = 'Manage Payments'; 
		$data['view_file'] = 'backend/payment/manage';
		$data['edit_url'] = base_url().'development/payment/create';
		$data['view_url'] = base_url().'development/order/view';

		$search = trim($this->input->get('search'));			
		$start_date = trim($this->input->get('start_date'));			
		$end_date = trim($this->input->get('end_date'));			

		$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
		$base_url = base_url().'development/payment/manage';
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
		$total_result	= $this->common_model->dbselect("gha_payment",$condition, "COUNT(id) as Total")->result_array();

		$this->config->load('pagination');
		$config = $this->config->item('case2');
		$config['per_page']		= $limit;
		$config['page_query_string'] 	= TRUE;
		$config['total_rows']	= $total_result[0]['Total'];
		$config['base_url']		= $base_url;

		$this->pagination->initialize($config);

		$query = $this->common_model->dbselect('gha_payment',$condition, null, $per_page,null, $order_by, $limit); 
		$data['query'] = $query->result_array();

		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	public function view() {
		$fourth_bit = $this->uri->segment(4);

		$join = [
			['type' => 'left', 'condition' => 'o.order_product_id = op.id', 'table' => 'gha_order_product op'],
			['type' => 'left', 'condition' => 'op.user_id = r.id', 'table' => 'gha_registration r'],
			['type' => 'left', 'condition' => 'o.id = p.order_id', 'table' => 'gha_payment p'],
		];

		$select_data = [
			'op.*',
			'r.firstname',
			'r.lastname',
			'r.email',
			'r.phone',
			'p.*',
			'p.created_at as payment_date',
		];
		$condition['o.id'] = $fourth_bit; 
		$query = $this->common_model->dbselect('gha_order o',$condition, $select_data, null, $join); 
		$data['query'] = $query->result_array(); 

		$data['headline'] = 'View Payment Details'; 
		$data['view_file'] = 'backend/payment/view';
		$data['edit_url'] = base_url().'development/payment/create';
		$data['manage_url'] = base_url().'development/payment/manage'; 
		$this->load->view($this->layout, $data); 
	}
}
?>