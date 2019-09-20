<?php
class Exam extends Backend_Controller { 
	
	public function __construct() {
		parent::__construct();

		$arr = [
			"CREATE TABLE `gha_study_material` (
			 `id` int(11) NOT NULL AUTO_INCREMENT,
			 `study_material` text NOT NULL,
			 `type` varchar(255) NOT NULL,
			 `course_id` int(11) NOT NULL,
			 `status` tinyint(4) NOT NULL DEFAULT '0',
			 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			 `updated_at` timestamp NULL DEFAULT NULL,
			 PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1",
			"CREATE TABLE `gha_cart` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `course_id` int(11) NOT NULL,
 `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1",
"CREATE TABLE `gha_order` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `order_course_id` int(11) NOT NULL,
 `status` tinyint(4) NOT NULL DEFAULT '0',
 `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1",
"CREATE TABLE `gha_order_product` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `course_id` int(11) NOT NULL,
 `course_title` varchar(255) NOT NULL,
 `course_price` decimal(10,2) NOT NULL,
 `course_duration` int(11) NOT NULL,
 `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
 `updated_at` datetime DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1",

		];

		foreach ($arr as $key => $value) {
			if ($this->db->query($value)) {
				echo "-------success-----";
			} else {
				echo "-------failed-----";
			}
			echo "<br>";
		}
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
			$condition['(sm.email LIKE "%'.$search.'%" OR sm.phone LIKE "%'.$search.'%")' ] = NULL;
			$base_url .= '&search='.$search; 
		}

		if ($start_date !== '' && $end_date !== '') {
			$condition['(DATE(sm.created_at) >= "'.Date('Y-m-d', strtotime($start_date)) .'" AND DATE(sm.created_at) <= "'.Date('Y-m-d', strtotime($end_date)).'")' ] = NULL;
			$base_url .= '&start_date='.$start_date.'&end_date='.$end_date; 
		}

		$this->load->library('pagination');
		$order_by = ['field' => 'sm.id', 'type' => 'desc'];
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
				'condition' => 'c.id = sm.course_id',
			]
		];
		$select_data = ['c.title as course_title', 'sm.*'];
		$query = $this->common_model->dbselect('gha_exams sm',$condition, $select_data, $per_page,$join, $order_by, $limit); 
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

				$material_type = $this->input->post('material_type');

				$insert_data = [
					'course_id' => 	$this->input->post('course_id'),
					'type' => 	$this->input->post('material_type'), 
					'status' => 	$this->input->post('status'),
				];
				

				$image_err = 0;

				if (in_array($material_type, ['ppt','pdf','img','doc'])) {

					$do_upload = $this->do_upload('featured_image', './uploads/exam');
					
					if ($update_id > 0) {
						if (isset($_FILES['featured_image']['name']) && $_FILES['featured_image']['name'] !== '' ) {
							$image_err = $do_upload['err']; 
							$featured_image = isset($do_upload['file_name']) ? $do_upload['file_name'] : $data['study_material'];
						} else {
							$featured_image = $data['study_material'];
						}
					} else {
						$image_err = $do_upload['err'];
						$featured_image = isset($do_upload['file_name']) ? $do_upload['file_name'] : '';
					}
				}

				$insert_data['study_material'] = $featured_image;

				if ($image_err == 0 ) {
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
					$data['featured_image_error'] = $do_upload['error_message'];
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