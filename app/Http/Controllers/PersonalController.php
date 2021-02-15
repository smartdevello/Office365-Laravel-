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
use App\Model\Approval;
use App\Model\User;
use App\Model\Notification;
use App\Model\ClientHistory;
use App\Model\PackingJob;
use App\Model\MovingJob;

use Validator;
use PDF;
use Mail;
use Session;

class PersonalController extends Controller{

	public function Load(Request $request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		try{
			$id = $_GET['id'];
			$QuoteID = "";

			if(isset($_GET['QuoteID'])){
				$QuoteID = $_GET['QuoteID'];
			}

			if($QuoteID != ""){
				$Quote = Quote::find($QuoteID);
				$Survey = Survey::find($Quote->survey_id);
			}else{
				$Quote = Quote::where('survey_id',$id)->count();
				if($Quote > 0){
					$Quote = Quote::where('survey_id',$id)->first();
					$Survey = Survey::find($id);
					$QuoteID = $Quote->id;
				}else{
					$Quote ="";
				}
			}

			$AllQuote = Quote::where('survey_id',$id)->get();
			$Title = "Personal Move Plan";

			$PackingJob = PackingJob::where("packing_job_quote_id", $QuoteID)->get();
			$MovingJob = MovingJob::where("moving_job_quote", $QuoteID)->get();
			return view('personal_move_plan',compact('Quote', 'Survey', 'AllQuote', 'QuoteID', "Title", "PackingJob", "MovingJob"));
		}catch(\Exception $e){
			return redirect("login");
		}
	}
	
	public function ChangeQuoteStatus(Request $request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		$Quote = Quote::find($request->qid);
		$Quote->client_confrim = $request->JobConfimed;
		$Quote->save();
		return redirect('ValidateClient?SurveyID='.$Quote->survey_id."&QuoteID=".$request->qid);
	}

