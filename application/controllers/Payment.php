<?php

	Class Payment extends Public_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function response() {

			if($this->mobikwik->verifyChecksum()) {
				$payment_reference_id = $this->get_payment_reference_id();
				$orderId = $this->input->post('orderId');
				$amount = $this->input->post('amount');
				$pgTransId = $this->input->post('pgTransId');
				$paymentMode = $this->input->post('paymentMode');
				$responseDescription = $this->input->post('responseDescription');
				$responseCode = $this->input->post('responseCode');
				$cardhashid = $this->input->post('cardhashid');

				$status = 1;
				if ($cardhashid === 'NA' || $responseCode !== 100  || $pgTransId !== NULL) {
					$status = 2;
				}


				// ------	------------------------------------------------------ 
				// getting order_reference_id as order id from payment response
				$order = $this->get_order($orderId);

				$insertData = [
					'order_id' => $order['id'],
					'amount' => $amount,
					'transaction_id' => $pgTransId === null ? 'Not Found' : $pgTransId,
					'mode' => $paymentMode,
					'response_description' => $responseDescription,
					'payment_reference_id' => $payment_reference_id,
					'response_code' => $responseCode,
					'status' => $status,
					'created_at' => Date('Y-m-d H:i:s'),
				];

				$this->common_model->dbinsert('gha_payment', $insertData);

				// update order
				$condition['id'] = $order['id'];
				$updateData = ['status' => $status, 'updated_at' => Date('Y-m-d')];
				$this->common_model->dbupdate('gha_order', $updateData, $condition);

				if ($status !== 1) {
					redirect(base_url('payment/failed'));
				}


				$this->confirmation_mail($this->input->post('orderId'), $order['user_id']);
				
				redirect(base_url('payment/success/'.$payment_reference_id));
			} else {
				redirect(base_url('payment/failed'));
			}
		}

		public function success() {
			$payment_reference_id = $this->uri->segment(3);

			$query = $this->common_model->dbselect('gha_payment',['payment_reference_id' => $payment_reference_id])->result_array();
			if (empty($query)) {
				redirect(base_url());
			}

			$data['query'] = $query[0];
			$data['view_file'] = 'frontend/payment/success';
			$this->load->view($this->layout, $data);
		}

		private function confirmation_mail($order_reference_id, $user_id) {
			$message = 'Your payment has been successful. <br /><br />';
			$order_details = $this->get_ordered_course($order_reference_id);
			foreach ($order_details as $key => $row) {
				$message .= 'The '. $row['course_title'] .' course purchase is valid for the period of ';
				$message .= $row['course_duration']. '  month. ';
				$message .= 'You will be able to take two attempts at the test. ';
				$message .= 'On the first failed attempt your test will be locked for 48 hours.';
				$message .= ' <br /> <br />';
				$message .= 'So, we will kindly request you to take both of your attempts within the period of '. $row['course_duration'] .' month.';
				$message .= ' <br /> <br />';
				
				if (isset($order_details[$key + 1])) {
					$message .= ' <span style="border-width: 1px; display: block;overflow: hidden;border: 1px solid;margin-bottom: 20px;"></span>';
				}
			}

			$userData = $this->common_model->dbselect('gha_registration',['id' => $user_id])->result_array();
			if (!empty($userData)) {
				$email = $userData[0]['email'];

				$data['message'] = $message;
				$data['view_file'] = 'mailer/common-mail';
				$mailer_message = $this->load->view('mailer/mailer-layout',$data, true);

				send_mail($email, 'Order : '.$order_reference_id.' Payment Success', $mailer_message);
			}
		}

		public function get_ordered_course($order_reference_id) {
			$join = [
				['type' => 'left', 'table' => 'gha_billing_address ba', 'condition' => 'ba.id = o.billing_address_id'], 
				['type' => 'left', 'table' => 'gha_order_product op', 'condition' => 'op.order_id = o.id'], 
			];
	
			$condition = ['o.order_reference_id' => $order_reference_id];
			$select_data = ['o.id', 'op.*'];
	
			$query = $this->common_model->dbselect('gha_order o',$condition, $select_data, null, $join);
			return $query->result_array(); 
		}

		public function failed() {
			$data['view_file'] = 'frontend/payment/failed';
			$this->load->view($this->layout, $data);
		}

		private function get_payment_reference_id() {
			$payment_reference_id = generate_random_string();
			$query = $this->common_model->dbselect('gha_payment', ['payment_reference_id' => $payment_reference_id]);
			if (empty($query->result_array())) {
				return $payment_reference_id;
			} else {
				$this->get_payment_reference_id();
			}
		}

		private function get_order($order_reference_id) {
			$query = $this->common_model->dbselect('gha_order', ['order_reference_id' => $order_reference_id])->result_array();
			return !empty($query) ? $query[0] : 0;
		}
	}
	


	/*
	
	Sample

	orderId: 592416159
	responseCode: 100
	responseDescription: The transaction was completed successfully. 
	checksum: baa681c7530489a0b6e6adf0acf5c2c52135a00afe4aef2b0bf8776de719e9a2
	amount: 120000
	doRedirect: false
	paymentMode: Credit Card
	cardId: bce8e4e1e66520cb0bc2bf3a0e760412d53273a844bf0931f2b3136a2ee0ada3~1
	cardScheme: Visa
	cardToken: 4012 XXXX XXXX 1881
	bank: NA
	bankid: NA
	paymentMethod: 401288
	cardhashid: CH101
	productDescription: Paramedics
	product1Description: NA
	product2Description: NA
	product3Description: NA
	product4Description: NA
	pgTransId: ZP59308ddd271a7
	pgTransTime: 09/21/2019 10:18:38

	*/ 	

	/* 
    [orderId] => S2L91Z9T
    [responseCode] => 102
    [responseDescription] => Customer cancelled transaction. 
    [checksum] => fd75060bc4c9518060f8f588a0a347fa2449ceedf6e2f0907cbc0a9ccba50159
    [amount] => 100000
    [doRedirect] => false
    [paymentMode] => unknown
    [paymentMethod] => Not Found
    [cardhashid] => NA	
	*/
?>