<?php 
class ControllerPaymentRavepay extends Controller 
{
	public function index()
	{
		$this->language->load('payment/ravepay');
		$data['text_testmode'] = $this->language->get('text_testmode'); 
        $data['button_confirm'] = $this->language->get('button_confirm');

        $data['live'] = $this->config->get('ravepay_live');


        if ($this->config->get('ravepay_live')) {
            $data['public_key'] = $this->config->get('ravepay_live_public_key');

            $data['secret_key'] = $this->config->get('ravepay_live_secret_key');
        } else {
            $data['public_key'] = $this->config->get('ravepay_test_public_key');
            
            $data['secret_key'] = $this->config->get('ravepay_test_secret_key');
        }

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        if ($order_info) 
        {
        	$data['test'] = $order_info['total'];
        	$data['txnref'] 		= 	uniqid('rvp' .$this->session->data['order_id'] . '-');
        	$data['amount']			=	number_format($order_info['total']);
        	$data['email'] 			= 	$order_info['email'];
        	$data['firstname']		=	$order_info['payment_firstname'];
        	$data['lastname']		=	$order_info['payment_lastname'];
        	$data['phone']			=	$order_info['telephone'];
        	$data['country']		=	$this->config->get('config_country_iso_code_2');
        	$data['currency']		=	$order_info['currency_code'];
        	$data['description']	=	$this->config->get('config_name');
        	$data['title']			=	$this->config->get('config_title');
        	$data['logo']			=	$this->config->get('config_url') .'/image/' . $this->config->get('config_logo');

        	$hash_values			=	$data['public_key'].$data['amount'].$data['country'].$data['currency'].$data['description'].$data['logo'].$data['title'].$data['email'].$data['firstname'].$data['lastname'].$data['phone'].$data['txnref'];

			$data['integrity_hash']			=	hash('sha256', $hash_values.$data['secret_key']);


			$data['callback'] =  $this->config->get('config_url') /*$this->url->link('payment/ravepay/callback', 'trxref=' . rawurlencode($data['txnref']), 'SSL')*/;


			return $this->load->view('payment/ravepay', $data);
        }

	}
	
	public function verifyTransaction($transactionreference)
	{
        $query = array(
            "SECKEY" => $this->config->get('ravepay_test_secret_key'),
            "flw_ref" => $transactionreference,
            "normalize" => "1"
        );

        $data_string = json_encode($query);
                
        $ch = curl_init('http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/verify');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        $resp = json_decode($response, true);

        return $resp;

        /*$chargeResponse = resp['data']['flwMeta']['chargeResponse'];
        $chargeAmount = resp['data']['amount'];
        $chargeCurrency = resp['data']['transaction_currency']*/

	}	
	public function callback()
	{
		$json = array();
		
		$this->load->model('checkout/order');
		
		if (isset($this->request->get['flw_ref'])) {
			$flw_ref = $this->request->get['flw_ref'];

			$response_api =  $this->verifyTransaction($flw_ref);
			//var_dump($response);
			$trxref = $response_api['data']['tx_ref'];
		  	$order_id = substr($trxref, 0, strpos($trxref, '-'));
		  	$order_id = substr($order_id, 3);
		  	//echo $order_id;
            // if no dash were in transation reference, we will have an empty order_id
            if(!$order_id) {
                $order_id = 0;
            }

            $order_info = $this->model_checkout_order->getOrder($order_id);
            
            if ($order_info) {

            	if($response_api['status'] === 'success') {
            		$order_status_id = $this->config->get('ravepay_order_status_id');

            		$redir_url = $this->url->link('checkout/success');

            	}else if ($response_api['status'] === 'failure'){
            		$order_status_id = "Failure";

            		$redir_url = $this->url->link('checkout/checkout');
            	}

            	$order_status_id = $this->config->get('config_order_status_id');

            	$this->model_checkout_order->addOrderHistory($order_id, $order_status_id);

            	$json['redirect'] = $redir_url;
            	
            }
		}

		echo '<html>' . "\n";
			echo '<head>' . "\n";
			echo '  <meta http-equiv="Refresh" content="0; url=' . $this->url->link('checkout/success') . '">' . "\n";
			echo '</head>' . "\n";
			echo '<body>' . "\n";
			echo '  <p>Please follow <a href="' . $this->url->link('checkout/success') . '">link</a>!</p>' . "\n";
			echo '</body>' . "\n";
			echo '</html>' . "\n";
		
		

	}
}