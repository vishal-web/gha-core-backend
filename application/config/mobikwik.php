<?php
	$config['mobikwik'] = [
		'isProduction' => true,
		'development' => [
			'merchant' => 'b19e8f103bce406cbd3476431b6b7973',
			'secret' => '0678056d96914a8583fb518caf42828a',
			'form_action' => 'http://zaakpaystaging.centralindia.cloudapp.azure.com:8080/api/paymentTransact/V8',
		],
		'production' => [
			'merchant' => '59d450c599984c8e8a046a7bb5f0dcb0',
			'secret' => '545bd73d443a4bbf85a6ad797fb5e69a',
			'form_action' => 'https://api.zaakpay.com/api/paymentTransact/V7',
		],
	]
?>