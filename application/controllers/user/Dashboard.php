<?php
  class Dashboard extends User_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->helper('form');
    }

    public function index() {
      $data['user_data'] = $this->get_logged_in_user_details();
      $data['view_file'] = 'frontend/user/dashboard/index';
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