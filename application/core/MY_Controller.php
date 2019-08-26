<?php
class MY_Controller extends CI_Controller {
	
	function __construct() {
    parent::__construct();
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
?>