	public function editsave(Request $request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		$Quote = Quote::find($request->qid);
		
		if($request->SendPacking == "1"){
			$Quote->packing_material_sent = 1;
			$Quote->packing_material_sent_date = date("Y-m-d");
		}
		
		if($Quote->final_payable_amount != $request->FinalAmount){
			$Approveal = new Approval();
			$Approveal->approval_user = session("UserID");
			$Approveal->approval_quote = $Quote->id;
			$Approveal->approval_date = date("Y-m-d");
			$Approveal->approval_price = $request->FinalAmount;
			$Approveal->approval_old_price = $Quote->final_payable_amount;
			$Approveal->save();
			
			$this->SendNotification($Quote->id);
			$Quote->approved = 0;
		}
		
		$Quote->job_confirmed = $request->JobConfimed;
		$Quote->survey_date = $request->survey_date;
		$Quote->surveyor = $request->surveyor;
		$Quote->pickup_postcode = $request->from;
		$Quote->pickup_building = $request->bulding;
		$Quote->pickup_access = $request->access;
		$Quote->pickup_parking = $request->parking;
		$Quote->delivery_postcode = $request->to;
		$Quote->delivery_building = $request->delivery_building;
		$Quote->delivery_access = $request->delivery_access;
		$Quote->delivery_parking = $request->delivery_parking;
		$Quote->porters_no = $request->porters_no;
		$Quote->extra_porters_no = $request->extra_porters_no;
		$Quote->packers_no = $request->packers_no;
		$Quote->extra_packers_no = $request->extra_packers_no;
		$Quote->cleaners_no = $request->cleaners_no;
		$Quote->moving_date = $request->moving_date;
		$Quote->delivery_date = $request->delivery_date;
		$Quote->packaging_date = $request->packaging_date;
		$Quote->cleaning_date = $request->cleaning_date;
		$Quote->waiting_time = $request->waiting_time;
		$Quote->out_by = $request->out_by;
		$Quote->storage = $request->storage;
		$Quote->insurance = $request->insurance;

		$Quote->loading_mileage = $request->loading_mileage;
		$Quote->packaging_materials = $request->packaging_materials;
		$Quote->packaging_services = $request->packaging_services;
		$Quote->unpacking_service = $request->unpacking_service;

		$Quote->heavy_items = $request->heavy_items;
		$Quote->dismantling_service = $request->dismantling_service;
		$Quote->assembly_service = $request->assembly_service;
		$Quote->disposal_service = $request->disposal_service;
		$Quote->quote_status = $request->QutoeStatus;
		$Quote->cleaning_service = $request->cleaning_service;
		$Quote->special_instructions = $request->special_instructions;
		$Quote->other_amount = $request->other_amount;

		$Quote->vehicles_no = implode(",", $request->MovingVehicle[0]);
		$Quote->porters_no = $request->porters_no[0];
		$Quote->extra_porters_no = isset($request->extra_porters_no[0]) ? $request->extra_porters_no[0] : 0;
		$Quote->packers_no = $request->packers_no[0];
		$Quote->extra_packers_no = isset($request->extra_packers_no[0]) ? $request->extra_packers_no[0] : 0;;
		$Quote->moving_date = $request->moving_date[0];
		$Quote->moving_time = $request->moving_time[0]." TO ".$request->moving_time_to[0];
		$Quote->delivery_date = $request->delivery_date[0];
		$Quote->packaging_date = $request->packaging_date[0];

		if($request->other_amount == 0){
			$Quote->final_payable_amount = $request->FinalAmount;
		}else{
			$Quote->final_payable_amount = $request->other_amount;
		}
		$Quote->save();



		/**************************************************************/
		/**************** Insert Packing Job **************************/
		/**************************************************************/

		if(isset($request->ExitingPackageID)){
			PackingJob::whereNotIn("packing_job_id", $request->ExitingPackageID)->where("packing_job_quote_id", $request->qid)->delete();
		}

		$ConfChooose = -1;
		foreach($request->packers_no as $key => $val){
			if(isset($request->ExitingPackageID[$key])){
				$PackObj = PackingJob::find($request->ExitingPackageID[$key]);
			}else{
				$PackObj = new PackingJob();
			}

			if(isset($request->MovingConfirmed[0])){
				$ConfChooose = $request->MovingConfirmed[0];
			}

			$PackObj->packing_job_quote_id = $request->qid;
			$PackObj->packing_job_no_packers = $val;
			$PackObj->packing_job_extra_packers = isset($request->extra_packers_no[$key]) ? $request->extra_packers_no[$key] : "0";
			$PackObj->packing_job_arrival_from = $request->packing_time_from[$key]."";
			$PackObj->packing_job_arrival_to = $request->packing_time_to[$key]."";
			$PackObj->packing_job_date = $request->packaging_date[$key]."";
			$PackObj->packing_job_status = $ConfChooose;
			$PackObj->save();
		}

		if(isset($request->ExitingJobID)){
			MovingJob::whereNotIn("moving_job_id", $request->ExitingJobID)->where("moving_job_quote", $request->qid)->delete();
		}

		$ConfChooose = -1;

		foreach($request->moving_time as $key => $val){
			if(isset($request->ExitingJobID[$key])){
				$PackObj = MovingJob::find($request->ExitingJobID[$key]);
			}else{
				$PackObj = new MovingJob();
			}

			if(isset($request->MovingConfirmed[$key])){
				$ConfChooose = $request->MovingConfirmed[$key];
			}

			$PackObj->moving_job_quote = $request->qid;
			$PackObj->moving_job_moving_date = $request->moving_date[$key]."";
			$PackObj->moving_job_confirmed = $ConfChooose;
			$PackObj->moving_job_vehicles = isset($request->MovingVehicle[$key]) ? implode(",", $request->MovingVehicle[$key]) : "";
			$PackObj->moving_job_arrival_from = $request->moving_time[$key]."";
			$PackObj->moving_job_arrival_to = $request->moving_time_to[$key]."";
			$PackObj->moving_job_delivery_date = $request->delivery_date[$key]."";
			$PackObj->moving_job_no_porters = $request->porters_no[$key]."";
			$PackObj->moving_job_extra_porters = isset($request->extra_porters_no[$key]) ? $request->extra_porters_no[$key] : "0";
			$PackObj->save();
		}

		return redirect('/personal_move_plan?id='.$Quote->survey_id."&QuoteID=".$request->qid);
	}
	
