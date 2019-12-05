<?php
  class Exams extends User_Controller {
    
    public function __construct() {
      parent::__construct();
    }

    // https://dba.stackexchange.com/questions/107250/query-how-to-get-both-question-and-multi-answers-in-one-query/107257#107257

    public function index() { 

      $join = [
        ['type' => 'LEFT', 'condition' => 'o.id = op.order_id', 'table' => 'gha_order_product op'],
        ['type' => 'LEFT', 'condition' => 'e.course_id = op.course_id AND e.status = 1', 'table' => 'gha_exams e'],
      ];

      $start = null;
      $select_data = ['e.*', 'op.course_title'];
      $order_by = null;
      $condition['o.status'] = 1;
      $condition['o.user_id'] = $this->logged_in_user_id;
      $condition['e.id IS NOT NULL'] = NULL;
      $group_by = null;
      $data['query'] = $this->common_model->dbselect('gha_order o', $condition, $select_data, $start, $join, $order_by, $limit = null, $group_by)->result_array();

      $data['headline'] = $this->head_title = 'Exams';
      $data['view_file'] = 'frontend/user/exams/index';
      $this->load->view($this->layout, $data);
    }

    public function preview() {
      $exam_id = $this->uri->segment('4');
      if ($exam_id === '' || !is_numeric($exam_id)) {
        redirect(base_url('user/exams'));
      }

      $this->session->unset_userdata(['exam_session_data', 'referrer_from_preview']);

      $this->session->set_userdata('referrer_from_preview', true);

      // check if user enrolled for this exam
      $this->check();

      $data['query'] = $this->common_model->dbselect('gha_exams', ['id' => $exam_id,'status' => 1])->result_array();      
      $data['headline'] = $this->head_title = 'Exam Preview';
      $data['view_file'] = 'frontend/user/exams/preview';
      $this->load->view($this->layout, $data);
    }

    public function start() {
      $exam_id = $this->uri->segment('4');
      if ($exam_id === '' || !is_numeric($exam_id)) {
        redirect(base_url('user/exams'));
      }

      $submit = $this->input->post('submitexam');

      if ($submit == '') {
        $this->allow_only_them_who_refer_from_preview_page();
      }

      // check if user enrolled for this exam
      $this->check();

      $exam_query = $this->common_model->dbselect('gha_exams', ['id' => $exam_id,'status' => 1])->result_array();
      
      $data['exam_query'] = $exam_query[0];

      if (empty($this->session->userdata('exam_session_data'))) {

        $exam_start_at = Date('Y-m-d H:i:s');
        $exam_end_at = Date('Y-m-d H:i:s', strtotime('+ '.$exam_query[0]['duration'].' '.$exam_query[0]['duration_type']));

        $exam_session_data = [
          'exam_id' => $exam_query[0]['id'],
          'exam_start_at' => $exam_start_at,
          'exam_end_at' => $exam_end_at,
        ];

        $this->session->set_userdata('exam_session_data', $exam_session_data);
      }


      


      if ($submit == 'submitexam') {
        $question = $this->input->post('question');
        $answer = $this->input->post('answer');

        $each_marks = $exam_query[0]['each_marks'];
        $scored_marks = 0;

        $exam_history = $this->get_exam_history_id($exam_query[0]['id'], $this->logged_in_user_id);
        $exam_history_id = !empty($exam_history) ? $exam_history['id'] : 0;

        $visited = (int)$this->input->post('visited');
        $answered = (int)$this->input->post('answered');
        $not_answered = (int)$this->input->post('not_answered');
        $marked = (int)$this->input->post('marked');

        $answer_counter = $visited_counter = $not_answered_counter = $marked_counter = 0;

        if (!empty($answer) && $exam_history_id > 0) {
          foreach ($answer as $key => $row) {
            $get_answers = $this->get_answers_for_question($key);
            $question_details = $this->get_question_details($key);
            $question_title = $question_details['question_title'];
            $question_id = $question_details['id'];

            // $user_ans_key = array_values($row);
            $filter_answer = array_filter($row);
            $filter_answer_key = key($filter_answer);
            $answer_counter = !empty($filter_answer) ? ++$answer_counter : $answer_counter;
            $user_answer_id = !empty($filter_answer) ? $filter_answer[$filter_answer_key] : 0;
      
            $correct_answer = array_filter($get_answers, function($row){
              return $row['correct'] == 1;
            });

            $correct_answer_key = key($correct_answer);
            $correct_answer_arr = $correct_answer[$correct_answer_key];

            if ($correct_answer_arr['id'] == $user_answer_id) {
              $scored_marks += $each_marks;
            }

            $history_data = [
              'question_title' => $question_title,
              'exam_history_id' => $exam_history_id,
              'answers' => serialize([
                'question_id' => $question_id,
                'user_answer_id' => $user_answer_id,
                'answers' => $get_answers,
              ]),
              'created_at' => Date('Y-m-d H:i:s'),
            ];

            $this->add_exam_history_details($history_data);
          }

          $passing_percentage = $exam_query[0]['passing_percentage'];
          $total_question = $exam_query[0]['total_question'];
          $calculate_pecentage = ($scored_marks * 100) / ($total_question * $each_marks);


          $updateData = [
            'percentage' => $calculate_pecentage,
            'total_score' => $scored_marks,
            'status' => $passing_percentage < $calculate_pecentage ? 1 : 0, 
            'finished_at' => Date('Y-m-d H:i:s'),
            'visited' => $visited,
            'answered' => $answered,
            'not_answered' => $not_answered,
            'marked' => $marked,
            'total_question' => $total_question,
            'passing_percentage' => $passing_percentage,
          ];

          $condition['id'] = $exam_history_id;
          $this->common_model->dbupdate('gha_exams_history',$updateData, $condition);          
          redirect(base_url('user/exams/summary/'.$exam_history_id));
        }
      }

      $mysql_query = "SELECT * FROM gha_questions 
      WHERE course_id = '".$exam_query[0]['course_id']."'
      ORDER BY RAND() 
      LIMIT ".$exam_query[0]['total_question'];

      $data['exam_session_data'] = $this->session->userdata('exam_session_data');
      $data['query'] = $this->db->query($mysql_query);
      $data['controller'] = $this;
      $data['view_file'] = 'frontend/user/exams/start';
      $data['headline'] = $this->head_title = $exam_query[0]['title'];
      $this->load->view($this->layout, $data);
    }

    private function unset_exam_session() {
      $this->session->unset_userdata(['exam_session_data', 'referrer_from_preview']);
    }

    public function summary() {
      $this->unset_exam_session();
      
      $summary_id = $this->uri->segment('4');
      if ($summary_id === '' || !is_numeric($summary_id)) {
        redirect(base_url('user/exams'));
      }

      $condition['exam_history_id'] = $summary_id;
      $data['query'] = $this->common_model->dbselect('gha_exams_history_details', $condition)->result_array(); 
      unset($condition);
      $condition['id'] = $summary_id;
      $data['exam_details'] = $this->common_model->dbselect('gha_exams_history', $condition)->result_array(); 
      if (empty($data['exam_details'])) {
        redirect(base_url().'user/exams');
      }

      $data['headline'] = $this->head_title = 'Exam Summary';
      $data['view_file'] = 'frontend/user/exams/summary';
      $this->load->view($this->layout, $data);
    }

    public function history() { 

      $join = [ 
        ['type' => 'LEFT', 'condition' => 'e.id = eh.exam_id', 'table' => 'gha_exams_history eh'],
      ];

      $start = null;
      $select_data = ['e.*', 'eh.*'];
      $order_by['field'] = 'eh.id'; 
      $order_by['type'] = 'desc'; 
      $condition['eh.user_id'] = $this->logged_in_user_id;
      $condition['eh.finished_at IS NOT NULL'] = NULL;
      $group_by = null;
      $data['query'] = $this->common_model->dbselect('gha_exams e', $condition, $select_data, $start, $join, $order_by, $limit = null, $group_by)->result_array();

      $data['headline'] = $this->head_title = 'Exam History';
      $data['view_file'] = 'frontend/user/exams/history';
      $this->load->view($this->layout, $data);
    }

    private function allow_only_them_who_refer_from_preview_page() {
      if (strpos($this->referrer_url,"preview") === false) {
        redirect(base_url('user/exams'));
      } 
    }

    private function check() {
      $exam_id = $this->uri->segment('4');
      
      $join = [
        ['type' => 'LEFT', 'condition' => 'o.id = op.order_id', 'table' => 'gha_order_product op'],
        ['type' => 'LEFT', 'condition' => 'e.course_id = op.course_id AND e.status = 1', 'table' => 'gha_exams e'],
      ];

      $start = null;
      $select_data = ['e.*', 'op.course_title'];
      $order_by = null;
      $condition['o.status'] = 1;
      $condition['o.user_id'] = $this->logged_in_user_id; 
      $condition['e.id'] = $exam_id;
      $group_by = null;
      $query = $this->common_model->dbselect('gha_order o', $condition, $select_data, $start, $join, $order_by)->result_array();
      
      if (empty($query)) {
        redirect(base_url().'user/exams');
      }
    }

    public function get_options($question_id) {
      $condition['question_id'] = $question_id;
      return $this->common_model->dbselect('gha_answers', $condition)->result_array();
    }

    private function get_answers_for_question($question_id) {
      $condition['question_id'] = $question_id;
      return $this->common_model->dbselect('gha_answers', $condition, 'answer,correct, image, id')->result_array();
    }

    
    private function get_question_details($question_id) {
      $condition['id'] = $question_id;
      $query = $this->common_model->dbselect('gha_questions', $condition, 'question_title, id')->result_array();
      return !empty($query) ? $query[0] : [];
    }

    private function get_exam_history_id($exam_id, $user_id) {
      $mysql_query = "SELECT MAX(id) as id FROM gha_exams_history WHERE exam_id = '".$exam_id."' AND user_id = '".$user_id."'";
      $query = $this->db->query($mysql_query)->result_array();
      return !empty($query) ? $query[0] : [];
    }


    private function add_exam_history_details($data) {
      return $this->common_model->dbinsert('gha_exams_history_details', $data);
    }
  }
?>