<?php
class Backend_Controller extends CI_Controller {
	public $head_title = 'Global Health Alliance';
	public $layout = 'backend/backend-layout'; 
	public $logged_in_user_data = '';


	function __construct() {
    parent::__construct();
    $this->logged_in_user_data = $this->session->userdata('logged_in_admin_data');
    if (empty($this->logged_in_user_data)) {
    	redirect(base_url());
    }
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
}

class Public_Controller extends CI_Controller {
	public $head_title = 'Global Health Alliance';
	public $layout = 'frontend/frontend-layout';
	public $homepage = FALSE;
	public $navbar = '';
	public $logged_in_user_data = '';

	public function __construct() {
		parent::__construct();
		$this->logged_in_user_data = $this->session->userdata('logged_in_user_data');
	}

	public function generate_navbar() {
		$query = $this->common_model->dbselect('gha_courses', ['status'=>1], null, null, null,['field' => 'title', 'type'=>'asc'])->result_array();

		$html = '';
		if (!empty($query)) {
			
			$count = count($query);
			$divider = ($count / 4);
			$size = 5;

			if ($divider > 5) {
				$size = 6;
			} else if ($divider > 6) {
				$size = 7;
			} else if ($divider > 7) {
				$size = 8;
			} else if ($divider > 8) {
				$size = 9;
			} else if ($divider > 9) {
				$size = 10;
			} else if ($divider > 10) {
				$size = 11;
			} else if ($divider > 11) {
				$size = 12;
			}

			$chunk = array_chunk($query, $size);

			for ($i=0; $i < count($chunk) ; $i++) { 
				$html .= '<div class="col-menu col-md-3"><h6 class="title">Courses</h6><div class="content"><ul class="menu-col">';
				if (!empty($chunk[$i])) {
					foreach ($chunk[$i] as $row) {
						$html .= '<li><a href="'.base_url().'course/'.$row['url_title'].'">'.$row['title'].'</a></li>';
					}
				}
				$html .= '</ul></div></div>';
			}
		}

		

		return $this->navbar = $html;
	}
}

?>