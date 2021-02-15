<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redirect;
use App\Model\Client;
use App\Model\Quote;
use App\Model\Survey;
use App\Model\Inventory;
use App\Model\RoomObject;
use App\Model\Audio;

use Validator;
use PDF;
use Mail;
use Session;

class CustomQuoteController extends Controller{
	public function CustomQuote(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Custom Quote", $Prm)){
			return redirect("dashboard");
		}
		
		if(isset($Request->client)){
			$ChekClient = Client::where("client_id", $Request->client)->count();
			if($ChekClient == 0){
				$Msg = "Invalid Cient ID";
				$Title = "Custom Quote";
				return view("custom-quote", compact("Msg", "Title"));
			}
		}else{
			$Msg = "Invalid Cient ID";
			$Title = "Custom Quote";
			return view("custom-quote", compact("Msg", "Title"));
		}
		
		$ClientData = Client::where("client_id", $Request->client)->first();
		$SurveyObject = array();
		$RoomObject = array();
		$Inventory = array();
		$Quote = array();
		
		if(isset($Request->survey)){
			$SurveyObject = Survey::find($Request->survey);
			$Inventory = Inventory::where("inventory_survey", $Request->survey)->first();
			$Quote = Quote::where("survey_id", $Request->survey)->first();
		}
		
		$Title = "Custom Quote";
		$ItemList = array();
		
		$RmObj = RoomObject::where("show_default", "1")->orderBy("show_order")->get();
		
		foreach($RmObj as $Ob){
			//print_r($Ob );
			$ItemList[$Ob->room][] = array("ID" => $Ob->object_id, "Name" => $Ob->object_name, "Width" => $Ob->object_width, "Height" => $Ob->object_height, "Depth" => $Ob->object_depth, "Vol" => $Ob->object_vol);
		}
		
		if(isset($Request->survey)){
			$RmObj = RoomObject::leftjoin("inventory", "inventory.obj_id", "remobjects.object_id")->where("inventory_survey", $Request->survey)->where("show_default", "0")->get();
			//$RmObj1 = RoomObject::join("inventory", "inventory.obj_id", "remobjects.object_id")->where("show_default", "0")->toSql();
			//echo $RmObj1;		
			foreach($RmObj as $Ob){
			//	print_r($Ob );
				$ItemList[$Ob->obj_category][] = array("ID" => $Ob->object_id, "Name" => $Ob->object_name, "Width" => $Ob->object_width, "Height" => $Ob->object_height, "Depth" => $Ob->object_depth, "Vol" => $Ob->object_vol);
			}
		}
		
