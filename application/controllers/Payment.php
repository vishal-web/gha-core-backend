<?php

	Class Payment extends Public_Controller {
		public function __construct() {
			parent::__construct();
		}

		public function response() {
			if($this->mobikwik->verifyChecksum()) {

				$payment_reference_id = $this->get_payment_reference_id();
				$order_id = $this->get_order_id($this->input->post('orderId'));

				$insertData = [
					'order_id' => $order_id,
					'amount' => $this->input->post('amount'),
					'transaction_id' => $this->input->post('pgTransId'),
					'mode' => $this->input->post('paymentMode'),
					'response_description' => $this->input->post('responseDescription'),
					'payment_reference_id' => $payment_reference_id,
					'status' => 1,
				];

				$this->common_model->dbinsert('gha_payment', $insertData);

				// update order
				$condition['id'] = $order_id;
				$updateData = ['status' => 1, 'updated_at' => Date('Y-m-d')];
				$this->common_model->dbupdate('gha_order', $updateData, $condition);
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
			$data['view_file'] = 'frontend/home/payment-details';
			$this->load->view($this->layout, $data);
		}

		public function failed() {
			$data['view_file'] = 'frontend/home/payment-details';
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

		private function get_order_id($order_reference_id) {
			$query = $this->common_model->dbselect('gha_order', ['order_reference_id' => $order_reference_id])->result_array();
			return !empty($query) ? $query[0]['id'] : 0;
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
?>