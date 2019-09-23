<?php
  class Payment extends User_Controller {
    
    public function __construct() {
      parent::__construct();
    }

    public function index() {
      $data['view_file'] = '';
      $this->load->view($this->layout, $data);
    }
  }
?>