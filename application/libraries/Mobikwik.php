<?php
	
	Class Mobikwik {
		private $production = FALSE;
		private $CI;
		public $form_action;
		public $secret;
		public $merchant;

		public function __construct() {
			$this->CI =& get_instance(); 
			$this->CI->config->load('mobikwik');

			$mobikwik = $this->CI->config->item('mobikwik');

			if ($mobikwik['isProduction']) {
				$mobikwik = $mobikwik['production'];
			} else {
				$mobikwik = $mobikwik['development'];
			}

			$this->form_action = $mobikwik['form_action'];
			$this->secret = $mobikwik['secret'];
			$this->merchant = $mobikwik['merchant']; 
		}
 
		public function production() {
			$mobikwik = $this->CI->config->item('production','mobikwik');

			$this->form_action = $mobikwik['form_action'];
			$this->secret = $mobikwik['secret'];
			$this->merchant = $mobikwik['merchant']; 
		}

		public function getChecksum($buyerData) {
			return $this->calculateChecksum($this->getAllParams($buyerData));
		}

		private function calculateChecksum($data) {
			return hash_hmac('sha256', $data, $this->secret); 
		}

		public function verifyChecksum() {
			$checksum = (isset($_POST['checksum']) && $_POST['checksum'] !== '') ? $_POST['checksum'] : ''; 
			return ($checksum == $this->calculateChecksum($this->getAllResponseParams())) ? 1 : 0;
		}

		private function getAllParams($data) {
			$all = '';
			
			$checksumsequence = [
				"amount","bankid","buyerAddress",
				"buyerCity","buyerCountry","buyerEmail","buyerFirstName","buyerLastName","buyerPhoneNumber","buyerPincode",
				"buyerState","currency","debitorcredit","merchantIdentifier","merchantIpAddress","mode","orderId",
				"product1Description","product2Description","product3Description","product4Description",
				"productDescription","productInfo","purpose","returnUrl","shipToAddress","shipToCity","shipToCountry",
				"shipToFirstname","shipToLastname","shipToPhoneNumber","shipToPincode","shipToState","showMobile","txnDate",
				"txnType","zpPayOption"
			];
			
			foreach($checksumsequence as $seqvalue)	{
				if(array_key_exists($seqvalue, $data))	{
					if(!$data[$seqvalue] == "")
					{
						if($seqvalue != 'checksum') 
						{
							$all .= $seqvalue;
							$all .= "=";
							$all .= $data[$seqvalue];
							$all .= "&";
						}
					}
				}
			}

			return $all;
		}

		private function getAllResponseParams() {
			$all = '';
			$checksumsequence= array(
				"amount","bank","bankid","cardId",
				"cardScheme","cardToken","cardhashid","doRedirect","orderId",
				"paymentMethod","paymentMode","responseCode","responseDescription",
				"productDescription","product1Description","product2Description",
				"product3Description","product4Description","pgTransId","pgTransTime"
			);
			
			foreach($checksumsequence as $seqvalue)	{
				if(array_key_exists($seqvalue, $_POST))	{
					$all .= $seqvalue;
					$all .="=";
					$all .= $_POST[$seqvalue];
					$all .= "&";
				}
			}
			
			return $all;
		}

	}
?>