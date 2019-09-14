<?php

	echo '<pre>';
	print_r($_SERVER);
	echo '</pre>';


	$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	$url .= $_SERVER['SERVER_NAME'];

	echo $url;

	



	$config['base_url'] = ((isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == "on") ? "https" : "http");
	$config['base_url'] .= "://" . $_SERVER ['HTTP_HOST'];
	$config['base_url'] .= str_replace ( basename ( $_SERVER ['SCRIPT_NAME'] ), "", $_SERVER ['SCRIPT_NAME'] );

	echo '<pre>';
	print_r($config);
	echo '</pre>';

	if (is_https()) {
		echo "Yes";
	}

?>