	function GetDistance(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		$URL = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?key=AIzaSyBXGXDXrvcv8hNOcR4TZ3rZyCcdMbNSD70&origins=".urlencode($Request->From)."&destinations=".urlencode($Request->To)."&units=imperial");
		
		$Arr = json_decode($URL);
		
		$MtrDest = $Arr->rows[0]->elements[0]->distance->value;
		$Mile = $MtrDest * 0.000621371;
		
		echo round($Mile, 2);
	}
	
	public function CreateQuote(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		$QuoteID = $_GET['QuoteID'];
		$record = Quote::find($QuoteID);
        $NewPo = $record->replicate();
		$NewPo->plan_name = $Request->Type;
        $NewPo->save();

        $GetAllMovingJob = MovingJob::where("moving_job_quote", $QuoteID)->get();
        foreach($GetAllMovingJob as $GMJ){
        	$Recrd = MovingJob::find($GMJ->moving_job_id);
        	$MovRecrd = $Recrd->replicate();
        	$MovRecrd->moving_job_quote = $NewPo->id;
        	$MovRecrd->save();
        }

        $GetAllMovingJob = PackingJob::where("packing_job_quote_id", $QuoteID)->get();
        foreach($GetAllMovingJob as $GMJ){
        	$Recrd = PackingJob::find($GMJ->packing_job_id);
        	$MovRecrd = $Recrd->replicate();
        	$MovRecrd->packing_job_quote_id = $NewPo->id;
        	$MovRecrd->save();
        }

		return redirect("personal_move_plan?id=".$Request->id."&QuoteID=".$NewPo->id);
	}
	
	public function ValidateQuote(Request $Request){
		$SurveyID = decrypt($Request->id);
		$QuoteID = decrypt($Request->QuoteID);
		
		$ValidateSurvey = Survey::find($SurveyID);
		$ValidateQuote = Quote::find($QuoteID);
		
		if($ValidateSurvey == ""){
			abort("404");
		}
		
		if($ValidateQuote == ""){
			abort("404");
		}
		
		session(['PublicLink' => ""]);
		
		$Title = "Personal Move Plan";
		return view("ValidateClient", compact("SurveyID", "QuoteID", "Title"));
	}
	
	public function ValidateClient(Request $Request){
		
		$ValidateSurvey = Survey::find($Request->SurveyID);
		$ValidateQuote = Quote::find($Request->QuoteID);
		
		if(session("PublicLink") == ""){
			if($ValidateSurvey->email == $Request->Email && $ValidateSurvey->first_name == $Request->From){
				session(['PublicLink' => $Request->SurveyID]);
				return redirect("ValidateClient?SurveyID=".$Request->SurveyID."&QuoteID=".$Request->QuoteID);
			}else{
				Session::flash('Danger', 'Invlalid Details');
				return redirect()->back();
			}
		}
		if(session("PublicLink") != $Request->SurveyID){
			Session::flash('Danger', 'Invlalid Details');
			return redirect("/");
		}
		
		$id = $Request->SurveyID;
		$QuoteID = $Request->QuoteID;

		$Quote = Quote::find($QuoteID);
		$Survey = Survey::find($Request->SurveyID);


		$Survey = Survey::find($id);
		$GetClient = Client::find($Survey->client_id);
		
		$TotalPrice = $Quote->final_payable_amount;
		$AllQuote = Quote::where('survey_id',$id)->get();
		
		$CheckForConfirm = 0;
		$TotalJobs = 0;
		
		foreach($AllQuote as $ALQ){
			if($ALQ->quote_delete == 0){
				$TotalJobs++;
				if($ALQ->client_confrim == "1"){
					$CheckForConfirm++;
				}
			}
		}
		
		$Title = "Personal Move Plan";

		$PackingJob = PackingJob::where("packing_job_quote_id", $QuoteID)->get();
		$MovingJob = MovingJob::where("moving_job_quote", $QuoteID)->get();

		return view('ClientQuoteView', compact('Quote', 'Survey', 'QuoteID', 'TotalPrice', 'AllQuote', 'TotalJobs', 'CheckForConfirm', "Title", 'CheckForConfirm', "PackingJob", "MovingJob"));
	}
	
