<?php
class Question extends Backend_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function manage() { 
		$data['headline'] = 'Manage Questions'; 
		$data['view_file'] = 'backend/question/manage';
		$data['edit_url'] = base_url().'development/question/create';
		$data['view_url'] = base_url().'development/question/view';

		$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
		$base_url = base_url().'development/question/manage';
		$condition = [];

		$this->load->library('pagination');
		$order_by = ['field' => 'id', 'type' => 'desc'];
		$limit	= 10;
		$total_result	= $this->common_model->dbselect("gha_questions",$condition, "COUNT(id) as Total")->result_array();

		$this->config->load('pagination');
		$config = $this->config->item('case2');
		$config['per_page']		= $limit;
		$config['page_query_string'] 	= TRUE;
		$config['total_rows']	= $total_result[0]['Total'];
		$config['base_url']		= $base_url;

		$this->pagination->initialize($config);

		$query = $this->common_model->dbselect('gha_questions',$condition, null, $per_page,null, $order_by, $limit); 
		$data['query'] = $query->result_array();

		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data); 
	}

	public function create() {
		$update_id = (int)$this->uri->segment(4);
	
		$headline = 'Add New Question';
		if ($update_id > 0) {
			$headline = 'Update Question Details';
			$getData = $this->common_model->dbselect('gha_questions', ['id' => $update_id])->result_array();
			$getAns = $this->common_model->dbselect('gha_answers', ['question_id' => $update_id])->result_array();
			if (empty($getData)) {
				redirect(base_url().'development/question/create');
			} else {
				$data = $getData[0]; 
			}
		}

		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

		$submit = $this->input->post('submit');
		if ($submit == 'submit') {

			if($this->form_validation->run('admin_question_create')) {
				$choice = $this->input->post('choice');

				// options image upload
				if (isset($_FILES)) {
					$uploaded_options = $this->multiple_upload('choice','./uploads/question/options');
				}

				$correct_answer_checked = 0;
				if (!empty($choice)) {
					foreach ($choice as $key => $row) {

						if ($row['correct'] > 0) {
							$correct_answer_checked = $row['correct'];
						}

						// push new image if uploaded
						if ((isset($uploaded_options[$key]) && isset($uploaded_options[$key]['file_name']))) {
							$option_image = $uploaded_options[$key]['file_name'];
							$choice[$key]['image'] = $option_image;
						}

						if (trim($row['answer']) == '' && $choice[$key]['image'] == '') { 
							unset($choice[$key]); 
						}
					}
				} 

				if (empty($choice)) {
					$this->session->set_flashdata('flash_message', 'Please add some choices for this question.');
					$this->session->set_flashdata('flash_type', 'danger');

					redirect(current_url());
				}

				$serialize_choice = serialize($choice);

				$insert_data = [
					'question_title' => $this->input->post('question_title'),
					'course_id' => $this->input->post('course_id'),
					'description' => $this->input->post('description'),
					'status' => $this->input->post('status'),
					'is_multiple_choice' => 0,
					'updated_at' => Date('Y-m-d H:i:s a'),
					'options' => $serialize_choice
				];

				if ($correct_answer_checked > 0) {
					if ($update_id > 0) {
						$query = $this->common_model->dbupdate('gha_questions',$insert_data,['id' => $update_id]);
						if ($query) {
							$this->answers($update_id, $choice);
							$this->session->set_flashdata('flash_message', 'Question details has been successfully updated.');
							$this->session->set_flashdata('flash_type', 'success');

							redirect(current_url());	
						}
					} else {
						$query = $this->common_model->dbinsert('gha_questions', $insert_data);
						if ($query) {
							$this->answers($this->db->insert_id(), $choice);
							$this->session->set_flashdata('flash_message', 'Question has been successfully added.');
							$this->session->set_flashdata('flash_type', 'success');
							
							redirect(current_url());
						}
					}
				} else {
					$data['custom_error'] = 1;
					$data['custom_error_msg'] = 'Please check correct from any of the choices below.';
				}
			}
		}

		if ($this->input->post('submit') == 'cancel') {
			redirect(base_url().'development/question/manage');
		}

		if ($update_id > 0 && $submit !== 'submit') {
			$choice = $getAns;
			if (empty($choice)) {
				// $choice = !empty(unserialize($data['options'])) ? unserialize($data['options']) : [];
			}
		} else {
			$choice = $this->input->post('choice');
			if (!empty($choice)) {
				foreach ($choice as $key => $row) {
					if (trim($row['answer']) == '') {
						unset($choice[$key]);
					}
				}
			}
		}

		$data['choice'] = $choice; 
		$data['headline'] = $headline; 
		$data['editor'] = TRUE;
		$data['form_location'] = current_url();
		$data['courses_dd'] = $this->get_courses_dd();
		$data['update_id'] = $update_id;

		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');

		$data['headline'] = $headline;
		$data['view_file'] = 'backend/question/create';

		$this->load->view($this->layout, $data); 
	}

	public function view($question_id) {
		$question_id = (int)$question_id;

		if ($question_id == 0 || $question_id < 1) {
			redirect($this->referrer_url !== '' ? $this->referrer_url : base_url().'development/question/manage');
		}


		$data['query'] = $this->common_model->dbselect('gha_questions',['id' => $question_id])->result_array(); 
		$data['options'] = $this->common_model->dbselect('gha_answers',['question_id' => $question_id])->result_array(); 
		if (empty($data['query'])) {
			redirect($this->referrer_url !== '' ? $this->referrer_url : base_url().'development/question/manage');
		}

		$data['headline'] = 'View Question'; 
		$data['view_file'] = 'backend/question/view';
		$data['edit_url'] = base_url().'development/question/create/'.$question_id;
		$data['manage_url'] = base_url().'development/question/manage/';
		$data['form_location'] = current_url();

		$this->load->view($this->layout, $data); 
	}

	private function answers($question_id, $data) {
	
		if ($question_id > 0) {

			if (!empty($data)) {
				foreach ($data as $row) {
					$insert_data = [
						'answer' => $row['answer'],
						'correct' => $row['correct'],
						'question_id' => $question_id,
						'image' => isset($row['image']) && $row['image'] !== null && $row['image'] ? $row['image'] : '',
					];

					if (isset($row['answer_id']) && $row['answer_id'] > 0) {
						$insert_data['updated_at'] = Date('Y-m-d H:i:s');
						$this->common_model->dbupdate('gha_answers', $insert_data, ['id' => $row['answer_id']]);
					} else {
						$this->common_model->dbinsert('gha_answers', $insert_data);
					}
				}
			}
		}
	}

	private function get_courses_dd() {
		$order_by['field'] = 'title';
		$order_by['type'] = 'asc';
		$query = $this->common_model->dbselect('gha_courses',  ['status' => 1],null,null,null,$order_by)->result_array();
		$options[''] = 'Choose Course';
		if (!empty($query)) {
 			foreach ($query as $row) {
 				$options[$row['id']] = $row['title'];
			}	
		}

		return $options;
	}
}
?>