<?php 
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH.'third_party/AfricasTalkingGateway.php';

/**
* Class to handle Donations
*/
class Mpesa extends CI_Controller
{
	var $AT_Username = "";
	var $AT_API_Key = "";

	var $productName = '';
	var $shortCode = '';
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->view('errors/html/page_coming_soon');
	}

	function sms()
	{
		$gateway = new AfricasTalkingGateway($this->AT_Username, $this->AT_API_Key);

		$to_ = '+254727447101';
		$from_ = $this->shortCode;
		$message_ = 'Hi Jerry'; 

		if ($gateway->sendMessage($to_, $message_, $from_)) {
			print_r("Succss");
		} else {
			print_r("Failed");
		}
	}

	function checkout()
	{
		$gateway = new AfricasTalkingGateway($this->AT_Username, $this->AT_API_Key);

		$productName  = $this->productName;
		// The phone number of the customer checking out
		$phoneNumber  = "+254727447101";
		// The 3-Letter ISO currency code for the checkout amount
		$currencyCode = "KES";
		// The checkout amount
		$amount       = 10.50;
		// Any metadata that you would like to send along with this request
		// This metadata will be  included when we send back the final payment notification
		$metadata     = array("agentId"   => "654",
                      			"productId" => "321"
                      		);
		try {
  			// Initiate the checkout. If successful, you will get back a transactionId
  			$transactionId = $gateway->initiateMobilePaymentCheckout($productName, $phoneNumber, $currencyCode, $amount, $metadata);
  			echo "The id here is ".$transactionId;
		}
		catch(AfricasTalkingGatewayException $e)
		{
  			echo "Received error response: ".$e->getMessage();
		}
	}

	function pay()
	{
		$gateway = new AfricasTalkingGateway($this->AT_Username, $this->AT_API_Key);

		$productName  = $this->productName;
		// The 3-Letter ISO currency code for the checkout amount
		$currencyCode = "KES";
		// Provide the details of a mobile money recipient
		$recipient1   = array("phoneNumber" => "+254727447101",
        	               "currencyCode" => "KES",
            	           "amount"       => 10.50,
                	       "metadata"     => array("name"   => "Jerry Shikang",
                    	                           "reason" => "Test Data")
              			);
		// You can provide up to 10 recipients at a time
		$recipient2   = array("phoneNumber"  => "+254712325593",
        	            "currencyCode" => "KES",
            	        "amount"       => 50.10,
                	    "metadata"     => array("name"   => "Sarah Taabu",
                    	                        "reason" => "Test Data")
              			);
		// Put the recipients into an array
		$recipients  = array($recipient1, $recipient2);
		try 
		{
  			$responses = $gateway->mobilePaymentB2CRequest($productName, $recipients);
  
  			foreach($responses as $response) {
    			// Parse the responses and print them out
    			echo "phoneNumber=".$response->phoneNumber;
    			echo ";status=".$response->status;
    
    			if ($response->status == "Queued") {
      				echo ";transactionId=".$response->transactionId;
      				echo ";provider=".$response->provider;
      				echo ";providerChannel=".$response->providerChannel;
      				echo ";value=".$response->value;
      				echo ";transactionFee=".$response->transactionFee."\n";
    			} 
    			else 
    			{
      				echo ";errorMessage=".$response->errorMessage."\n";
    			}
  			}
  
		}
		catch(AfricasTalkingGatewayException $e)
		{
  			echo "Received error response: ".$e->getMessage();
		}
	}
}
