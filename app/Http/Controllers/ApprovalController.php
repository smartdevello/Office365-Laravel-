<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Quote;
use App\Model\Approval;
use App\Model\User;
use App\Model\Survey;
use App\Model\Notification;

use Session;
use Validator;

class ApprovalController extends Controller{

	public function View(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan Request", $Prm)){
			return redirect("dashboard");
		}
		
		$GetManager = Approval::leftjoin("quotes", "quotes.id", "approval.approval_id")->orderBy("approval_id", "DESC")->get();
		$Title = "PMP Request";
		return view("Approval.view", compact("GetManager", "Title"));
	}
	
	public function ApprovePMP(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan Request", $Prm)){
			return redirect("dashboard");
		}
		
		$Qut = Approval::where("approval_quote", $Request->id)->where("approval_status", 0)->first();
		
		if($Request->status == 1){
			if(isset($Qut->approval_date_received)){
				$Qut->approval_date_received = date("Y-m-d");
				$Qut->approval_status = 1;
				$Qut->save();
				
				$this->SendNotification($Qut->approval_user, $Qut->approval_quote);
			}
			
			$Quote = Quote::find($Request->id);
			$Quote->approved = 1;
			$Quote->save();
		}else{
			if(isset($Qut->approval_status)){
				$Qut->approval_date_received = date("Y-m-d");
				$Qut->approval_status = 0;
				$Qut->save();
			}
			
			$Quote = Quote::find($Request->id);
			$Quote->approved = 0;
			$Quote->save();
		}
		
		return redirect()->back();
	}
	
	public function Status(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Personal Move Plan Request", $Prm)){
			return redirect("dashboard");
		}
		
		$Qut = Approval::find($Request->id);
		
		
		
		$Qut->approval_status = $Request->Status;
		if($Request->Status == 1){
			$Qut->approval_date_received = date("Y-m-d");
			$Qut->approval_status = 1;
			$Qut->save();
			
			$this->SendNotification($Qut->approval_user, $Qut->approval_quote);
			
			$Quote = Quote::find($Qut->approval_quote);
			$Quote->approved = 1;
			$Quote->save();
		}else{
			$Qut->approval_date_received = date("Y-m-d");
			$Qut->approval_status = 0;
			$Qut->save();
			
			$Quote = Quote::find($Qut->approval_quote);
			$Quote->approved = 0;
			$Quote->save();
		}
		
		
		
		return redirect("pmp-request");
	}
	
	
	public function SendNotification($User, $QT){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$GetAllUsers = User::find($User);
		$url = "https://fcm.googleapis.com/fcm/send";
        $device_tokens= array();
		

		
		$Quote = Quote::find($QT);
		$Survey = Survey::find($Quote->survey_id);
		
		$Title = "Quote Approved";
		$Body = $Survey->first_name." ".$Survey->last_name.", Price : £".$Quote->final_payable_amount;
        
        $notification = array(
                                "body" => $Body,
                                "title" => $Title,
                                "sound" => 1,
                            );
		
        $data["title"] = $Title;
        $data["content"] = $Body;
		
		$Link = URL("personal_move_plan?id=".$Quote->survey_id."&QuoteID=".$QT);
		
		/*$NewNoti = new Notification();
		$NewNoti->notification_user = $User;
		$NewNoti->notification_text = "Quote Approved : ".$QT;
		$NewNoti->notification_link = $Link;
		$NewNoti->save();*/
        
        $arrayToSend = array('to' => $GetAllUsers->fcm, "notification" => $notification, "data" => array("link" => $Link));
		
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
		
		return redirect()->back();
	}
}




