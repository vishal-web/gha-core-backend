<?php
  class Exams extends User_Controller {
    
    public function __construct() {
      parent::__construct();
    }

    public function index() { 

      $join = [
        ['type' => 'LEFT', 'condition' => 'c.id = e.course_id', 'table' => 'gha_courses c']
      ];

      $start = null;
      $select_data = ['e.*', 'c.title as course_title'];
      $order_by = null;
      $condition = null;
      $data['query'] = $this->common_model->dbselect('gha_exams e', $condition, $select_data, $start, $join, $order_by)->result_array();

      $data['view_file'] = 'frontend/user/exams/index';
      $this->load->view($this->layout, $data);
    }

    public function start() {
      $exam_id = $this->uri->segment('4');
      if ($exam_id === '' || !is_numeric($exam_id)) {
        redirect(base_url('user/exams'));
      }

      $exam_query = $this->common_model->dbselect('gha_exams', ['id' => $exam_id])->result_array();
      
      $data['exam_query'] = $exam_query[0];

      $mysql_query = "SELECT * FROM gha_questions 
      WHERE course_id = '".$exam_query[0]['course_id']."'
      ORDER BY RAND() 
      LIMIT ".$exam_query[0]['total_question']."
      ";
      $data['query'] = $this->db->query($mysql_query);



      $data['view_file'] = 'frontend/user/exams/start';
      $this->load->view($this->layout, $data);
    }
  }
?>