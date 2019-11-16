<?php
  class Payment extends User_Controller {
    
    public function __construct() {
      parent::__construct();
    }

    public function index() {
      $join = [
        ['type' => 'LEFT', 'condition' => 'o.id = p.order_id', 'table' => 'gha_order o'],
      ];

      $start = null;
      $select_data = ['p.*','p.created_at as payment_date'];
      $order_by = null;
      $condition['o.user_id'] = $this->logged_in_user_id;
      $data['query'] = $this->common_model->dbselect('gha_payment p', $condition, $select_data, $start, $join, $order_by)->result_array();

      $this->head_title = 'User | Payment History';
      $data['headline'] = 'Payment history';
      $data['view_file'] = 'frontend/user/payment/index';
      $this->load->view($this->layout, $data);
    }
  }
?>