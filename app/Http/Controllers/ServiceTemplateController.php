<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Client;
use App\Model\Quote;
use App\Model\Survey;
use App\Model\Inventory;
use App\Model\ServiceMatch;
use App\Model\RoomObject;
use App\Model\Approval;

use Validator;
use PDF;
use Mail;
use Session;

class ServiceTemplateController extends Controller{

	public function View(Request $request){
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
			
			$Title = "Service Match";
			
			$ServiceObject = ServiceMatch::where("service_match_qid", $QuoteID)->first();
			
			return view('ServiceTemplate.View',compact('Quote', 'Survey', 'AllQuote', 'QuoteID', "Title", "ServiceObject"));
		}catch(\Exception $e){
			return redirect("login");
		}
	}
	
	public function Save(Request $Request){

		$GetQuote = Quote::find($Request->qid);
		$GetQuote->vehicles_no = $Request->QuoteVehicles;
		$GetQuote->porters_no = $Request->QuoteNoPorters;
		$GetQuote->extra_porters_no = $Request->QuoteExtraPorters;
		$GetQuote->packers_no = $Request->QuoteNoPackers;
		$GetQuote->extra_packers_no = $Request->QuoteNoExtraPackers;
		$GetQuote->moving_date = $Request->QuoteMovingDate;
		$GetQuote->moving_time = $Request->QuoteArrivalTime;
		$GetQuote->delivery_date = $Request->QuoteDeliveryDate;
		$GetQuote->packaging_date = $Request->QuotePackagingDate;
		$GetQuote->save();

		$CheckService = ServiceMatch::where("service_match_qid", $Request->qid)->count();
		
		if($CheckService == 0){
			$ServiceObject = new ServiceMatch();
		}else{
			$ServiceObject = ServiceMatch::where("service_match_qid", $Request->qid)->first();
		}

		$ServiceObject->service_match_qid = $Request->qid."";
		$ServiceObject->service_match_servey = $Request->sid."";
		$ServiceObject->SurveyDate = $Request->SurveyDate."";
		$ServiceObject->From = $Request->From."";
		$ServiceObject->Building = $Request->Building."";
		$ServiceObject->Access = $Request->Access."";
		$ServiceObject->Parking = $Request->Parking."";
		$ServiceObject->To = $Request->To."";
		$ServiceObject->ToBuilding = $Request->ToBuilding."";
		$ServiceObject->ToAccess = $Request->ToAccess."";
		$ServiceObject->ToParking = $Request->ToParking."";
		$ServiceObject->TotalVolume = $Request->TotalVolume."";
		$ServiceObject->Vehicles = $Request->Vehicles."";
		$ServiceObject->NoPorters = $Request->NoPorters."";
		$ServiceObject->ExtraPorters = $Request->ExtraPorters."";
		$ServiceObject->NoPackers = $Request->NoPackers."";
		$ServiceObject->ExtraPackers = $Request->ExtraPackers."";
		$ServiceObject->NoCleaners = $Request->NoCleaners."";
		$ServiceObject->MovingDate = $Request->MovingDate."";
		$ServiceObject->ArrivalTime = $Request->ArrivalTime."";
		$ServiceObject->DeliveryDate = $Request->DeliveryDate."";
		$ServiceObject->PackagingDate = $Request->PackagingDate."";
		$ServiceObject->CleaningDate = $Request->CleaningDate."";
		$ServiceObject->WaitingTime = $Request->WaitingTime."";
		$ServiceObject->OutBy = $Request->OutBy."";
		$ServiceObject->Storage = $Request->Storage."";
		$ServiceObject->Insurance = $Request->Insurance."";
		$ServiceObject->LoadingMilage = $Request->LoadingMilage."";
		$ServiceObject->PackingMaterial = $Request->PackingMaterial."";
		$ServiceObject->PackagingService = $Request->PackagingService."";
		$ServiceObject->UnpackingService = $Request->UnpackingService."";
		$ServiceObject->HeavyItem = $Request->HeavyItem."";
		$ServiceObject->DismantlingService = $Request->DismantlingService."";
		$ServiceObject->AssemblyService = $Request->AssemblyService."";
		$ServiceObject->DisposalService = $Request->DisposalService."";
		$ServiceObject->CleaningService = $Request->CleaningService."";
		$ServiceObject->SpecialInstruction = $Request->SpecialInstruction."";
		$ServiceObject->save();
		
		$Quote = Quote::find($Request->qid);
		return redirect("ServiceTemplate?id=".$Quote->survey_id."&QuoteID=".$Quote->id);
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
		$ServiceObject = ServiceMatch::where("service_match_qid", $QuoteID)->first();
		//return view('ServiceTemplate.PDFView', compact('Quote', 'Survey', 'QuoteID', 'ServiceObject'));
		
		$pdf = PDF::loadView('ServiceTemplate.PDFView', compact('Quote', 'Survey', 'QuoteID', 'ServiceObject'));
		//\Storage::put('public/pdf/ServiceMatch'.$QuoteID.'.pdf', $pdf->output());
		return $pdf->download('ServiceMatch'.$QuoteID.'.pdf');
	}
	
	
	public function ValidateQuote(Request $Request){
		$SurveyID = decrypt($Request->id);
		$QuoteID = decrypt($Request->QuoteID);
		
		$ValidateSurvey = Survey::find($SurveyID);
		$ValidateQuote = ServiceMatch::find($QuoteID);
		
		if($ValidateSurvey == ""){
			abort("404");
		}
		
		if($ValidateQuote == ""){
			abort("404");
		}
		
		session(['PublicLink' => ""]);
		
		$Title = "Service Match";
		return view("ServiceTemplate.ValidateClient", compact("SurveyID", "QuoteID", "Title"));
	}
	
	public function ValidateClient(Request $Request){
		
		$ValidateSurvey = Survey::find($Request->SurveyID);
		$ValidateQuote = Quote::find($Request->QuoteID);
		
		if(session("PublicLink") == ""){
			if($ValidateSurvey->email == $Request->Email && $ValidateSurvey->first_name == $Request->From){
				session(['PublicLink' => $Request->SurveyID]);
				return redirect("ServiceValidateClient?SurveyID=".$Request->SurveyID."&QuoteID=".$Request->QuoteID);
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
		
		$ServiceObject = ServiceMatch::find($QuoteID);
		
		$Quote = Quote::find($ServiceObject->service_match_qid);
		$Survey = Survey::find($Request->SurveyID);


		$Survey = Survey::find($id);
		$GetClient = Client::find($Survey->client_id);
		
		$AllQuote = ServiceMatch::where('service_match_servey',$id)->where("is_delete", 0)->get();
		$Title = "Service Match";
		return view('ServiceTemplate.ClientQuoteView', compact('Quote', 'Survey', 'QuoteID', 'AllQuote', "Title", 'ServiceObject', 'AllQuote'));
	}
	
	public function DeleteService(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan", $Prm)){
			return redirect("dashboard");
		}
		
		$Quot = ServiceMatch::where("service_match_qid", $Request->id)->first();
		
		$GetActiveMatch = ServiceMatch::where("service_match_servey", $Quot->service_match_servey)->where("is_delete", 0)->first();
		
		$Quot->is_delete = 1;
		$Quot->save();
		
		
		
		return redirect("ServiceTemplate?id=".$GetActiveMatch->service_match_servey."&QuoteID=".$GetActiveMatch->service_match_qid);
	}
}




