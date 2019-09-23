<?php
	class Course extends Public_Controller { 

		public function __construct() {
			parent::__construct();
			$this->generate_navbar();
		}

		public function index() {
			$url_title = $this->uri->segment('2');
			if ($url_title == '') {
				redirect(base_url());
			}
			
			$course_details = $this->get_course_details($url_title);
			if (empty($course_details)) {
				redirect(base_url());
			}

			$this->head_title = $course_details[0]['title'].' - '.$this->head_title; 
			$data['title'] = $course_details[0]['title'];
			$data['course_details'] = $course_details[0];
			$data['view_file'] = 'frontend/home/course-detail';
			$this->load->view($this->layout, $data);
		}

		public function enroll() { 
			$this->load->helper('form');

			$url_title = $this->uri->segment('3');
			if ($url_title == '') {
				redirect(base_url());
			}
			
			$course_details = $this->get_course_details($url_title);
			if (empty($course_details)) {
				redirect(base_url());
			}

			// course price must be greater than 0
			if ($course_details[0]['price'] < 1) {
				redirect($this->referrer_url !== '' ? $this->referrer_url : base_url());
			}

			// User must have completed his profile for checkout process
			// Otherwise he must complete his profile
			$user_details = $this->get_user_details()[0];
			if ($user_details['country'] == '' || $user_details['state'] == '' || $user_details['city'] == '') {
				redirect(base_url('user/dashboard'));
			}

			// Add course current details
			$order_product_data = [
				'user_id' => $this->logged_in_user_data['user_id'],     
				'course_id' => $course_details[0]['id'],      
				'course_title' => $course_details[0]['title'],   
				'course_price' => $course_details[0]['price'],   
				'course_duration' => $course_details[0]['duration'],
				'created_at' => Date('Y-m-d H:i:s'),     
				'updated_at' => Date('Y-m-d H:i:s'),   
			];

			if(!$this->common_model->dbinsert('gha_order_product', $order_product_data)) {
				redirect(base_url());
			}

			$order_product_id = $this->db->insert_id();

			$order_reference_id = $this->get_order_reference_id();

			$order_data = [
				'order_product_id' => $order_product_id,
				'updated_at' => Date('Y-m-d H:i:s'),
				'order_reference_id' => $order_reference_id,
				'status' => 0 // Pending by default
			];

			if (!$this->common_model->dbinsert('gha_order',$order_data)) {
				redirect(base_url());
			}

			$ip_address = $this->input->ip_address() == '::1' ? '127.0.0.1' : $this->input->ip_address();

			$customer['merchant'] = $this->mobikwik->merchant;
			$customer['order_id'] = $order_reference_id;
			$customer['return_url'] = base_url('payment/response');
			$customer['email'] = $user_details['email'];
			$customer['firstname'] = $user_details['firstname'];
			$customer['lastname'] = $user_details['lastname'];
			$customer['address'] = '';
			$customer['city_name'] = $user_details['city_name'];
			$customer['state_name'] = $user_details['state_name'];
			$customer['country_name'] = $user_details['country_name'];
			$customer['phone'] = $user_details['phone'];
			$customer['pincode'] = ''; 
			$customer['amount'] = (100 * $course_details[0]['price']);
			$customer['ip_address'] = $ip_address;
			$customer['description'] = $course_details[0]['title'];

			$buyerDetails = $this->buyerDetails($customer);
			$checksum = $this->mobikwik->getChecksum($buyerDetails);
			$buyerDetails['checksum'] = $checksum;

			
			$data['form_fields'] = $buyerDetails;
			$data['form_action'] = $this->mobikwik->form_action;
			$data['view_file'] = 'frontend/home/payment';
			$this->load->view($this->layout, $data);
		}

		private function get_user_details() {
			if (empty($this->logged_in_user_data)) {
				redirect(base_url());
			}

			$join = [
				[
					'type' => 'left',
					'table' => 'gha_countries c',
					'condition' => 'r.country = c.id'
				],
				[
					'type' => 'left',
					'table' => 'gha_states s',
					'condition' => 'r.state = s.id'
				],
				[
					'type' => 'left',
					'table' => 'gha_cities ct',
					'condition' => 'r.city = ct.id'
				],
			];

			$condition = ['r.id' => $this->logged_in_user_data['user_id']];
			$select_data = ['r.*', 'c.name as country_name', 's.name as state_name', 'ct.name as city_name'];

			$query = $this->common_model->dbselect('gha_registration r',$condition, $select_data, null, $join);
			return $query->result_array();
		}

		public function get_course_details($url_title) {
			$query = $this->common_model->dbselect('gha_courses',['url_title' => $url_title])->result_array();
			return $query;
		}

		public function buyerDetails($details) {
			return array(
				'merchantIdentifier' => $details['merchant'],
				'orderId' => $details['order_id'],
				'returnUrl' => $details['return_url'], 
				'buyerEmail' => $details['email'],
				'buyerFirstName' => $details['firstname'],
				'buyerLastName' => $details['lastname'],
				'buyerAddress' => $details['address'],
				'buyerCity' => $details['city_name'],
				'buyerState' => $details['state_name'],
				'buyerCountry' => $details['country_name'],
				'buyerPincode' => $details['pincode'],
				'buyerPhoneNumber' => $details['phone'],
				'txnType' => 1,
				'zpPayOption' => 1,
				'mode' => 1,
				'currency' => 'INR',
				'amount' => $details['amount'],
				'merchantIpAddress' => $details['ip_address'],
				'purpose' => 1,
				'productDescription' => $details['description'],
				'txnDate' => Date('Y-m-d'), 
			);
		}
		
		private function get_order_reference_id() {
			$order_reference_id = generate_random_string();
			$query = $this->common_model->dbselect('gha_order', ['order_reference_id' => $order_reference_id]);
			if (empty($query->result_array())) {
				return strtoupper($order_reference_id);
			} else {
				$this->get_order_reference_id();
			}
		}
	}

	/*
	// Not mandotary fields in mobikwik
	product1Description
	product2Description
	product3Description
	product4Description
	shipToAddress
	shipToCity
	shipToState
	shipToCountry
	shipToPincode
	shipToPhoneNumber
	shipToFirstname
	shipToLastname*/
?>