<?php
  class User extends CI_Controller {
    public $head_title = 'Gloobal Health Alliance';
    public $layout = 'frontend/frontend-layout';
    public $homepage = FALSE;
    public $logged_in_user_id = 0;

    public function __construct() {
      parent::__construct();
      $logged_in_user_data = $this->session->userdata('logged_in_user_data');
      if (empty($logged_in_user_data)) {
        redirect('login');
      }

      $this->logged_in_user_id = $logged_in_user_data['user_id'];
    }

    private function get_logged_in_user_details() {

      $join = [
        [
          'type' => 'left',
          'condition' => 'c.id = r.country', 
          'table' => 'gha_countries c'
        ],
        [
          'type' => 'left',
          'condition' => 's.id = r.state', 
          'table' => 'gha_states s'
        ],
        [
          'type' => 'left',
          'condition' => 'ct.id = r.city', 
          'table' => 'gha_cities ct'
        ],
        [
          'type' => 'left',
          'condition' => 'p.id = r.profession', 
          'table' => 'gha_profession p'
        ],
      ];

      $select_data = ['r.*', 'c.name as country_name', 's.name as state_name', 'ct.name as city_name', 'p.name as profession_name'];
      $query = $this->common_model->dbselect('gha_registration r', ['r.id' => $this->logged_in_user_id], $select_data, null, $join)->result_array();

      return $query;
    }

    public function index() {
      redirect(base_url().'user/dashboard');
    }

    public function dashboard() {
      $data['user_data'] = $this->get_logged_in_user_details();
      $data['view_file'] = 'frontend/user/dashboard';
      $this->load->view($this->layout, $data);
    }

    public function profile() {
      $data['view_file'] = '';
      $this->load->view($this->layout, $data);
    }

    public function payment() {
      $data['view_file'] = '';
      $this->load->view($this->layout, $data);
    }

    public function exam() {
      $data['view_file'] = '';
      $this->load->view($this->layout, $data);
    }

    public function studymaterial() {
      $data['view_file'] = '';
      $this->load->view($this->layout, $data);
    }

    public function certificate() {
      $data['view_file'] = '';
      $this->load->view($this->layout, $data);
    }

    public function logout() {
      $this->session->unset_userdata('logged_in_user_data');
      redirect(base_url());
    }
  }
?>