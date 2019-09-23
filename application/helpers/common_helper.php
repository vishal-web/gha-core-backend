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

  if (!function_exists('generate_random_string')) {
    function generate_random_string($length = 8) {
      $characters = '123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
  }
?>