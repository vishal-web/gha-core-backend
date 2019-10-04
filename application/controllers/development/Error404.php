<?php
  Class Error404 extends CI_Controller {

    public function __construct() {
      parent::__construct();
    }

    public function index() {
      echo 'Error404';

      $this->load->view('frontend/user/')
    }
  }
?>