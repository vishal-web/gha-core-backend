<?php
  class Studymaterial extends User_Controller {
    
    public function __construct() {
      parent::__construct();
      $this->load->helper('form');
    }

    public function index() { 

      $join = [ 
        ['type' => 'LEFT', 'condition' => 'o.id = op.order_id', 'table' => 'gha_order_product op'],
        ['type' => 'LEFT', 'condition' => 'sm.course_id = op.course_id AND sm.status = 1', 'table' => 'gha_study_material sm'],
      ];

      $start = null;
      $select_data = [ 
        'DISTINCT(sm.course_id)',  
        'op.course_title'
      ];

      $order_by = null;
      $condition['o.status'] = 1;
      $condition['o.user_id'] = $this->logged_in_user_id;
      $condition['sm.id IS NOT NULL'] = NULL;
      $group_by = null;
      $data['query'] = $this->common_model->dbselect('gha_order o', $condition, $select_data, $start, $join, $order_by, $limit = null, $group_by)->result_array();
  
      $data['headline'] = $data['title'] = $this->head_title = 'Study Material'; 
      $data['view_file'] = 'frontend/user/studymaterial/index';
      $this->load->view($this->layout, $data);
    }

    public function course() {
      $course_id = $this->uri->segment('4');
      if ($course_id === '' || !is_numeric($course_id)) {
        redirect(base_url('user/studymaterial'));
      }

      // check if user enrolled for this material
      $this->check();
      $data['block_ctr'] = TRUE;
      $data['query'] = $this->common_model->dbselect('gha_study_material', ['course_id' => $course_id,'status' => 1])->result_array();      
      $data['course_details'] = $this->get_course_details($data['query'][0]['course_id']);
      

      $data['course_id'] = $course_id;
      $data['headline'] = $data['title'] = $this->head_title  = $data['course_details']['title'].' Modules';
      $data['view_file'] = 'frontend/user/studymaterial/course';
      $this->load->view($this->layout, $data);
    }

    public function preview() {
      $course_id = $this->uri->segment('4');
      $material_id = $this->uri->segment('5');
      if ($course_id === '' || !is_numeric($course_id)) {
        redirect(base_url('user/studymaterial'));
      }

      // check if user enrolled for this material
      $this->check();
      $data['block_ctr'] = TRUE;

      $condition = [
        'id' => $material_id,
        'course_id' => $course_id,
        'status' => 1
      ];

      $data['query'] = $this->common_model->dbselect('gha_study_material', $condition)->result_array();      
      $data['course_details'] = $this->get_course_details($data['query'][0]['course_id']);

      $data['headline'] = $this->head_title = 'Study Material Preview';
      $data['view_file'] = 'frontend/user/studymaterial/preview';
      $this->load->view($this->layout, $data);
    }

    private function check() { 
      $course_id = $this->uri->segment('4');
      
      $join = [ 
        ['type' => 'LEFT', 'condition' => 'o.id = op.order_id', 'table' => 'gha_order_product op'],
        ['type' => 'LEFT', 'condition' => 'sm.course_id = op.course_id AND sm.status = 1', 'table' => 'gha_study_material sm'],
      ];

      $start = null;
      $select_data = ['op.course_title'];
      $order_by = null;
      $condition['o.status'] = 1;
      $condition['o.user_id'] = $this->logged_in_user_id; 
      // $condition['sm.id'] = $material_id;
      $condition['op.course_id'] = $course_id;
      $group_by = null;
      $query = $this->common_model->dbselect('gha_order o', $condition, $select_data, $start, $join, $order_by)->result_array();
  
      if (empty($query)) {
        redirect(base_url().'user/studymaterial');
      }
    }

    private function get_course_details($course_id) {
      $condition['id'] = $course_id;
      $query = $this->common_model->dbselect('gha_courses', $condition, '*')->result_array();
      return !empty($query) ? $query[0] : [];
    }

  }
?>