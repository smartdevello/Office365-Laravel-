<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Client;
use App\Model\Quote;
use App\Model\Survey;
use App\Model\Inventory;
use App\Model\SurveyObject;
use App\Model\RoomObject;
use App\Model\PackingJob;
use App\Model\MovingJob;

use Validator;
use PDF;
use Mail;
use Session;

class JobsheetController extends Controller{

	public function JobhseetView(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Jobsheet", $Prm)){
			return redirect("dashboard");
		}
		
		$ValidateSurvey = Survey::find($Request->survey);
		$ValidateQuote = Quote::find($Request->QuoteID);
		
		$id = $Request->survey;
		$QuoteID = $Request->QuoteID;

		$Quote = Quote::find($QuoteID);
		$Survey = Survey::find($Request->SurveyID);


		$Survey = Survey::find($id);
		$GetClient = Client::find($Survey->client_id);
		
		$CleintName = $Survey->first_name." ".$Survey->last_name;
		
		$Title = "Jobsheet";
		return view('Jobhseet', compact('Quote', 'Survey', 'GetClient', 'QuoteID', "CleintName", "Title"));
		//return $pdf->download('Jobsheet '.$QuoteID.'.pdf');
	}
	
	public function SaveSign(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Jobsheet", $Prm)){
			return redirect("dashboard");
		}
		
		$data_uri = $Request->sign;
		$QuoteID = $Request->ID;
		$For = $Request->SignFor;
		$encoded_image = explode(",", $data_uri)[1];
		$decoded_image = base64_decode($encoded_image);
		if(file_exists("public/sign/".$For.$QuoteID.".png")){
			unlink("public/sign/".$For.$QuoteID.".png");
		}
		file_put_contents("public/sign/".$For.$QuoteID.".png", $decoded_image);
		
		$Quote = Quote::find($QuoteID);
		if($For == "Liability"){
			$Quote->sign_waiver = $For.$QuoteID.".png";
		}
		
		if($For == "Pickup"){
			$Quote->sign_pickup = $For.$QuoteID.".png";
		}
		
		if($For == "Delivery"){
			$Quote->sign_delivery = $For.$QuoteID.".png";
		}
		$Quote->save();
	}
}