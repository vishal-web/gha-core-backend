<?php
	$config['mobikwik'] = [
		'development' => [
			'merchant' => 'b19e8f103bce406cbd3476431b6b7973',
			'secret' => '0678056d96914a8583fb518caf42828a',
			'form_action' => 'http://zaakpaystaging.centralindia.cloudapp.azure.com:8080/api/paymentTransact/V8',
		],
		'production' => [
			'merchant' => 'xxxxxxxxxxxxxxxxxx',
			'secret' => 'xxxxxxxxxxxxxxxxxxxx',
			'form_action' => 'https://api.zaakpay.com/api/paymentTransact/V7',
		],
	]
?>