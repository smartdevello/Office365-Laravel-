<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\User;
use App\Model\Quote;
use App\Model\Survey;
use App\Model\Approval;

use Session;
use Validator;

class AccountManagerController extends Controller{
	public function SaveFCM(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$User = User::find(session("UserID"));
		$User->fcm = $Request->Code;
		$User->save();
	}
	
	
	public function View(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Users", $Prm)){
			return redirect("dashboard");
		}
		
		$GetManager = User::get();
		$Title = "View Account Manager";
		return view("AccountManagers.view", compact("GetManager", "Title"));
	}
	
	public function Edit(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Users", $Prm)){
			return redirect("dashboard");
		}
		
		$GetManager = User::find($Request->ID);
		$Title = "Edit Account Manager";
		return view("AccountManagers.edit", compact("GetManager", "Title"));
	}
	
	public function SaveAdd(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Users", $Prm)){
			return redirect("dashboard");
		}
		
		$CheckEmail = User::where('user', $Request->UserLoginName)->count();
	    if($CheckEmail == 0){
	        $AgentPasswrod = Hash::make($Request->UserPassword);
			$SaveNewAgent = new User();
			$SaveNewAgent->name = $Request->UserName;
			$SaveNewAgent->user = $Request->UserLoginName;
			$SaveNewAgent->role = $Request->Role;
			$SaveNewAgent->colour_code = $Request->UserColor;

			$SaveNewAgent->address = $Request->Address;
			$SaveNewAgent->national_insurance = $Request->NationalInsurance;
			$SaveNewAgent->account_name = $Request->AccountName;
			$SaveNewAgent->sort_code = $Request->ShortCode;
			$SaveNewAgent->account_number = $Request->AccountNumber;

			if(isset($Request->Permissions)){
				$SaveNewAgent->permissions = implode(",", $Request->Permissions);
			}
			
			$SaveNewAgent->password = $AgentPasswrod;
			$SaveNewAgent->save();
			
			Session::flash('Success', 'Manager Created Successfully');
			return redirect('AccountManager');
	    }else{
	        Session::flash('Danger', 'Username Already Exists');
			return redirect("AccountManager/Add");
	    }
	}
	
	public function SaveEdit(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Users", $Prm)){
			return redirect("dashboard");
		}
		
		$SaveNewAgent = User::find($Request->ID);
		if($Request->UserPassword != ""){
			$AgentPasswrod = Hash::make($Request->UserPassword);
			$SaveNewAgent->password = $AgentPasswrod;
		}
		$SaveNewAgent->name = $Request->UserName;
		$SaveNewAgent->user = $Request->UserLoginName;
		$SaveNewAgent->role = $Request->Role;
		$SaveNewAgent->colour_code = $Request->UserColor;

		$SaveNewAgent->address = $Request->Address;
		$SaveNewAgent->national_insurance = $Request->NationalInsurance;
		$SaveNewAgent->account_name = $Request->AccountName;
		$SaveNewAgent->sort_code = $Request->ShortCode;
		$SaveNewAgent->account_number = $Request->AccountNumber;
		
		if(isset($Request->Permissions)){
			$SaveNewAgent->permissions = implode(",", $Request->Permissions);
		}
		$SaveNewAgent->save();

		Session::flash('Success', 'Manager Updated Successfully');
		return redirect('AccountManager');
	}
	
	public function Delete(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Users", $Prm)){
			return redirect("dashboard");
		}
		
		User::find($Request->ID)->delete();
		
		Session::flash('Danger', 'Manager Deleted Successfully');
		return redirect('AccountManager');
	}
	
	public function SendNotification(Request $request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$GetAllUsers = User::where("permissions", "like", "%Personal Move Plan Request%")->get();
		$url = "https://fcm.googleapis.com/fcm/send";
        $device_tokens= array();
		
		$Quote = Quote::find($request->QuoteID);
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
		
		$URL = URL("personal_move_plan?id=".$Quote->survey_id."&QuoteID=".$request->QuoteID);
        
		foreach($GetAllUsers as $GUUDS){
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
		
		Session::flash('Success', 'Notification Sends Successfully');
		return redirect()->back();
	}
}




