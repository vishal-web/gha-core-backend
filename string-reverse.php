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

?>