		return view("custom-quote", compact("SurveyObject", "Inventory", "Quote", "ClientData", "Title", "ItemList"));
	}
	
	public function SaveCustomQuote(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Custom Quote", $Prm)){
			return redirect("dashboard");
		}
		
		$ClientData = Client::where("client_id", $Request->client_id)->first();
		if($Request->survey_id == ""){
			$SurveyObject = new Survey();
		}else{
			$SurveyObject = Survey::find($Request->survey_id);
		}
		
		$SurveyObject->client_id = $ClientData->id;
		
		if($Request->firstname == ""){
			$SurveyObject->first_name = base64_decode($ClientData->client);
		}else{
			$SurveyObject->first_name = $Request->firstname;
		}
		
		$SurveyObject->last_name = $Request->lastname;
		$SurveyObject->email = $ClientData->email;
		$SurveyObject->phone = $ClientData->mobile;		
		$SurveyObject->total_volume = $Request->total_volume == "" ? "0" : $Request->total_volume;
		$SurveyObject->total_price = $Request->total_amount == "" ? "0" : $Request->total_amount;
		$SurveyObject->save();
		
		
		Inventory::where("inventory_survey", $SurveyObject->id)->delete();
		foreach($Request->RoomObj as $Cat => $ArrCat){
			foreach($ArrCat as $ObjID => $RMO){
				
				
				
				if($RMO > 0){
					$CheckInventory = Inventory::where("inventory_survey", $SurveyObject->id)->where("obj_id", $ObjID)->count();
					if($CheckInventory == 0){
						$InventoryObject = new Inventory();
					}else{
						$InventoryObject = Inventory::where("inventory_survey", $SurveyObject->id)->where("obj_id", $ObjID)->first();
					}

					$InventoryObject->inventory_survey = $SurveyObject->id;
					$InventoryObject->obj_id = $ObjID;
					$InventoryObject->obj_category = $Cat;
					$InventoryObject->obj_qty = $RMO;
					$InventoryObject->save();
				}
			}
		}
		
		$CheckQuote = Quote::where("survey_id", $SurveyObject->id)->count();
		
		if($CheckQuote == 0){
			$Quote = new Quote();
		}else{
			if(isset($Request->quote_id)){
				$Quote = Quote::find($Request->quote_id);
			}else{
				$Quote = Quote::where("survey_id", $SurveyObject->id)->first();
			}
		}
		
		$Quote->survey_id = $SurveyObject->id;
		$Quote->survey_date = date("Y-m-d");
		$Quote->pickup_postcode = base64_decode(@$ClientData->address)."";
		$Quote->delivery_postcode = base64_decode(@$ClientData->delivery_address)."";
		
		$Quote->pickup_building = "3 Bed House";
		$Quote->pickup_access = "Floors Included";
		$Quote->pickup_parking = "Front of the Building";
		
		$Quote->delivery_building = "3 Bed House";
		$Quote->delivery_access = "Floors Included";
		$Quote->delivery_parking = "Front of the Building";
		
		$Quote->out_by = "N/A";
		$Quote->storage = "N/A";
		$Quote->insurance = "N/A";
		$Quote->loading_mileage = "Included";
		$Quote->packaging_materials = "N/A";
		$Quote->packaging_services = "N/A";
		$Quote->unpacking_service = "N/A";
		$Quote->heavy_items = "N/A";
		$Quote->dismantling_service = "Free All Items";
		$Quote->assembly_service = "Free All Items";
		$Quote->disposal_service = "Free to Local Council booked by the client";
		$Quote->cleaning_service = "N/A";
		$Quote->special_instructions = "Free 72h cancellation/updates notice for any reason. Free 24h cancellation/updates notice in case of COVID.";
		
		$Quote->plan_name = "Standard";
		$Quote->pay_txn_id = $Request->txnnid."";
		
		$Quote->save();
		
		if($Request->AudioFile != ""){
			$Audio = new Audio();
			$Audio->audio_survey = $SurveyObject->id;
			$Audio->audio_url = $Request->AudioFile;
			$Audio->save();
		}
		
		$Quote = Quote::where("survey_id", $SurveyObject->id)->where("quote_delete", "0")->first();
		
		if($Request->SaveSame != ""){
			return redirect("CustomQuote?survey=".$SurveyObject->id."&client=".$Request->client_id."&QuoteID=".$Quote->id);
		}else{
			return redirect("CustomQuote?survey=".$SurveyObject->id."&client=".$Request->client_id."&Redirect=1"."&QuoteID=".$Quote->id);
		}
	}
	
	public function SearchRoomObject(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Custom Quote", $Prm)){
			return redirect("dashboard");
		}
		
		$GetData = RoomObject::where("object_name", "like", "%".$Request->q."%")->where("show_default", "0")->get();
		
		$Arr = array();
		foreach($GetData as $GD){
			$Arr[] = array("id" => $GD->object_id, "text" => $GD->object_name, "Width" => $GD->object_width, "Height" => $GD->object_height, "Depth" => $GD->object_depth, "Volume" => $GD->object_vol);
		}
		
		echo json_encode($Arr);
	}
	
	public function AllAduio(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Survey Audio", $Prm)){
			return redirect("dashboard");
		}
		
		$Data = Audio::leftjoin("surveys", "surveys.id", "audio.audio_survey")->orderBy("audio_id", "DESC")->get();
		$Title = "Survey Audio";
		return view("CustomQuote.Audios", compact("Data", "Title"));
	}
	
	public function UploadAudio(Request $Request){
		$fileName = "";
		if ($Request->audio_data != "") {
			$extension = $Request->file('audio_data')->getClientOriginalExtension();
			$fileName = "audio".time() . '.mp3';
			$destinationPath = 'public/SurveyAudios';
			$Request->file('audio_data')->move($destinationPath, $fileName);
			$documentFile = URL("/")."/".$destinationPath . '/' . $fileName;
			
			echo $documentFile;
		}
	}
}




