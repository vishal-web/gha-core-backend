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

    if (!function_exists('currency_symbol')) {
      function currency_symbol($currency) {
        switch ($currency) {
          case 'INR':
            return '₹';
        }
      }
    }

    if (!function_exists('number_in_inr')) {
      function number_in_inr($number) {
        if(setlocale(LC_MONETARY, 'en_IN'))
          return '₹'.money_format('%!i', $number);
        else {
          $explrestunits = "" ;
          $number = explode('.', $number);
          $num = $number[0];
          if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){
              // creates each of the 2's group and adds a comma to the end
              if($i==0)
              {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
              }else{
                $explrestunits .= $expunit[$i].",";
              }
            }
            $thecash = $explrestunits.$lastthree;
          } else {
            $thecash = $num;
          }
          if(!empty($number[1])) {
            if(strlen($number[1]) == 1) {
              return '₹ ' .$thecash . '.' . $number[1] . '0';
            } else if(strlen($number[1]) == 2){
              return '₹ ' .$thecash . '.' . $number[1];
            } else {
              return 'cannot handle decimal values more than two digits...';
            }
          } else {
            return '₹ ' .$thecash.'.00';
          }
        }
      }
    }
  }
?>