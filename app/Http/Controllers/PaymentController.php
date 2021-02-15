<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\User;
use App\Model\Quote;

use Session;
use Validator;

class PaymentController extends Controller{

	public function PayClient(Request $Request){
		$Username = "ALXP2SXTENCIHFQJ3UHUTFLMX4";
		$Passwordt = "V9ruqprZsCqyOLaxNNbBtQ==";
 		$signature = base64_encode($Username.":".$Passwordt);
		$endpoint = "https://api.mite.pay360.com/hosted/rest/sessions/5306350/payments";
		
		$QuoteID = $Request->QuoteID;
		$Quote = Quote::find($QuoteID);
		$FailURL = URL("PaymentFailed");
		$SuccessURL = URL("PaymentSuccess");
		
		$PostedString = ('{
		"session": {
			"preAuthCallback": {
				"url": "'.$FailURL.'",
				"format": "REST_JSON"
			},
			"returnUrl": {
				"url": "'.$SuccessURL.'"
			}
		},
		"transaction": {
			"merchantReference": "'.$QuoteID.'",
			"money": {
				"amount": {
					"fixed": 50
				},
				"currency": "GBP"
			}
		},
		
		"customer": {
			"identity": {
				"merchantCustomerId": "1111111111111"
			},
			"details": {
				"name": "given1 Family1",
				"emailAddress": "initialCustomer1@example.com",
				"defaultCurrency": "GBP"
			}
		}
	}');
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $endpoint,
			CURLOPT_HTTPHEADER => ['Accept: application/json', 'Content-Type: application/json', 'Authorization: Basic '.($signature)]
		));
		curl_setopt($curl, CURLOPT_POST, true ); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $PostedString);
		$resp = curl_exec($curl);
		curl_close($curl);
		
		$Response = json_decode($resp);
		
		if($Response->status == "SUCCESS"){
			echo '<script>window.location="'.$Response->redirectUrl.'"</script>';
		}
	}
	
	public function PaymentSuccess(Request $Request){
		$Username = "ALXP2SXTENCIHFQJ3UHUTFLMX4";
		$Passwordt = "V9ruqprZsCqyOLaxNNbBtQ==";
 		$signature = base64_encode($Username.":".$Passwordt);
		$endpoint = "https://api.mite.pay360.com/hosted/rest/sessions/5306350/".$Request->sessionId."/status";
		
		$QuoteID = $Request->QuoteID;
		$Quote = Quote::find($QuoteID);
		$FailURL = URL("PaymentFailed");
		$SuccessURL = URL("PaymentSuccess");
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $endpoint,
			CURLOPT_HTTPHEADER => ['Accept: application/json', 'Content-Type: application/json', 'Authorization: Basic '.($signature)]
		));
		curl_setopt($curl, CURLOPT_POST, false); 
		echo $resp = curl_exec($curl);
		curl_close($curl);
		
		$Response = json_decode($resp);
		
		echo '<pre>';
		print_r($Response);
	}
}




