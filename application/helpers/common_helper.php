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

  if (!function_exists('')) {
    function get_nice_date($timestamp, $format) {
      switch ($format) {
        case 'full':
        // FULL // March 10th of Feburary  2017 at 5:16:00 PM
        $date = date("l jS \of F Y \a\\t h:i:s A",$timestamp); 
        break;

        case 'shorter':
        //SHORTER // 18th of Feburary 2017
        $date = date('jS \of F Y',$timestamp);
        break;

        case 'old':
        // OLD // 03/10/01
        $date = date("j\/n\/y",$timestamp); 
        break;

        case 'mini':
        // MINI // 18th Feb 2017
        $date = date('jS M Y',$timestamp);
        break;

        case 'datepicker':
        // MINI // 18th Feb 2017
        $date = date('m\/d\/y',$timestamp);
        break;

        case 'datepicker_us':
        // MINI // 18th Feb 2017
        $date = date('m\/d\/y',$timestamp);
        break;

        case 'cool':
        // COOL // Friday 18th of Feburary 2017
        $date = date('l jS \of F Y',$timestamp);
        break;
      }
      return $date;
    }

  }
?>