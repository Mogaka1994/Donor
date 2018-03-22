<?php 
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH.'third_party/OAuth.php';
/**
* 
*/
class PesaPal extends CI_Controller
{
	var $consumer_key="";
	var $consumer_secret="";
	// var $statusrequestAPI = 'https://demo.pesapal.com/api/querypaymentstatus';
	var $statusrequestAPI = 'https://demo.pesapal.com/api/QueryPaymentDetails';
	//change to https://www.pesapal.com/api/querypaymentstatus' when you are ready to go live! Parameters sent to you by PesaPal IPN

	function __construct()
	{
		parent::__construct();
		$this->load->model('pesapal_model');
		$this->load->library(array('form_validation', 'ion_auth', 'session'));
		$this->load->helper(array('url', 'form'));
		$this->load->helper('date');
		$this->load->model('donation_model');
	}

	function IPNListener()
	{
		// Parameters sent to you by PesaPal IPN
		$pesapalNotification 	=	$this->input->get('pesapal_notification_type');
		$pesapalTrackingId 		= 	$this->input->get('pesapal_transaction_tracking_id');
		$pesapal_merchant_reference = $this->input->get('pesapal_merchant_reference');
		$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

		if($pesapalNotification=="CHANGE" && $pesapalTrackingId!='')
		{
  	 		$token = $params = NULL;
   			$consumer = new OAuthConsumer($this->consumer_key, $this->consumer_secret);

   			//get transaction status
   			$request_status = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $this->statusrequestAPI, $params);
   			$request_status->set_parameter("pesapal_merchant_reference", $pesapal_merchant_reference);
   			$request_status->set_parameter("pesapal_transaction_tracking_id",$pesapalTrackingId);
   			$request_status->sign_request($signature_method, $consumer, $token);

   			$ch = curl_init();
   			curl_setopt($ch, CURLOPT_URL, $request_status);
   			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   			curl_setopt($ch, CURLOPT_HEADER, 1);
   			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   			if(defined('CURL_PROXY_REQUIRED'))
   			{
   				if (CURL_PROXY_REQUIRED == 'True')
   				{
    	 	 		$proxy_tunnel_flag = (defined('CURL_PROXY_TUNNEL_FLAG') && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE') ? false : true;
      				curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
      				curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
      				curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
   				}
   			}

   			$response = curl_exec($ch);

   			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
   			$raw_header  = substr($response, 0, $header_size - 4);
   			$headerArray = explode("\r\n\r\n", $raw_header);
   			$header      = $headerArray[count($headerArray) - 1];

   			//transaction details
   			$elements = preg_split('/=/',substr($response, $header_size));

   			$arrayTrxn= explode(',', $elements[1]);

   			$transaction['status'] = $arrayTrxn[2];
   			$transaction['tracking_id'] = $arrayTrxn[0];
   			$transaction['method'] = $arrayTrxn[1];
   			$transaction['merchant_reference'] = $arrayTrxn[3];
   			curl_close ($ch);
   
   			//UPDATE YOUR DB TABLE WITH NEW STATUS FOR TRANSACTION WITH pesapal_transaction_tracking_id $pesapalTrackingId

   			if ($transaction['status']=='COMPLETED') 
   			{
   				$payment = $this->pesapal_model->getByTrackingId($transaction['tracking_id'])->row(); 
   				$this->donation_model->updateContibution($payment->project_id, $payment->amount);
   			}

   			if($this->pesapal_model->saveIPN($transaction))
   			{
      			$resp="pesapal_notification_type=$pesapalNotification&pesapal_transaction_tracking_id=$pesapalTrackingId&pesapal_merchant_reference=$pesapal_merchant_reference";
      			ob_start();
      			echo $resp;
      			ob_flush();
      			exit;
   			}
		}
	}

	function checkout($project_id)
	{
		if (is_null($project_id)) {
			redirect('donations/projects', 'refresh');
		}
		if ($this->ion_auth->logged_in()) 
		{
			$data['reference'] = 'PID'.$project_id.'UID'.$this->ion_auth->user()->row()->id.'T'.getCurrentTime('YmdHis');
			$data['project'] = $this->donation_model->getProjectByID($project_id)->row();
			$this->session->set_flashdata('project_id', $project_id);
			if ($this->form_validation->run('pesapal_online_checkout') == false) 
			{
				$this->load->view('includes/header');
				$this->load->view('pesapal/checkout', $data);
				$this->load->view('includes/footer');
			} 
			else 
			{
				//pesapal params
				$token = $params = NULL;
				$signature_method = new OAuthSignatureMethod_HMAC_SHA1();
				$iframelink = 'https://demo.pesapal.com/api/PostPesapalDirectOrderV4';//change to https://www.pesapal.com/API/PostPesapalDirectOrderV4 when you are ready to go live! get form details
				
				$amount = $this->input->post('amount');
				$this->session->set_flashdata('amount_paid', $amount);
				$this->session->set_flashdata('project_id', $project_id);
				$amount = number_format($amount, 2);//format amount to 2 decimal places

				$desc = $this->input->post('description');
				$type = $this->input->post('type'); //default value = MERCHANT
				$reference = $this->input->post('reference');//unique order id of the transaction, generated by merchant
				$first_name = $this->input->post('first_name');
				$last_name = $this->input->post('last_name');
				$email = $this->input->post('email');
				$phonenumber = $this->input->post('phone');//ONE of email or phonenumber is required

				$callback_url = site_url('pesapal/callback/'); //redirect url, the page that will handle the response from pesapal.

				$post_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Amount=\"".$amount."\" Description=\"".$desc."\" Type=\"".$type."\" Reference=\"".$reference."\" FirstName=\"".$first_name."\" LastName=\"".$last_name."\" Email=\"".$email."\" PhoneNumber=\"".$phonenumber."\" xmlns=\"http://www.pesapal.com\" />";
				$post_xml = htmlentities($post_xml);

				$consumer = new OAuthConsumer($this->consumer_key, $this->consumer_secret);

				//post transaction to pesapal
				$iframe_src = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $iframelink, $params);
				$iframe_src->set_parameter("oauth_callback", $callback_url);
				$iframe_src->set_parameter("pesapal_request_data", $post_xml);
				$iframe_src->sign_request($signature_method, $consumer, $token);

				//display pesapal - iframe and pass iframe_src
				$this->load->view('includes/header');
				$this->load->view('pesapal/iframe', array('iframe_src'=>$iframe_src));
				$this->load->view('includes/footer');
			}
		}
		else 
		{
			redirect('auth/login', 'refresh');
		}
	}

	function callback()
	{
		$data['transaction']['tracking_id'] = $this->input->get('pesapal_transaction_tracking_id');
		$data['transaction']['merchant_reference'] = $this->input->get('pesapal_merchant_reference');
		$data['transaction']['amount'] = $this->session->flashdata('amount_paid');
		$data['transaction']['user_id'] = $this->ion_auth->user()->row()->id;
		$data['transaction']['project_id'] = $this->session->flashdata('project_id');

		$this->pesapal_model->saveIPN($data['transaction']);
		$this->load->view('pesapal/processingPayment', $data);

		redirect('donations', 'refresh');
	}
}
?>
