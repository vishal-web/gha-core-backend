<?php
	


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




	
	// ALTER TABLE gha_answers ADD COLUMN image TEXT NOT NULL AFTER correct
	// ALTER TABLE gha_questions ADD COLUMN course_id int NOT NULL AFTER options;
	// ALTER TABLE gha_questions ADD COLUMN image TEXT NOT NULL AFTER options;
	// ALTER TABLE gha_questions ADD COLUMN description TEXT NOT NULL AFTER options;
	// CREATE TABLE gha_exams ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, duration INT NOT NULL, duration_type VARCHAR(20) NOT NULL, course_id INT NOT NULL, negative_marking TINYINT NOT NULL, each_marks INT NOT NULL, passing_percentage INT NOT NULL, status TINYINT NOT NULL, created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT NULL)


	----NOT--UPDATED---

	// ALTER TABLE gha_registration ADD COLUMN about TEXT NOT NULL AFTER profile_picture
?>