<?php
  if (!function_exists('send_mail')) {
    function send_mail() {
      
    }
  }


  if (!function_exists('get_material_dd')) {
  	function get_material_dd() {
  		return [
  			'' => 'Choose Type',
        'youtube' => 'Youtube video',
  			'ppt' => 'PPT',
  			'pdf' => 'PDF',
  			'img' => 'Image',
  			'doc' => 'Document'
  		];
  	}
  }
?>