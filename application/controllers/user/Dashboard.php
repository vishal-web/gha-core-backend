<?php
  class Dashboard extends User_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->helper('form');
    }

    public function index() {
      $join = [
        ['type' => 'LEFT', 'condition' => 'o.id = op.order_id', 'table' => 'gha_order_product op'],
        ['type' => 'LEFT', 'condition' => 'p.order_id = o.id', 'table' => 'gha_payment p'],
        ['type' => 'LEFT', 'condition' => 'e.course_id = op.course_id AND e.status = 1', 'table' => 'gha_exams e'],
      ];

      $start = null;
      $select_data = [
        'e.*', 
        'op.course_title',
        'op.course_duration',
        'op.id as order_product_id',
        'p.created_at as payment_date',
        '(e.attempt - (SELECT COUNT(id) FROM gha_exams_history eh WHERE op.id = eh.order_product_id)) as attempt_left',
      ];
      $condition['o.status'] = 1;
      $condition['o.user_id'] = $this->logged_in_user_id;
      $condition['e.id IS NOT NULL'] = NULL; 
      $group_by = null;
      $order_by = ['field' => 'payment_date', 'type' => 'desc'];
      $data['query'] = $this->common_model->dbselect('gha_order o', $condition, $select_data, $start, $join, $order_by, $limit = null, $group_by)->result_array();
      
      $data['title'] = 'Dashboard';
      $data['user_data'] = $this->get_logged_in_user_details();
      $data['view_file'] = 'frontend/user/dashboard/index';
      $this->load->view($this->layout, $data);
    }

    public function certificate() {
      $data['view_file'] = '';
      $data['view_file'] = 'Certificate';
      $this->load->view($this->layout, $data);
    }

    public function logout() {
      $this->session->unset_userdata('logged_in_user_data');
      redirect(base_url());
    }
  }
?>