<?php
  class Review extends User_Controller {
    
    public function __construct() {
      parent::__construct();
    }

    public function index() {
      
      $condition['user_id'] = $this->logged_in_user_id;
      $data['query'] = $this->common_model->dbselect('gha_reviews', $condition)->result_array();
   
      $this->load->helper('form');
      $this->load->library('form_validation');
 
      $this->form_validation->set_rules('review', 'Review', 'required|trim');
      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
      if ($this->form_validation->run()) {
        $review = $this->input->post('review');
        $insertData = [
          'review' => $review,
          'user_id' => $this->logged_in_user_id,
          'created_at' => Date('Y-m-d H:i:s')
        ];

        if ($this->common_model->dbinsert('gha_reviews', $insertData)) {
          $this->session->set_flashdata('flash_message', 'Thank you for giving us your valuable review.');
          $this->session->set_flashdata('flash_type' , 'success');
        } else {
          $this->session->set_flashdata('flash_message', 'Something went wrong.');
          $this->session->set_flashdata('flash_type' , 'danger');
        }
        redirect(current_url());
      }

      $data['flash_message'] = $this->session->flashdata('flash_message');
      $data['flash_type'] = $this->session->flashdata('flash_type');

      $this->head_title = 'User | Review';
      $data['headline'] = 'Review';
      $data['view_file'] = 'frontend/user/review/index';
      $this->load->view($this->layout, $data);
    }
  }
?>