	public function DriverQuoteView(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Jobsheet", $Prm)){
			return redirect("dashboard");
		}
		
		$ValidateSurvey = Survey::find($Request->id);
		$ValidateQuote = Quote::find($Request->QuoteID);
		
		$id = $Request->id;
		$QuoteID = $Request->QuoteID;

		$Quote = Quote::find($QuoteID);
		$Survey = Survey::find($Request->SurveyID);


		$Survey = Survey::find($id);
		$GetClient = Client::find($Survey->client_id);

		$Title = "Personal Move Plan";
		$PackingJob = PackingJob::where("packing_job_quote_id", $QuoteID)->get();
		$MovingJob = MovingJob::where("moving_job_quote", $QuoteID)->get();
		return view('DriverQuoteView', compact('Quote', 'Survey', 'QuoteID', "Title", "PackingJob", "MovingJob"));
	}
	
	public function DeleteQuote(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		$Quot = Quote::find($Request->id);
		$Quot->quote_delete = 1;
		$Quot->save();
		
		$QuoteID = "";
		$Quote = Quote::where('survey_id',$Quot->survey_id)->where("quote_delete", 0)->count();
		if($Quote > 0){
			$Quote = Quote::where('survey_id',$Quot->survey_id)->where("quote_delete", 0)->first();
			$QuoteID = $Quote->id;
		}else{
			$Quote ="";
		}
		
		return redirect("personal_move_plan?id=".$Quot->survey_id."&QuoteID=".$QuoteID);
	}
	
	public function MailQuote(Request $request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		$id = $_GET['id'];
		$QuoteID = "";
		
		if(isset($_GET['QuoteID'])){
			$QuoteID = $_GET['QuoteID'];
		}
		
		if($QuoteID != ""){
			$Quote = Quote::find($QuoteID);
			$Survey = Survey::find($Quote->survey_id);
		}else{
			$Quote = Quote::where('survey_id',$id)->count();
			if($Quote > 0){
				$Quote = Quote::where('survey_id',$id)->first();
				$QuoteID = $Quote->id;
			}else{
				$Quote ="";
			}
		}
		
		$Survey = Survey::find($id);
		$GetClient = Client::find($Survey->client_id);
		
		
		$TotalPrice = $Quote->final_payable_amount;
		

		$PackingJob = PackingJob::where("packing_job_quote_id", $QuoteID)->get();
		$MovingJob = MovingJob::where("moving_job_quote", $QuoteID)->get();
		//return view('PDFView', compact('Quote', 'Survey', 'QuoteID', 'TotalPrice', "PackingJob", "MovingJob"));
		
		$pdf = PDF::loadView('PDFView', compact('Quote', 'Survey', 'QuoteID', 'TotalPrice', "PackingJob", "MovingJob"));
		//\Storage::put('public/pdf/Quote'.$QuoteID.'.pdf', $pdf->output());
		//$pdf->save('public/pdf/Quote'.$QuoteID.'.pdf');
		
		return $pdf->download('Quote'.$QuoteID.'.pdf');
		$data = array();
		
                $clientName =  base64_decode($GetClient->client);
                $projectManager = $GetClient->account_manager;
                $body = "test";
		$data = array("name"=>$clientName, "account_manager" => $projectManager,"body"=>$body);
		Mail::send("emails.mail", $data, function ($m) use ($QuoteID, $GetClient) {
			$m->from("office@cornerstoneremovals.co.uk", "Corner Stone");
			$m->to($GetClient->email)->subject('Re: Your house more quotation');
			$m->to("cbbeny@gmail.com")->subject('Your Quotation Detail #'.$QuoteID);
			
			//$m->to("cornerstoneremovalsalerts@gmail.com")->subject('Your Quotation Detail #'.$QuoteID);
			$m->attach('public/pdf/Quote'.$QuoteID.'.pdf', [
				'as' => 'quote.pdf',
				'mime' => 'application/pdf',
			]);
		});	
		
/*		Mail::send("MailQuote", $data, function ($m) use ($QuoteID, $GetClient) {
			$m->from("cornerstoneremovalsalerts@gmail.com", "Corner Stone");
			$m->to($GetClient->email)->subject('Your Quotation Detail #'.$QuoteID);
			$m->attach('public/pdf/Quote'.$QuoteID.'.pdf', [
				'as' => 'quote.pdf',
				'mime' => 'application/pdf',
			]);
		});*/
		
		
		//return redirect("personal_move_plan?id=".$Quote->survey_id."&QuoteID=".$QuoteID);
	}
	
	public function ApprovePMP(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		$Quote = Quote::find($Request->id);
		$Quote->approved = $Request->status;
		$Quote->save();
		
		return redirect("personal_move_plan?id=".$Quote->survey_id."&QuoteID=".$Quote->id);
	}
	
  public function SendMailQuote(Request $request){
	
		$id = $_REQUEST['id'];
		
		$QuoteID = "";
                if(isset($_REQUEST['QuoteID'])){
			$QuoteID = $_REQUEST['QuoteID'];
		}
		
		if($QuoteID != ""){
			$Quote = Quote::find($QuoteID);
			$Survey = Survey::find($Quote->survey_id);
		}else{
			$Quote = Quote::where('survey_id',$id)->count();
			if($Quote > 0){
				$Quote = Quote::where('survey_id',$id)->first();
				$QuoteID = $Quote->id;
			}else{
				$Quote ="";
			}
		}
		
		$Survey = Survey::find($id);
		$GetClient = Client::find($Survey->client_id);
		
		
		$TotalPrice = 0;
		$TotalMile = 0;
		$VanArr = explode(",", $Quote->vehicles_no);
		$TotalVans = 0;
		foreach($VanArr as $VAN){
			$TotalVans++;
			if($VAN == "luton_van"){
				$TotalPrice += 500;
			}

			if($VAN == "maxi_mover"){
				$TotalPrice += 700;
			}

			if($VAN == "half_a_luton_van"){
				$TotalPrice += 350;
			}

			if($VAN == "low_loader"){
				$TotalPrice += 600;
			}
		}
		
		$PackagingDate = $Quote->packaging_date;
		$MovingDate = $Quote->moving_date;
		$DeliveryDate = $Quote->delivery_date;
		if($PackagingDate != "0000-00-00"){
			if($MovingDate != $PackagingDate){
				$TotalPrice += 350;
			}else{
				$TotalPrice += 250;
			}
		}
		
		
		if($DeliveryDate != $MovingDate){
			foreach($VanArr as $VAN){
				if($VAN == "luton_van"){
					$TotalPrice += 495;
				}

				if($VAN == "maxi_mover"){
					$TotalPrice += 495;
				}

				if($VAN == "half_a_luton_van"){
					$TotalPrice += 495;
				}

				if($VAN == "low_loader"){
					$TotalPrice += 495;
				}
			}
		}
		
		$GetExtraPorter = $Quote->extra_porters_no;
		$GetExtraPackers = $Quote->extra_packers_no;
		$TotalPrice += $GetExtraPorter * 110;
		$TotalPrice += $GetExtraPackers * 110;
		
			
		$FromCode = $Quote->pickup_postcode;
		$ToCode = $Quote->delivery_postcode;
		$URL = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?key=AIzaSyBXGXDXrvcv8hNOcR4TZ3rZyCcdMbNSD70&origins=".urlencode($FromCode)."&destinations=".urlencode($ToCode)."&units=imperial");
		//return $URL;
		$Arr = json_decode($URL);
		
		$MtrDest = $Arr->rows[0]->elements[0]->distance->value;
		$Mile = $MtrDest * 0.000621371;
		$TotalPrice += $Mile * $TotalVans;
		
		//return view('PDFView', compact('Quote', 'Survey', 'QuoteID', 'TotalPrice'));
		
		$pdf = PDF::loadView('PDFView', compact('Quote', 'Survey', 'QuoteID', 'TotalPrice'));
		\Storage::put('public/pdf/Quote'.$QuoteID.'.pdf', $pdf->output());
		$pdf->save('public/pdf/Quote'.$QuoteID.'.pdf');
                
               // return $pdf->download('Quote'.$QuoteID.'.pdf');
                
		
		$data = array();
                
                $clientName =  base64_decode($GetClient->client);
                $projectManager = $GetClient->account_manager;
                $body = $_REQUEST['mailBody'];
								$History = new ClientHistory();
								$History->client_id = $GetClient->id;
								$History->account_manager = $projectManager;
								$History->type = "email_sent";
								$History->notes = base64_encode($body);
								$History->added_at = date("Y-m-d h:i:s", time());
								$History->save();					
		$data = array("name"=>$clientName, "account_manager" => $projectManager,"body"=>$body);
			 Mail::send("emails.mail", $data, function ($m) use ($QuoteID, $GetClient,$body) {
			$m->from("office@cornerstoneremovals.co.uk", "Corner Stone");
			$m->to($GetClient->email)->subject('Your Quotation Details #'.$QuoteID);
			//$m->to("cornerstoneremovalsalerts@gmail.com")->subject('Your Quotation Details #'.$QuoteID);
			$m->setBody($body, 'text/html');
			$m->to("cbbeny@gmail.com")->subject('Your Quotation Details #'.$QuoteID);
			$m->attach('public/pdf/Quote'.$QuoteID.'.pdf', [
				'as' => 'quote.pdf',
				'mime' => 'application/pdf',
			])->attach('public/pdf/Terms_and_Conditions.pdf', [
				'as' => 'Terms and Conditions.pdf',
				'mime' => 'application/pdf',
			]);
		});
		return response()->json(['success'=>'true']);
		
		return redirect("personal_move_plan?id=".$Quote->survey_id."&QuoteID=".$QuoteID);
	}	
	
	
	public function SendNotification($QuoteID){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$GetAllUsers = User::where("permissions", "like", "%Personal Move Plan Request%")->get();
		
		$url = "https://fcm.googleapis.com/fcm/send";
        $device_tokens = array();
		
		
		$Quote = Quote::find($QuoteID);
		$Survey = Survey::find($Quote->survey_id);
		
		$Title = "New Quote to Approve";
		$Body = $Survey->first_name." ".$Survey->last_name.", Price : £".$Quote->final_payable_amount;
		
        $notification = array(
                                "body" => $Body,
                                "title" => $Title,
                                "sound" => 1,
                            );
		
        $data["title"] = $Title;
        $data["content"] = $Body;
		
		$URL = URL("personal_move_plan?id=".$Quote->survey_id."&QuoteID=".$QuoteID);
	
		foreach($GetAllUsers as $GUUDS){
			
			$NewNoti = new Notification();
			$NewNoti->notification_user = $GUUDS->id;
			$NewNoti->notification_text = "New Quote to Approve : ".$QuoteID;
			$NewNoti->notification_link = $URL;
			$NewNoti->save();
			
			$arrayToSend = array('to' => $GUUDS->fcm, "notification" => $notification, "data" => array("link" => $URL));

			$json = json_encode($arrayToSend);

			$headers = array();
			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Authorization: key=AAAA7dL2HG0:APA91bHlIwzEdSZQAJfWKSFSRqtTB7eBEbVAPC7vgzXwSGBxcA3jX8FoVYusM5OSIfhluY5eA_qcJlQD5PC8Hqz_EyHVwOfVRA2DUxksGT3ENwWd0yOO5s8VygJWXy02BToVTG_vacgH';

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			$result = curl_exec($ch);
			if ($result === FALSE) {
				die('FCM Send Error: ' . curl_error($ch));
			}
			curl_close( $ch );
		}
	}
}




