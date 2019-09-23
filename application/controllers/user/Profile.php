<?php
  class Profile extends User_Controller {
    
    public function __construct() {
      parent::__construct();
      $this->load->helper('form');
    }

    public function index() {
      $data['profile'] = $this->get_logged_in_user_details()[0];

      $this->load->library('form_validation');
      $submit = $this->input->post('submit');
      if ($submit === 'update') {
      
        $error['required'] = 'Please choose %s from  dropdown.';
        $this->form_validation->set_rules('firstname','Firstname','trim|required');
        $this->form_validation->set_rules('lastname','Lastname','trim|required');
        $this->form_validation->set_rules('phone','phone','trim|required');
        $this->form_validation->set_rules('city','City','trim|required',$error);
        $this->form_validation->set_rules('state','State','trim|required',$error);
        $this->form_validation->set_rules('country','Country','trim|required',$error);
        $this->form_validation->set_rules('profession','Profession','trim|required',$error);
        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
        if ($this->form_validation->run()) {
          
          $update_data = [
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'country' => $this->input->post('country'),
            'state' => $this->input->post('state'),
            'city' => $this->input->post('city'),
            'about' => $this->input->post('about'), 
            'phone' => $this->input->post('phone'), 
            'updated_at' => Date('Y-m-d H:i:s'), 
          ];

          $img_error = 0;
          if (isset($_FILES) && isset($_FILES['userprofile']['name']) && $_FILES['userprofile']['name'] !== '') { 
            $do_upload = $this->do_upload('userprofile', './uploads/profile');
            $img_error = $do_upload['err'];
            $update_data['profile_picture'] = $img_error == 0 ? $do_upload['file_name'] : '';
          }

          if ($img_error === 0) {

            $query = $this->common_model->dbupdate('gha_registration',$update_data,['id' => $this->logged_in_user_id]);
            if ($query) {
              $this->session->set_flashdata('flash_message', 'Your details have been successfully updated.');
              $this->session->set_flashdata('flash_type', 'success'); 
            } else {
              $this->session->set_flashdata('flash_message', 'Something went wrong.');
              $this->session->set_flashdata('flash_type', 'danger');
            }
            
            redirect(current_url());
          } else {
            $data['image_error'] = $do_upload['error_message'];
          }
        }
      }

      if ($submit === 'changepass') {
        $this->form_validation->set_rules('pass', 'Password','trim|required');
        $this->form_validation->set_rules('confpass', 'Confirm password','trim|required|matches[pass]');

        if ($data['profile']['password'] !== '') {
          $this->form_validation->set_rules('oldpass', 'Old password','trim|required');
        }

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
        if ($this->form_validation->run()) {
          $update_data['password'] = $this->input->post('pass');
          
          $old_password_match = TRUE;
          if ($data['profile']['password'] !== '') {
            if ($data['profile']['password'] !== $this->input->post('oldpass')) {
              $old_password_match = FALSE;
            }
          }

          if ($old_password_match) { 
            $query = $this->common_model->dbupdate('gha_registration',$update_data,['id' => $this->logged_in_user_id]);
            if ($query) {
              $this->session->set_flashdata('flash_message', 'Password has been successfully updated.');
              $this->session->set_flashdata('flash_type', 'success'); 
            } else {
              $this->session->set_flashdata('flash_message', 'Something went wrong.');
              $this->session->set_flashdata('flash_type', 'danger');
            }
            
            redirect(current_url()); 
          } else {
            $data['password_match_err_message'] = '<p class="text-danger">Incorrect password</p>'; 
          }
        }
      }

      $message = '';

      if($data['profile']['city'] == 0 || $data['profile']['state'] == 0 || $data['profile']['country'] == 0) {
        $message = 'Please complete your profile first.';
      } else if ($data['profile']['password'] == '') {
        $message = 'Please create a new password'; 
      }
      

      $data['message'] = $message;
      $data['flash_message'] = $this->session->flashdata('flash_message');
      $data['flash_type'] = $this->session->flashdata('flash_type');
      $data['country_dropdown'] = $this->get_country_dropdown();
      $data['state_dropdown'] = $this->get_state_dropdown((int)$data['profile']['country']);
      $data['city_dropdown'] = $this->get_city_dropdown((int)$data['profile']['state']);
      $data['profession_dropdown'] = $this->get_profession_dropdown();
      $data['view_file'] = 'frontend/user/profile/index';
      $this->load->view($this->layout, $data);
    }

    public function get_profession_dropdown() {
      $options[''] = 'Select profession';
      $query = $this->common_model->dbselect('gha_profession')->result_array();
      foreach ($query as $row) {
        $options[$row['id']] = $row['name'];
      }
      return $options;
    }

    public function get_country_dropdown() {
      $query = $this->common_model->dbselect('gha_countries')->result_array();
      $options[''] = 'Select country';
      foreach ($query as $row) {
        $options[$row['id']] = $row['name'];
      }
      return $options;
    }

    public function get_state_dropdown($country_id) {
      $options[''] = 'Select state';
      if ($country_id > 0) {
        $query = $this->common_model->dbselect('gha_states', ['country_id' => $country_id])->result_array();
        foreach ($query as $row) {
          $options[$row['id']] = $row['name'];
        }
      }
      return $options;
    }

    public function get_city_dropdown($state_id) {
      $options[''] = 'Select city';
      if ($state_id > 0) {
        $query = $this->common_model->dbselect('gha_cities', ['state_id' => $state_id])->result_array();
        foreach ($query as $row) {
          $options[$row['id']] = $row['name'];
        }
      }
      return $options;
    }

  }
?>