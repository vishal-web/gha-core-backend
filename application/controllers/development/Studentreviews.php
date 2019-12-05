<?php
class Studentreviews extends Backend_Controller {

	public function __construct() {
		parent::__construct();
  }
  
  public function manage() {

    $select_data = [
      'reg.firstname',
      'reg.lastname', 
      'reg.email', 
      'rev.id',
      'rev.review',
      'rev.status',
      'rev.created_at',
    ];
    $join = [
      ['type' => 'left', 'condition' => 'reg.id = rev.user_id', 'table' => 'gha_registration reg']
    ];
    $order_by = ['field' => 'rev.id', 'type' => 'desc'];
    $start = 0;
    $limit = 10;
    $condition = [];

    $this->load->library('pagination');
		$total_result	= $this->common_model->dbselect("gha_reviews",$condition, "COUNT(id) as Total")->result_array();

		$this->config->load('pagination');
		$config = $this->config->item('case2');
		$config['per_page']		= $limit;
		$config['page_query_string'] 	= TRUE;
		$config['total_rows']	= $total_result[0]['Total'];
		$config['base_url']		= current_url();
    
    $this->pagination->initialize($config);

    $query = $this->common_model->dbselect('gha_reviews rev', $condition, $select_data, $start, $join, $order_by, $limit);
    $data['query'] = $query->result_array();
    
    $data['headline'] = 'Student Reviews'; 
		$data['view_file'] = 'backend/student_reviews/manage';
    $data['edit_url'] = base_url('development/studentreviews/create');
		$data['form_location'] = current_url();
		$this->load->view($this->layout, $data);
  }

	public function create() { 
		$update_id = (int)$this->uri->segment(4);
    
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
		if ($this->input->post('submit') == 'submit') {
      $this->form_validation->set_rules('status','Status', 'required');
      $this->form_validation->set_rules('review','Review', 'required');
			if($this->form_validation->run()) { 
				$insert_data = [
					'review' => $this->input->post('review'),
					'status' => $this->input->post('status'), 
					'updated_at' => Date('Y-m-d H:i:s'),
				];

				if ($update_id > 0) {
					$query = $this->common_model->dbupdate('gha_reviews',$insert_data,['id' => $update_id]);
					if ($query) {
						$this->session->set_flashdata('flash_message', 'Review has been successfully updated.');
						$this->session->set_flashdata('flash_type', 'success');
						redirect(current_url());	
					}
				} else {
					$query = $this->common_model->dbinsert('gha_reviews', $insert_data);
					if ($query) {
						$this->session->set_flashdata('flash_message', 'Review has been successfully added.');
						$this->session->set_flashdata('flash_type', 'success');
						redirect(current_url());	
					}
				}
			}
		} else if ($this->input->post('submit') == 'cancel') {
			redirect(base_url().'development/studentreviews/manage');
		}

		$headline = 'Add New Review';
		$title = 'Add Review';
		if ($update_id > 0) {
			$headline = 'Update Review Details';
			$title = 'Update Details';
			$getData = $this->get_review_details($update_id);
			if (empty($getData)) {
				redirect(base_url().'development/studentreviews/manage');
			} else {
				$data = $getData[0];
			}
		} else {
      redirect(base_url().'development/studentreviews/manage');
    }

		$data['headline'] = $headline; 
		$data['form_location'] = current_url();

		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');

		$data['title'] = $title;
		$data['view_file'] = 'backend/student_reviews/create';

		$this->load->view($this->layout, $data); 
  }
  
  private function get_review_details($id) {
    $select_data = [
      "CONCAT(reg.firstname, ' ', reg.lastname) as name", 
      'reg.email', 
      'rev.id',
      'rev.review',
      'rev.status',
      'rev.created_at',
    ];
    $join = [
      ['type' => 'left', 'condition' => 'reg.id = rev.user_id', 'table' => 'gha_registration reg']
    ];
    $start = 0;
    $condition['rev.id'] = $id;

    $query = $this->common_model->dbselect('gha_reviews rev', $condition, $select_data, $start, $join);
    return $query->result_array(); 
  }
}
?>