<?php
  class Exams extends User_Controller {
    
    public function __construct() {
      parent::__construct();
    }

    // https://dba.stackexchange.com/questions/107250/query-how-to-get-both-question-and-multi-answers-in-one-query/107257#107257

    public function index() { 

      $join = [ 
        ['type' => 'LEFT', 'condition' => 'o.order_product_id = op.id', 'table' => 'gha_order_product op'],
        ['type' => 'LEFT', 'condition' => 'e.course_id = op.course_id AND e.status = 1', 'table' => 'gha_exams e'],
      ];

      $start = null;
      $select_data = ['e.*', 'op.course_title'];
      $order_by = null;
      $condition['o.status'] = 1;
      $condition['op.user_id'] = $this->logged_in_user_id;
      $condition['e.id IS NOT NULL'] = NULL;
      $group_by = null;
      $data['query'] = $this->common_model->dbselect('gha_order o', $condition, $select_data, $start, $join, $order_by, $limit = null, $group_by)->result_array();


      $data['view_file'] = 'frontend/user/exams/index';
      $this->load->view($this->layout, $data);
    }

    public function start() {
      $exam_id = $this->uri->segment('4');
      if ($exam_id === '' || !is_numeric($exam_id)) {
        redirect(base_url('user/exams'));
      }

      // check if user enrolled for this exam
      $this->check();

      $exam_query = $this->common_model->dbselect('gha_exams', ['id' => $exam_id])->result_array();
      
      $data['exam_query'] = $exam_query[0];

      $mysql_query = "SELECT * FROM gha_questions 
      WHERE course_id = '".$exam_query[0]['course_id']."'
      ORDER BY RAND() 
      LIMIT ".$exam_query[0]['total_question']."
      ";
      $data['query'] = $this->db->query($mysql_query);
      $data['controller'] = $this;
      $data['view_file'] = 'frontend/user/exams/start';
      $this->load->view($this->layout, $data);
    }

    private function check() {
      $exam_id = $this->uri->segment('4');
      
      $join = [ 
        ['type' => 'LEFT', 'condition' => 'o.order_product_id = op.id', 'table' => 'gha_order_product op'],
        ['type' => 'LEFT', 'condition' => 'e.course_id = op.course_id AND e.status = 1', 'table' => 'gha_exams e'],
      ];

      $start = null;
      $select_data = ['e.*', 'op.course_title'];
      $order_by = null;
      $condition['o.status'] = 1;
      $condition['op.user_id'] = $this->logged_in_user_id;
      $condition['op.user_id'] = $this->logged_in_user_id; 
      $condition['e.id'] = $exam_id;
      $group_by = null;
      $query = $this->common_model->dbselect('gha_order o', $condition, $select_data, $start, $join, $order_by)->result_array();
      
      if (empty($query)) {
        redirect(base_url().'user/exams');
      }
    }

    public function get_options($question_id) {
      return $this->common_model->dbselect('gha_answers', ['question_id' => $question_id])->result_array();
    }
  }
?>