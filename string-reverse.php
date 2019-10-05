<?php
	// date_default_timezone_set('Asia/Kolkata');
	// echo Date('Y-m-d H:i:s');

	
	// $gmtTimezone = new DateTimeZone('GMT');
	// $myDateTime = new DateTime(Date('Y-m-d H:i:s'), $gmtTimezone);
	// echo "<br>";
	// echo $myDateTime->format('r');
	// echo "<br>";


	// echo '<pre>';
	// print_r($_SERVER);
	// echo '</pre>';
	// $array[10][] = '1';
	// $array[7][] = '1';
	// $array[1][] = '1';
	// $array[9][] = '1';
	// $array[8][] = '1';
	// $array[11][] = '1';

	// foreach ($array as $key => $row) {

	// 	echo '<pre>';
	// 	print_r($row);
	// 	echo '</pre>';
	// }
/* 
	$config['base_url'] = ((isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == "on") ? "https" : "http");
	$config['base_url'] = (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == "ghahealth.herokuapp.com") ? 'https' : $config['base_url'];
	$config['base_url'] .= "://" . $_SERVER ['HTTP_HOST'];
	$config['base_url'] .= str_replace ( basename ( $_SERVER ['SCRIPT_NAME'] ), "", $_SERVER ['SCRIPT_NAME']);

	echo '<pre>';
	print_r($config);
	echo '</pre>';

	if (is_https()) {
		echo "Yes";
	}
 */

	mkdir($_SERVER['DOCUMENT_ROOT'].'uploads/course/thumb');

	
	// ALTER TABLE gha_answers ADD COLUMN image TEXT NOT NULL AFTER correct
	// ALTER TABLE gha_questions ADD COLUMN course_id int NOT NULL AFTER options;
	// ALTER TABLE gha_questions ADD COLUMN image TEXT NOT NULL AFTER options;
	// ALTER TABLE gha_questions ADD COLUMN description TEXT NOT NULL AFTER options;
	// CREATE TABLE gha_exams ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, duration INT NOT NULL, duration_type VARCHAR(20) NOT NULL, course_id INT NOT NULL, negative_marking TINYINT NOT NULL, each_marks INT NOT NULL, passing_percentage INT NOT NULL, status TINYINT NOT NULL, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT NULL)



	// ALTER TABLE gha_registration ADD COLUMN about TEXT NOT NULL AFTER profile_picture

	// ----NOT--UPDATED---

	// ALTER TABLE gha_order CHANGE COLUMN order_course_id order_product_id int not null;

	/*
		
		gha_payment | CREATE TABLE `gha_payment` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `order_id` int(11) NOT NULL,
		  `amount` decimal(10,2) NOT NULL,
		  `transaction_id` varchar(255) NOT NULL,
		  `mode` varchar(100) NOT NULL,
		  `response_description` text,
		  `payment_reference_id` varchar(100) NOT NULL,
		  `status` tinyint(4) NOT NULL,
		  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `updated_at` datetime DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1

	*/

	//  ALTER TABLE gha_order ADD COLUMN order_reference_id VARCHAR(100) NOT NULL AFTER order_product_id;


		/* 
			 create table gha_homepage (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, course_id int NOT NULL, description TEXT NOT NULL, type VARCHAR(100) NOT NULL, status TINYINT not null default 0, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , updated_at DATETIME default NULL)
			
		*/

		// CREATE TABLE gha_exam_history (id int NOT NULL AUTO_INCREMENT PRIMARY KEY,user_id INT NOT NULL, exam_id INT NOT NULL, status TINYINT NOT NULL, started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, finished_at DATETIME  DEFAULT NULL );
			
?>