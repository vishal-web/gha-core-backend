<?php
class Order extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function manage() { 
		$data['headline'] = 'Manage Orders'; 
		$data['view_file'] = 'backend/order/manage';
		$data['edit_url'] = base_url().'development/order/create';
		$data['view_url'] = base_url().'development/order/view';

		$search = trim($this->input->get('search'));			
		$start_date = trim($this->input->get('start_date'));			
		$end_date = trim($this->input->get('end_date'));			

		$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
		$base_url = base_url().'development/order/manage';
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
		$total_result	= $this->common_model->dbselect("gha_order",$condition, "COUNT(id) as Total")->result_array();

		$this->config->load('pagination');
		$config = $this->config->item('case2');
		$config['per_page']		= $limit;
		$config['page_query_string'] 	= TRUE;
		$config['total_rows']	= $total_result[0]['Total'];
		$config['base_url']		= $base_url;

		$this->pagination->initialize($config);
		$select_data = ['o.*', 'r.firstname', 'r.lastname', 'r.email'];
		$join = [
			['type' => 'left', 'condition' => 'o.user_id = r.id', 'table' => 'gha_registration r']
		];

		$sort_by = $this->input->get('sort_by');
		$type = $this->input->get('type');
		$type = trim($type) !== '' ? $type : 'asc';
		if ($sort_by && $type) {
			$order_by = ['field' => 'o.'.$sort_by, 'type' => $type];
			$type = $type == 'asc' ? 'desc' : 'asc';
		}
 
		$query = $this->common_model->dbselect('gha_order o',$condition, $select_data, $per_page, $join, $order_by, $limit); 
		$data['query'] = $query->result_array();
		
		$data['type'] = $type;
		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	public function view() {
		$fourth_bit = $this->uri->segment(4);

		$join = [
			['type' => 'left', 'condition' => 'o.user_id = r.id', 'table' => 'gha_registration r'],
			['type' => 'left', 'condition' => 'o.id = p.order_id', 'table' => 'gha_payment p'],
			['type' => 'left', 'condition' => 'o.billing_address_id = ba.id', 'table' => 'gha_billing_address ba'],
			['type' => 'left', 'condition' => 'c.id = ba.billing_country_id', 'table' => 'gha_countries c'],
			['type' => 'left', 'condition' => 's.id = ba.billing_state_id', 'table' => 'gha_states s'],
			['type' => 'left', 'condition' => 'ct.id = ba.billing_city_id', 'table' => 'gha_cities ct'],
		];

		$select_data = [
			'ba.*',
			'c.name as billing_country_name',
			's.name as billing_state_name',
			'ct.name as billing_city_name',
			'r.firstname',
			'r.lastname',
			'r.email',
			'r.phone',
			'o.order_reference_id',
			'o.created_at as order_date',
			'p.*',
			'p.created_at as payment_date',
		];
		$condition['o.id'] = $fourth_bit; 
		$query = $this->common_model->dbselect('gha_order o',$condition, $select_data, null, $join)->result_array(); 
		$data['query'] = !empty($query) ? $query[0] : []; 

		$data['order_items'] = $this->order_items($fourth_bit);

		$data['headline'] = 'Order';		
		if (isset($data['query']['order_reference_id'])) {
			$data['headline'] .= ' '.$data['query']['order_reference_id'];
		}
		
 
		$data['view_file'] = 'backend/order/view';
		$data['edit_url'] = base_url().'development/order/create';
		$data['manage_url'] = base_url().'development/order/manage'; 
		$this->load->view($this->layout, $data); 
	}

	private function order_items($order_id) {
    $condition['order_id'] = $order_id;

    $join = [
      ['type' => 'LEFT', 'condition' => 'op.course_id = courses.id', 'table' => 'gha_courses courses']
    ];

    $selectData = ['courses.title', 'courses.id as course_id', 'courses.url_title', 'courses.price', 'courses.duration', 'courses.featured_image'];
    $query = $this->common_model->dbselect('gha_order_product op',$condition, $selectData, null, $join)->result_array();
    return $query;
  }
}
?>