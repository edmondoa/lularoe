<?php namespace LLR\Payments;
/*
CLASS to interface with the USAEpay webservice
ControlPad
*/
use SoapClient;
use Config;

class CMSPayment extends SoapClient { 
	
	//Declare all the variables that we will need
	public $success;
	public $transaction_id;
	public $subscription_id;
	public $auth_code;
	public $errors_public = array();
	public $test_mode;

	private $ueSecurityToken;
	private $sourcekey;
	private $pin;
	private $wsdl;
	private $response;
	private $verb;
	private $request_params;
	private $errors_internal = array();
	/*
	private $request_params = array(
		"Command" => "",
		"AuthCode" => "",
		"RefNum" => "",
		"AccountHolder" => "",
		"Details " => array(),
		"CreditCardData" => array(),
		"CheckData" => "",
		"ClientIP " => '',
		"CustomerID " => "",
		"BillingAddress" => array(),
		"ShippingAddress " => array(),
		"CustReceipt" => "",
		"Software" => "",
		"RecurringBilling " => array(),
		"LineItems" => array(),
		"CustomFields " => array(),
	);
	*/
	

// generate random seed value
	
	public function __construct() {
		$seed = microtime(true) . rand();
		$this->sourcekey = Config::get('usaepay.sourcekey');
		$this->pin = Config::get('usaepay.pin');
		$this->test_mode = Config::get('usaepay.test_mode');
		$this->wsdl = ($this->test_mode)?"https://sandbox.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl":"https://www.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl";
	
		// make hash value using sha1 function
		$hash=sha1($this->sourcekey . $seed . $this->pin);

		// assembly ueSecurityToken as an array
		$this->ueSecurityToken=array(
			'SourceKey'=>$this->sourcekey,
			'PinHash'=>array(
				'Type'=>'sha1',
				'Seed'=>$seed,
				'HashValue'=>$hash
			 ),
		 'ClientIP'=>$_SERVER['REMOTE_ADDR'],
		);
		$this->SoapClient($this->wsdl);
		$this->request_params  = array();

	}
	private function get_ip_address(){
		if(getenv('HTTP_CLIENT_IP'))
		{
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif(getenv('HTTP_X_FORWARDED_FOR'))
		{
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		else
		{
			$ip = getenv('REMOTE_ADDR');
		}
		return $ip;

	}	
	public function create_request($params){
		//echo"<pre>"; print_r($params); echo"</pre>";
		//return;
		/*
		Sample Request object
		$params = array(
			"command" => "", //(sale, credit, void, creditvoid, authonly, capture, cc:adjust, postauth, check, checkcredit)
			"authorization_code" => "", //Original Authorization Code. 
			"reference_number" => "", //Original Transaction Reference Number.
			"account_holder" => "", //Name of the account holder.
			"details" => array(), //payment details object or add later
			"credit_card_data" => array(), //credit card payment object or add later
			"check_data" => array(), //e-check payment object or add later
			"customer_id" => "",
			"billing_address" => "", //address object or add later
			"shipping_address" => "", //address object or add later
			"send_customer_receipt" => "", // boolean
			"software" => "", 
			"recurring_billing" => array(), //recurring billing object or add later
			"line_items" => array(), //line items object  or add later
			"custom_fields" => array(), //custom fields object  or add later
		);
		*/
		$this->request_params = array(
			"Command" => (isset($params['command']))?$params['command']:"sale",
			//"AuthCode" => (isset($params['authorization_code']))?$params['authorization_code']:"",
			//"RefNum" => (isset($params['reference_number']))?$params['reference_number']:"",
			"AccountHolder" => (isset($params['account_holder']))?$params['account_holder']:"",
			"ClientIP" => $this->get_ip_address(),
			"CustomerID" => (isset($params['customer_id']))?$params['customer_id']:"",
			"CustReceipt" => (isset($params['send_customer_receipt']))?$params['send_customer_receipt']:false,
			"Software" => "BOX.EVENTS",
		);
		//add a billing address if there is one
		if((isset($params['billing_address']))&&(is_array($params['billing_address'])))
		{
			$this->request_params['BillingAddress'] = $this->add_address($params['billing_address']);
		}
		//add a shipping address if there is one
		if((isset($params['shipping_address']))&&(is_array($params['shipping_address'])))
		{
			$this->request_params['ShippingAddress'] = $this->add_address($params['shipping_address']);
		}
		//create the details array
		if((isset($params['details']))&&(is_array($params['details'])))
		{
			$this->request_params['Details'] = $this->add_transaction($params['details']);
		}
		//add payment details for an Echeck transaction
		if(($this->request_params['Command'] == 'ACH')&&(isset($params['check_data']))&&(is_array($params['check_data'])))
		{
			$this->request_params['CheckData'] = $this->add_payment_method($params['check_data']);
		}
		elseif(($this->request_params['Command'] == 'AuthOnly')&&(isset($params['check_data']))&&(is_array($params['check_data'])))
		{
			$this->request_params['CheckData'] = $this->add_payment_method($params['check_data']);
		}

		if(($this->request_params['Command'] == 'sale')&&(isset($params['credit_card_data']))&&(is_array($params['credit_card_data'])))
		{
			$this->request_params['CreditCardData'] = $this->add_payment_method($params['credit_card_data']);
		}
		elseif(($this->request_params['Command'] == 'AuthOnly')&&(isset($params['credit_card_data']))&&(is_array($params['credit_card_data'])))
		{
			$this->request_params['CreditCardData'] = $this->add_payment_method($params['credit_card_data']);
		}

		// Add payment details for a credit card transaction
		if((isset($params['recurring_billing']))&&(is_array($params['recurring_billing'])))
		{
			$this->request_params['RecurringBilling'] = $this->add_recurring($params['recurring_billing']);
		}
		// for future use
		/*
		if((isset($params['line_items']))&&(is_array($params['line_items'])))
		{
			$this->request_params['LineItems'] = $this->add_line_items($params['line_items']);
		}
		if((isset($params['custom_fields']))&&(is_array($params['custom_fields'])))
		{
			$this->request_params['CustomFields'] = $this->add_custom_field($params['custom_fields']);
		}
		*/
		//$this->verb = '';
	}

	public function add_address($params){
		/*
		Sample Address object
		$params = array(
			"first_name" => "",
			"last_name" => "",
			"email" => "",
			"company" => "",
			"street_1" => "",
			"street_2" => "",
			"city" => "",
			"state" => "",
			"zip" => "",
			"country" => "",
			"phone" => "",
		);
		*/
		$ShippingAddress = array(
			'City' => (isset($params['city']))?$params['city']:'',
			'Company' => (isset($params['company']))?$params['company']:'',
			'Country' => (isset($params['country']))?$params['country']:'US',
			'Email' => (isset($params['email']))?$params['email']:'',
			'FirstName' => (isset($params['first_name']))?$params['first_name']:'',
			'LastName' => (isset($params['last_name']))?$params['last_name']:'',
			'Phone' => (isset($params['phone']))?$params['phone']:'',
			'State' => (isset($params['state']))?$params['state']:'',
			'Street' => (isset($params['street_1']))?$params['street_1']:'',
			'Street2' => (isset($params['street_2']))?$params['street_2']:'',
			'Zip' => (isset($params['zip']))?$params['zip']:''
		);
		return $ShippingAddress;
	}
	
	private function add_payment_method($params){
		/*
		Sample object
		$params = array(
			"type" => "", //('ACH','CreditCard')
			"account_num" => "", 
			"account_type" => "",
			"routing_num" => "",
			"check_number" => "",
			"driver_license" => "",
			"driver_license_state" => "",
			"card_number" => "",
			"card_code" => "",
			"card_exp" => "",
			"card_street" => "",
			"card_zip" => "",
		);
		*/
		if($params['type'] == 'ACH')
		{
			$PaymentMethod = array(
				'MethodType' => 'ACH',
				'Account' => (isset($params['account_num']))?$params['account_num']:'',
				'AccountType' => (isset($params['account_type']))?$params['account_type']:'',
				'Routing' => (isset($params['routing_num']))?$params['routing_num']:'',
				'CheckNumber' => (isset($params['check_number']))?$params['check_number']:'',
				'DriversLicense' => (isset($params['driver_license']))?$params['driver_license']:'',
				'DriversLicenseState' => (isset($params['driver_license_state']))?$params['driver_license_state']:'',
				'RecordType' => 'ARC',
			);
		}
		elseif($params['type'] == 'CreditCard')
		{
			$PaymentMethod = array(
				'MethodType' => 'CreditCard',
				'CardNumber' => (isset($params['card_number']))?$params['card_number']:'',
				'CardExpiration' => (isset($params['card_exp']))?$params['card_exp']:'',
				'AvsStreet' => (isset($params['card_street']))?$params['card_street']:'',
				'AvsZip' => (isset($params['card_zip']))?$params['card_zip']:'',
				'CardCode' => (isset($params['card_code']))?$params['card_code']:'',
			);
		}
		return $PaymentMethod;
	}
	
	public function add_transaction($params){
		/*
		Sample transaction object
		$params = array(
			"amount" => "",  //  ***Required*** integer
			"comments" => "",  // text
			"description" => "",  // text 
			"tax" => "",  // decimal 
			"tip" => "",  // decimal
			"non_tax" => "",  // decimal
			"shipping" => "",  // decimal
			"discount" => "",  // decimal
			"sub_total" => "",  // decimal 
			"order_id" => "",  // integer
			"terminal" => "",  // text
			"clerk" => "",  // text			
		);
		*/
		$TransactionDetail = array(
			"Amount" =>  (isset($params['amount']))?$params['amount']:$this->log_error('Amount is required'),
			"Comments" =>  (isset($params['comments']))?$params['comments']:'',
			"Description" =>  (isset($params['description']))?$params['description']:'',
			"Tax" =>  (isset($params['tax']))?$params['tax']:0.00,
			"Tip" =>  (isset($params['tip']))?$params['tip']:0.00,
			"NonTax" =>  (isset($params['non_tax']))?$params['non_tax']:false,
			"Shipping" =>  (isset($params['shipping']))?$params['shipping']:0.00,
			"Discount" =>  (isset($params['discount']))?$params['discount']:0.00,
			"Subtotal" =>  (isset($params['sub_total']))?$params['sub_total']:0.00,
			"OrderID" =>  (isset($params['order_id']))?$params['order_id']:'',
			"Terminal" =>  (isset($params['terminal']))?$params['terminal']:'',
			"Clerk" =>  (isset($params['clerk']))?$params['clerk']:'',
		);
		return $TransactionDetail;
	}
	
	public function add_recurring($params){
		/*
		Sample recurring object
		$params = array(
			'schedule' => '', // ***Required*** disabled, daily, weekly, bi-weekly (every two weeks), monthly, bi-monthly (every two months), quarterly, bi-annually (every six months), annually
			'next_bill_date' => '', // ***Required*** date (YYYY-MM-DD)
			'subscription_expiration' => '', //date (YYYY-MM-DD)
			'number_billing_periods' => '', //integer
			'amount' => '', *** // ***Required*** decimal
			'enabled' => '', //boolean
		);
		*/
		$RecurringBilling = array(
			"Schedule" => (isset($params['schedule']))?$params['schedule']:'monthly',
			"Next" => (isset($params['next_bill_date']))?$params['next_bill_date']:date('Y-m-d'),
			"Amount" => (isset($params['amount']))?$params['amount']:'',
			"Enabled" => (isset($params['enabled']))?$params['enabled']:true,
		);
		if(isset($params['subscription_expiration']))
		{
			$RecurringBilling['Expire'] = $params['subscription_expiration'];
		}
		if(isset($params['number_billing_periods']))
		{
			$RecurringBilling['NumLeft'] = $params['number_billing_periods'];
		}
		else
		{
			$RecurringBilling['NumLeft'] = 9999;
		}
		return $RecurringBilling;
	}
	
	public function add_line_item(){
	}
	
	public function add_custom_fileds(){
	}
	
	public function send_request(){
		if(count($this->errors_public) > 0) return false;
		try{
			$this->response = $this->runTransaction($this->ueSecurityToken,$this->request_params);
			//echo"<pre>"; print_r($this->response); echo"</pre>";
			if($this->process_response())
			{
				return true;
			}
			else
			{	
				return false;
			}
			//exit;
		}catch(SoapFault $e) { 
			$this->log_error($e->getMessage());
			//echo "SoapFault: " .$e->getMessage(); print_r($e); 
			//echo "\n\nRequest: " . $tran->__getLastRequest(); 
			//echo "\n\nResponse: " . $tran->__getLastResponse(); 
		} 
	
	}

	public function process_response(){
		if(count($this->errors_public) > 0) return false;
		if($this->response->ResultCode == 'A')
		{
			$this->success = true;
			$this->auth_code = $this->response->AuthCode;
			$this->transaction_id = $this->response->RefNum;
			$this->subscription_id = $this->response->CustNum;
			//$this->auth_code = $this->response->AuthCode
			//$this->auth_code = $this->response->AuthCode
			return true;
		}
		else
		{
			$this->success = false;
			//echo"<p>".$this->response->Error."</p>";
			$this->log_error($this->response->Error);
			return false;
		}
	}
	
	public function get_report($report_params){
		try { 
			$res=$this->getReport($this->ueSecurityToken, $report_params['report_name'], $report_params['options'],$report_params['format']);  
			$data=base64_decode($res);
			$filename = DOC_ROOT."temp_files/transactions_".date('Y-m-d').".csv";
			$fp = fopen($filename,'w');
			fwrite($fp,$data);
			fclose($fp);
		} 

		catch (SoapFault $e) { 
			die("Get Transaction failed :" .$e->getMessage()); 
		} 
	
	}
	
	public function log_error($error_str,$public=true){
		if((!empty($error_str))&&(!in_array($error_str,$this->errors_public))&&($public))
		{
			$this->errors_public[] = $error_str;
		}
		elseif((!empty($error_str))&&(!in_array($error_str,$this->errors_public)))
		{
			$this->errors_internal[] = $error_str;
		}
	}
	
	public function get_customer($customer_number){
		try { 
			$customer = $this->getCustomer($this->ueSecurityToken,$customer_number); 
			//echo"<pre>"; print_r($customer); echo"</pre>";
			return $customer;
		} 
		catch(SoapFault $e) { 
			$this->log_error($e->getMessage(),false);	
			return false;			
		} 	
	}
	
	public function disable_customer($customer_number){
		try { 
			$customer = $this->disableCustomer($this->ueSecurityToken,$customer_number); 
			//echo"<pre>"; print_r($customer); echo"</pre>";
			return $customer;
		} 
		catch(SoapFault $e) { 
			$this->log_error($e->getMessage(),false);	
			return false;			
		} 	
	}
	
	function expose()
	{
		echo"<pre>";print_r($this);echo"</pre>";
	}
}
?>
