<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Public_Controller {

  public function __construct() {
    parent::__construct();
    $this->generate_navbar();
  }

  public function index() {
    $data['query'] = $this->cart_items();
		$data['view_file'] = 'frontend/cart/index';
		$this->load->view($this->layout, $data);
  }

  public function checkout() {
    if (empty($this->cart_items())) {
      redirect(base_url('cart'));
    }
    $this->load->library('form_validation');
    $data['headline'] = 'Checkout';
    $data['query'] = $this->cart_items();
    $data['country'] = $this->input->post('country');
		$data['state'] = $this->input->post('state');
		$data['flash_message'] = $this->session->flashdata('flash_message');
		$data['flash_type'] = $this->session->flashdata('flash_type');
		$data['country_dropdown'] = $this->get_country_dropdown();
		$data['state_dropdown'] = $this->get_state_dropdown((int)$data['country']);
    $data['city_dropdown'] = $this->get_city_dropdown((int)$data['state']); 
    $data['saved_address'] = $this->user_saved_billing_address();
    $data['logged_in_user_data'] = $this->get_logged_in_user_details();
		$data['view_file'] = 'frontend/cart/checkout';
		$this->load->view($this->layout, $data);
  }

  private function user_saved_billing_address() {
    $user_id = 0;
    if (!empty($this->logged_in_user_data)) {
      $user_id = $this->logged_in_user_data['user_id'];
    }
    $condition['user_id'] = $user_id;
    return $this->common_model->dbselect('gha_billing_address',$condition)->result_array();
  }

  public function payment() {
    $order_reference_id = $this->input->cookie('uoid');
   
    $order_details = $this->get_order_details($order_reference_id);
    if ($order_reference_id == '' || empty($order_details)) {
      redirect(base_url());
    }


    $details = $order_details[0];
    $ip_address = $this->input->ip_address() == '::1' ? '127.0.0.1' : $this->input->ip_address();
    $description = 'Course Purchase';

    $buyerDetails = [ 
      'merchantIdentifier' => $this->mobikwik->merchant,
      'orderId' => $details['order_reference_id'],
      'returnUrl' => base_url('payment/response'), 
      'buyerEmail' => $details['billing_email'],
      'buyerFirstName' => $details['billing_name'],
      'buyerLastName' => '',
      'buyerAddress' => $details['billing_street_address'],
      'buyerCity' => $details['city_name'],
      'buyerState' => $details['state_name'],
      'buyerCountry' => $details['country_name'],
      'buyerPincode' => $details['billing_pincode'],
      'buyerPhoneNumber' => $details['billing_phone'],
      'txnType' => 1,
      'zpPayOption' => 1,
      'mode' => 1,
      'currency' => 'INR',
      'amount' => (100 * $details['total']),
      'merchantIpAddress' => $ip_address,
      'purpose' => 1,
      'productDescription' => $description,
      'txnDate' => Date('Y-m-d'), 
    ];

    $checksum = $this->mobikwik->getChecksum($buyerDetails);
    $this->load->helper('form');
    $buyerDetails['checksum'] = $checksum;
    $data['form_fields'] = $buyerDetails;
    $data['form_action'] = $this->mobikwik->form_action;
    $data['view_file'] = 'frontend/home/payment';
    delete_cookie('uoid');
    $this->load->view($this->layout, $data);
  }


  private function cart_items() {
    $uuid = $this->input->cookie('uuid');
		$user_id = 0;
		if (!empty($this->session->userdata('logged_in_user_data'))) {
      $user_id = $this->session->userdata('logged_in_user_data')['user_id'];
      $condition['user_id'] = $user_id;
    } else {
      $condition['uuid'] = $uuid;
    }

    $join = [
      ['type' => 'LEFT', 'condition' => 'cart.course_id = courses.id', 'table' => 'gha_courses courses']
    ];

    $selectData = ['courses.title', 'courses.id as course_id', 'courses.url_title', 'courses.price', 'courses.duration', 'courses.featured_image', 'cart.id as cart_id'];
    $query = $this->common_model->dbselect('gha_cart cart',$condition, $selectData, null, $join)->result_array();
    return $query;
  }

  public function submit() {
    if (!$this->input->is_ajax_request()) {
      die('Hey, no direct script is allowed');
    }
    $cart_items = count($this->cart_items());
    $this->load->library('form_validation');
    $response['status'] = 0;
    if ($cart_items === 0) {
      $response['message'] = 'Cart is empty';
      $response['redirect_url'] = base_url('cart');
    }

    if (empty($this->logged_in_user_data)) {
      $this->form_validation->set_rules('name','Name','trim|required');
      $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[gha_registration.email]', ['is_unique' => 'Email already exists.']);
      $this->form_validation->set_rules('password','Password','trim|required');
    }
 
    $this->form_validation->set_rules('billing_name', 'Name', 'trim|required'); 
    $this->form_validation->set_rules('billing_pincode', 'Pincode/Zip', 'trim|required');
    $this->form_validation->set_rules('billing_email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('billing_phone', 'Phone', 'trim|required');
    $this->form_validation->set_rules('billing_country', 'Country', 'trim|required');
    $this->form_validation->set_rules('billing_state', 'State', 'trim|required');
    $this->form_validation->set_rules('billing_city', 'City', 'trim|required');

    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

    if ($this->form_validation->run() && $cart_items > 0) {
      $response['status'] = 1;
      if (!empty($this->session->userdata('logged_in_user_data'))) {
        $user_id = $this->session->userdata('logged_in_user_data')['user_id'];
      }

      if (empty($this->logged_in_user_data)) {
        $user_id = $this->create_new_account();
      }

      // create a new order 
      $order = $this->create_order($user_id);

      if (!empty($order) || $order !== 0) {
        // move cart product to ordered product
        $this->move_cart_items_to_order_product($order['order_id']);
        
        // NOTE : uoid is order_reference_id set cookie of oid
        $cookie_name = 'uoid';
        $cookie_value = $order['order_reference_id'];
        $expire = time() + (86400 * 30);
        $domain = '';
        $path = '/';
        set_cookie($cookie_name,$cookie_value,$expire,$domain,$path);

        // send user to payment gateway 
        $response['redirect_url'] = base_url('checkout/payment');
      } else {
        $response['status'] = 0;
        $response['message'] = 'Something went wrong';
      }
    } else if ($cart_items > 0) {

      foreach ($_POST as $key => $value) {
        $response['form_error'][$key] = form_error($key);
      } 

      $response['status'] = 0;
      // $response['form_error'] = $this->form_validation->error_array();
      $response['validation_errors'] = validation_errors();
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($response));
  }

  private function move_cart_items_to_order_product($order_id) {
    if ($order_id > 0) {
      $cart_items = $this->cart_items();
      $total = 0;
      if (!empty($cart_items)) {
        foreach ($cart_items as $item) {
          $total += $item['price'];
          $data = [
            'order_id' => $order_id,     
            'course_id' => $item['course_id'],      
            'course_title' => $item['title'],   
            'course_price' => $item['price'],   
            'course_duration' => $item['duration'],
            'created_at' => Date('Y-m-d H:i:s'),     
            'updated_at' => Date('Y-m-d H:i:s'),   
          ];

          if ($this->common_model->dbinsert('gha_order_product',$data)) {
            $this->remove_cart_item($item['cart_id']);
          }
        }

        // update total cart amount
        $this->common_model->dbupdate('gha_order',['total'=>$total],['id'=>$order_id]);
      }
    }
  }

  private function customer_billing_address($user_id) {
    $data = [
      'user_id' => $user_id, 
      'billing_name' => $this->input->post('billing_name'),
      'billing_email' => $this->input->post('billing_email'),
      'billing_phone' => $this->input->post('billing_phone'),
      'billing_street_address' => $this->input->post('billing_street_address'),
      'billing_pincode' => $this->input->post('billing_pincode'),
      'billing_city_id' => $this->input->post('billing_city'),
      'billing_state_id' => $this->input->post('billing_state'),
      'billing_country_id' => $this->input->post('billing_country'),
      'default_billing_address' => $this->input->post('default_billing_address'),
      'created_at' => Date('Y-m-d H:i:s'),
    ];

    if ($this->common_model->dbinsert('gha_billing_address',$data)) {
      return $this->db->insert_id();
    }

    return 0;
  }
  
  private function create_order($user_id) {
    $order_reference_id = $this->get_order_reference_id();
    $billing_address_id = $this->customer_billing_address($user_id);
    
    $data = [
      'user_id' => $user_id,
      'order_reference_id' => $order_reference_id,
      'billing_address_id' => $billing_address_id,
      'created_at' => Date('Y-m-d H:i:s'),
      'updated_at' => Date('Y-m-d H:i:s'),
    ];

    if ($this->common_model->dbinsert('gha_order',$data)) {
      return ['order_id' => $this->db->insert_id(),'order_reference_id' => $order_reference_id];
    }

    return 0;
  }
  
  private function create_new_account() {
    $data = [
      'firstname' => $this->input->post('name'),
      'email' => $this->input->post('email'),
      'password' => $this->input->post('password'),
      'created_at' => Date('Y-m-d H:i:s'),
    ];

    if($this->common_model->dbinsert('gha_registration',$data)) {
      return $this->db->insert_id();
    }

    return 0;
  }

  private function remove_cart_item($cart_id) {
    $this->common_model->dbdelete('gha_cart',['id' => $cart_id]);
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

  public function get_country_dropdown() {
		$query = $this->common_model->dbselect('gha_countries')->result_array();
		$options[''] = 'Select country';
		foreach ($query as $row) {
			$options[$row['id']] = $row['name'];
		}
		return $options;
	}

	public function get_state_dropdown($country_id) {
		$options[''] = 'Select state';
		if ($country_id > 0) {
			$query = $this->common_model->dbselect('gha_states', ['country_id' => $country_id])->result_array();
			foreach ($query as $row) {
				$options[$row['id']] = $row['name'];
			}
		}
		return $options;
	}

	public function get_city_dropdown($state_id) {
		$options[''] = 'Select city';
		if ($state_id > 0) {
			$query = $this->common_model->dbselect('gha_cities', ['state_id' => $state_id])->result_array();
			foreach ($query as $row) {
				$options[$row['id']] = $row['name'];
			}
		}
		return $options;
  }
  
  private function  get_order_details($order_reference_id) {
    $join = [
      ['type' => 'left', 'table' => 'gha_billing_address ba', 'condition' => 'ba.id = o.billing_address_id'],
      ['type' => 'left', 'table' => 'gha_countries c', 'condition' => 'ba.billing_country_id = c.id'],
      ['type' => 'left', 'table' => 'gha_states s', 'condition' => 'ba.billing_state_id = s.id'],
      ['type' => 'left', 'table' => 'gha_cities ct', 'condition' => 'ba.billing_city_id = ct.id'],
    ];

    $condition = ['o.order_reference_id' => $order_reference_id];
    $select_data = ['o.*', 'ba.*', 'c.name as country_name', 's.name as state_name', 'ct.name as city_name'];

    $query = $this->common_model->dbselect('gha_order o',$condition, $select_data, null, $join);
    return $query->result_array(); 
  }
}

?>