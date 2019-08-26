<?php
	class Category extends CI_Controller {
		private $layout = 'backend/backend-layout';

		public function __construct() {
			parent::__construct();
		}

		public function manage() { 
			$data['headline'] = 'Manage Categories'; 
			$data['view_file'] = 'backend/category/manage';
			$data['edit_url'] = base_url().'development/category/create';

			$search = trim($this->input->get('search'));			
			$start_date = trim($this->input->get('start_date'));			
			$end_date = trim($this->input->get('end_date'));			

			$per_page = $this->input->get('per_page') != '' ? $this->input->get('per_page') : 0;
			$base_url = base_url().'development/category/manage';
			$condition['parent_id'] = 0;

			if (isset($_GET['search']) || (isset($_GET['start_date']) && isset($_GET['end_date']))) {
				$base_url .= '?query=';
			}

			if ($start_date !== '' && $end_date !== '') {
				$condition['(DATE(created_at) >= "'.Date('Y-m-d', strtotime($start_date)) .'" AND DATE(created_at) <= "'.Date('Y-m-d', strtotime($end_date)).'")' ] = NULL;
				$base_url .= '&start_date='.$start_date.'&end_date='.$end_date; 
			}

			$this->load->library('pagination');
			$order_by = ['field' => 'id', 'type' => 'desc'];
			$limit	= 10;
			$total_result	= $this->common_model->dbselect("gha_courses",$condition, "COUNT(id) as Total")->result_array();

			$this->config->load('pagination');
			$config = $this->config->item('case2');
			$config['per_page']		= $limit;
			$config['page_query_string'] 	= TRUE;
			$config['total_rows']	= $total_result[0]['Total'];
			$config['base_url']		= $base_url;

			$this->pagination->initialize($config);

			$query = $this->common_model->dbselect('gha_courses',$condition, null, $per_page,null, $order_by, $limit); 
			$data['query'] = $query->result_array();
			$data['table_head_title'] = 'Existing Categories';
			$data['form_location'] = current_url();
			$this->load->view($this->layout, $data); 
		}

		public function categoryCreate() { 
			$update_id = (int)$this->uri->segment(4);

			$headline = 'Add New Category';
			if ($update_id > 0) {
				$headline = 'Update Category Details';
				$getData = $this->common_model->dbselect('gha_courses', ['id' => $update_id])->result_array();
				if (empty($getData)) {
					redirect(base_url().'development/category/create');
				} else {
					$data = $getData[0];
				}
			}

			
 			$this->load->library('form_validation');
 			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
 			if ($this->input->post('submit') == 'submit') {
				if($this->form_validation->run('admin_category_create')) {
					$do_upload = $this->do_upload('featured_image', './uploads/backend/category');

					$insert_data = [
						'title' => 	$this->input->post('title'),
						'price' => 	$this->input->post('price'),
						'duration' => 	$this->input->post('duration'),
						'description' => 	$this->input->post('description'),
						'url_title' =>	url_title(strtolower($this->input->post('title'))),
					];
					
					$image_err = 0;

					if ($update_id > 0) {
						if (isset($_FILES['featured_image']['name']) && $_FILES['featured_image']['name'] !== '' ) {
							$image_err = $do_upload['err']; 
							$featured_image = isset($do_upload['file_name']) ? $do_upload['file_name'] : $data['featured_image'];
						} else {
							$featured_image = $data['featured_image'];
						}
					} else {
						$image_err = $do_upload['err'];
						$featured_image = isset($do_upload['file_name']) ? $do_upload['file_name'] : '';
					}

					$insert_data['featured_image'] = $featured_image;

					if ($image_err == 0) {
						if ($update_id > 0) {
							$query = $this->common_model->dbupdate('gha_courses',$insert_data,['id' => $update_id]);
							if ($query) {
								$this->session->set_flashdata('flash_message', 'Category details has been successfully updated.');
								$this->session->set_flashdata('flash_type', 'success');
								redirect(current_url());	
							}
						} else {
							$query = $this->common_model->dbinsert('gha_courses', $insert_data);
							if ($query) {
								$this->session->set_flashdata('flash_message', 'Category has been successfully added.');
								$this->session->set_flashdata('flash_type', 'success');
								redirect(current_url());	
							}
						}	
					} else { 
						$data['featured_image_error'] = $do_upload['error_message'];
					}
				}
			}
						
			if ($this->input->post('submit') == 'cancel') {
				redirect(base_url().'development/category/manage');
			}


			$data['headline'] = $headline; 
			
			$data['form_location'] = current_url();

			$data['flash_message'] = $this->session->flashdata('flash_message');
			$data['flash_type'] = $this->session->flashdata('flash_type');

			$data['headline'] = $headline;
			$data['view_file'] = 'backend/category/create';
			$data['table_head_title'] = 'Category Details';
			$data['update_id'] = $update_id;
			$this->load->view($this->layout, $data); 
		}
	}

?>