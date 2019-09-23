<?php
  class Studymaterial extends User_Controller {
    
    public function __construct() {
      parent::__construct();
      $this->load->helper('form');
    }

    public function index() {
      $data['view_file'] = '';
      $this->load->view($this->layout, $data);
    }
  }
?>