<?php

	echo '<pre>';
	print_r($_SERVER);
	echo '</pre>';

	$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	$url .= $_SERVER['SERVER_NAME'];

	echo $url;

?>