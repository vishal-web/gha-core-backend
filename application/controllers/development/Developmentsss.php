<?php
	
	class Development extends Backend_Controller {

		public function __constructor() {
			parent::__construct();
			$this->load->library('form_validation');
		}

		public function dashboard() {
			$data['headline'] = 'Dashboard'; 
			$data['view_file'] = 'backend/dashboard';

			$query = $this->common_model->dbselect('gha_registration');
			
			$this->load->view('backend/backend-layout', $data);
		}

		public function questionList() { 
			$data['headline'] = 'Manage Questions'; 
			$data['view_file'] = 'backend/question/question-';
			$data['edit_url'] = base_url().'development/questioncreate';

			

			$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
			$base_url = base_url().'development/question';
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
			$this->load->view('backend/backend-layout', $data); 
		}

		public function questionCreate() {
			$update_id = (int)$this->uri->segment(4);
		
			$headline = 'Add New Question';
			if ($update_id > 0) {
				$headline = 'Update Question Details';
				$getData = $this->common_model->dbselect('gha_questions', ['id' => $update_id])->result_array();
				if (empty($getData)) {
					redirect(base_url().'development/questioncreate');
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
					if (!empty($choice)) {
						foreach ($choice as $key => $row) {
							if (trim($row['answer']) == '') {
								unset($choice[$key]);
							}
						}
					}

					$insert_data = [
						'question_title' => $this->input->post('question_title'),
						'is_multiple_choice' => 	$this->input->post('is_multiple_choice'),
						'updated_at' => Date('Y-m-d H:i:s a'),
						'options' => serialize($choice)
					];

					if ($update_id > 0) {
						$query = $this->common_model->dbupdate('gha_questions',$insert_data,['id' => $update_id]);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Question details has been successfully updated.');
							$this->session->set_flashdata('flash_type', 'success');
							redirect(current_url());	
						}
					} else {
						$query = $this->common_model->dbinsert('gha_questions', $insert_data);
						if ($query) {
							$this->session->set_flashdata('flash_message', 'Question has been successfully added.');
							$this->session->set_flashdata('flash_type', 'success');
							
							redirect(current_url());
						}
					}
				}
			}

			if ($this->input->post('submit') == 'cancel') {
				redirect(base_url().'development/question');
			}

			if ($update_id > 0 && $submit !== 'submit') {
				$choice = !empty(unserialize($data['options'])) ? unserialize($data['options']) : [];			
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
			
			$data['form_location'] = current_url();
		

			$data['flash_message'] = $this->session->flashdata('flash_message');
			$data['flash_type'] = $this->session->flashdata('flash_type');

			$data['headline'] = $headline;
			$data['view_file'] = 'backend/question/question-create';

			$this->load->view('backend/backend-layout', $data); 
		}

		public function do_upload($image, $upload_path) {
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['encrypt_name'] = TRUE;
			// $config['max_size'] = 2048;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($image)) {
				$uploadData['err'] = 1;
				$uploadData['error_message'] = $this->upload->display_errors('<p class="text-danger">','</p>'); 
			} else {
				$uploadData['err'] = 0;
				$uploadData['file_name'] = $this->upload->data()['file_name']; 
			}

			return $uploadData;
		}



		public function check_email_exists($str) {
			$update_id = (int)$this->uri->segment(4);

			if ($str != '') {
				$condition['email'] = $str;
				if ($update_id > 0) {
					unset($condition);
					$condition['id != ' .$update_id . ' AND email = "'.$str.'"'] = null;
				}
	
				$query = $this->common_model->dbselect('gha_registration',$condition)->result_array();

				if (!empty($query)) {

					$this->form_validation->set_message('check_email_exists', 'This email address is already exists');
					return FALSE;
				} else {
					return TRUE;
				}
			}
		}
	}
?>