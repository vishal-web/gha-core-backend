<?php
class Exam extends Backend_Controller { 
	
	public function __construct() {
		parent::__construct();
	}


	public function manage() { 
		$data['headline'] = 'Manage Exam'; 
		$data['view_file'] = 'backend/exam/manage';
		$data['edit_url'] = $data['add_url'] = base_url().'development/exam/create'; 

		$search = trim($this->input->get('search'));			
		$start_date = trim($this->input->get('start_date'));			
		$end_date = trim($this->input->get('end_date'));			

		$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
		$base_url = base_url().'development/exam/manage';
		$condition = [];

		if (isset($_GET['search']) || (isset($_GET['start_date']) && isset($_GET['end_date']))) {
			$base_url .= '?query=';
		}

		if ($search !== '') {
			$condition['(e.email LIKE "%'.$search.'%" OR e.phone LIKE "%'.$search.'%")' ] = NULL;
			$base_url .= '&search='.$search; 
		}

		if ($start_date !== '' && $end_date !== '') {
			$condition['(DATE(e.created_at) >= "'.Date('Y-m-d', strtotime($start_date)) .'" AND DATE(e.created_at) <= "'.Date('Y-m-d', strtotime($end_date)).'")' ] = NULL;
			$base_url .= '&start_date='.$start_date.'&end_date='.$end_date; 
		}

		$this->load->library('pagination');
		$order_by = ['field' => 'e.id', 'type' => 'desc'];
		$limit	= 10;
		$total_result	= $this->common_model->dbselect("gha_exams",$condition, "COUNT(id) as Total")->result_array();

		$this->config->load('pagination');
		$config = $this->config->item('case2');
		$config['per_page']		= $limit;
		$config['page_query_string'] 	= TRUE;
		$config['total_rows']	= $total_result[0]['Total'];
		$config['base_url']		= $base_url;

		$this->pagination->initialize($config);

		$join = [
			[
				'type' => 'LEFT',
				'table' => 'gha_courses c',
				'condition' => 'c.id = e.course_id',
			]
		];
		$select_data = ['c.title as course_title', 'e.*'];
		$query = $this->common_model->dbselect('gha_exams e',$condition, $select_data, $per_page,$join, $order_by, $limit); 
		$data['query'] = $query->result_array();

		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	public function create() { 
		$update_id = (int)$this->uri->segment(4);

		$headline = 'Add New Exam';
		if ($update_id > 0) {
			$headline = 'Update Exam Details';
			$getData = $this->common_model->dbselect('gha_exams', ['id' => $update_id])->result_array();
			if (empty($getData)) {
				redirect(base_url().'development/exam/create');
			} else {
				$data = $getData[0];
			}
		}

		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if ($this->input->post('submit') == 'submit') {
			if($this->form_validation->run('admin_exam_create')) {

				$insert_data = [
					'course_id' => 	$this->input->post('course_id'), 
					'status' => 	$this->input->post('status'),
					'title' => 	$this->input->post('title'),
					'duration' => 	$this->input->post('duration'),
					'duration_type' => 	$this->input->post('duration_type'),
					'each_marks' => 	$this->input->post('each_marks'),
					'attempt' => 	$this->input->post('attempt'),
					'passing_percentage' => 	$this->input->post('passing_percentage'),
					'course_id' => 	$this->input->post('course_id'),
					'total_question' => 	$this->input->post('total_question'),
					'created_at' => Date('Y-m-d H:i:s'),
				];

				$course_question_count = $this->get_total_question($insert_data['course_id']);
				$course_question_count = !empty($course_question_count) ? $course_question_count[0]['count'] : 0; 

				if ($course_question_count >= $insert_data['total_question']) {
					if ($update_id > 0) {
						$query = $this->common_model->dbupdate('gha_exams',$insert_data,['id' => $update_id]);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Exam details has been successfully updated.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					} else {
						$query = $this->common_model->dbinsert('gha_exams', $insert_data);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Exam has been successfully added.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					}	
				} else {
					$data['total_question_error'] = '<p class="text-danger">The selected course has '.$course_question_count.' questions</p>';
				}
			}
		}
					
		if ($this->input->post('submit') == 'cancel') {
			redirect(base_url().'development/exam/manage');
		}


		$data['headline'] = $headline;  
		$data['form_location'] = current_url();
		$data['course_dd'] = $this->get_courses_dd();
		$data['material_dd'] = get_material_dd();

		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
	
		$data['view_file'] = 'backend/exam/create';
		$data['update_id'] = $update_id;
		$this->load->view($this->layout, $data); 
	}


	public function view() {

	}

	private function get_courses_dd() {
		$order_by['field'] = 'title';
		$order_by['type'] = 'asc';
		$select_data = ['id', 'title', '(SELECT count(id) FROM gha_questions WHERE gha_questions.course_id = gha_courses.id AND status = 1) as question_count'];
		$query = $this->common_model->dbselect('gha_courses',  ['status' => 1],$select_data,null,null,$order_by)->result_array();
		$options[''] = 'Choose Course';

		if (!empty($query)) {
 			foreach ($query as $row) {
 				$options[$row['id']] = $row['title'] .' => '. $row['question_count'];
			}	
		}

		return $options;
	}

	private function get_total_question($course_id) { 
		return $this->common_model->dbselect('gha_questions', ['course_id' => $course_id, 'status' => '1'],'count(id) as count')->result_array();
	}
}
?>