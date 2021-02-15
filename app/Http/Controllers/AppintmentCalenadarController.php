<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Client;
use App\Model\User;
use App\Model\Appointment;
use App\Model\ClientHistory;
use DB;
use Session;

class AppintmentCalenadarController extends Controller{

	public function View(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Live Calendar", $Prm)){
			return redirect("dashboard");
		}

		$Message = "";

		if(!isset($Request->clientID)){
			$Message = "Client ID is Required";
		}
		
		$CliendID = $Request->clientID;
		$ClientData = Client::find($CliendID);
		$Title = "Appointment Calendar";

		$dt = new \DateTime;

		if (isset($_GET['year']) && $_GET['year'] != "" && isset($_GET['week']) && $_GET['week'] != ""){
			$dt->setISODate($_GET['year'], $_GET['week']);
		} else {
			$dt->setISODate($dt->format('o'), $dt->format('W'));
		}

		$year = $dt->format('o');
		$week = $dt->format('W');

		$StartDate = $dt->format("Y-m-d");

		$NewDate = $dt->format("Y-m-d");

		$Matrix = array();
		for($K = 0; $K < 7; $K++){
			$Matrix[$K] = array();
			for($j = 0; $j < 96; $j++){
				$Matrix[$K][$j] = array();
			}
		}

		for($K = 0; $K < 7; $K++){
			$TodayDate = date("Y-m-d", strtotime("+".$K." days", strtotime($NewDate)));


			for($j = 0; $j <= 48; $j++){
				$Mint = $j * 15;
				$Time = date("H:i", strtotime("+".$Mint." minutes", strtotime(date("Y-m-d 08:00:00"))));

				$GetAppointData = Appointment::where("appointment_date", $TodayDate)->where("appointment_time", $Time);

				if(isset($_GET['filter']) && $_GET['filter'] != ""){
					$Arr = explode(",", $_GET['filter']);
					$GetAppointData = $GetAppointData->whereIn("appointment_status", $Arr);
				}

				$GetAppointData = $GetAppointData->get();

				foreach($GetAppointData as $GPD){
					if($GPD->appointment_duration == 1){
						$Matrix[$K][$j][$GPD->appointment_id] = $this->AssignNo($Matrix[$K][$j]);
					}

					if($GPD->appointment_duration == 2){
						$NewVal = $this->AssignNo($Matrix[$K][$j]);
						$Matrix[$K][$j][$GPD->appointment_id] = $NewVal;
						$Matrix[$K][$j+1][$GPD->appointment_id] = $NewVal;
					}

					if($GPD->appointment_duration == 3){
						$NewVal = $this->AssignNo($Matrix[$K][$j]);
						$Matrix[$K][$j][$GPD->appointment_id] = $NewVal;
						$Matrix[$K][$j+1][$GPD->appointment_id] = $NewVal;
						$Matrix[$K][$j+2][$GPD->appointment_id] = $NewVal;
					}

					if($GPD->appointment_duration == 4){
						$NewVal = $this->AssignNo($Matrix[$K][$j]);
						$Matrix[$K][$j][$GPD->appointment_id] = $NewVal;
						$Matrix[$K][$j+1][$GPD->appointment_id] = $NewVal;
						$Matrix[$K][$j+2][$GPD->appointment_id] = $NewVal;
						$Matrix[$K][$j+3][$GPD->appointment_id] = $NewVal;
					}
				}
			}
		}

		$GetAllAccMng = User::where("role", "AccMng")->get();
		return view("appointment-calendar", compact("week", "Title", "year", "dt", "StartDate", "Matrix", "Message", "CliendID", "ClientData", "GetAllAccMng"));
	}

	public function AssignNo($Arr){
		if(!in_array("1", $Arr)){
			return "1";
		}

		if(in_array("4", $Arr)){
			return "5";
		}

		if(in_array("3", $Arr)){
			return "4";
		}

		if(in_array("2", $Arr)){
			return "3";
		}

		if(in_array("1", $Arr)){
			return "2";
		}

		
	}

	public function Save(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Live Calendar", $Prm)){
			return redirect("dashboard");
		}

		$AccMng = 0;

		if($Request->ClientStatus == "20 App in person con"){
			$AccMng = "Group Survey In-person";
		}
		if($Request->ClientStatus == "20 App online confir"){
			$AccMng = "Group Survey Online";
		}
		if($Request->ClientStatus == "20 App inventorylist"){
			$AccMng = "Group Survey Online";
		}

		$GetCleint = Client::find($Request->AppointmentCliendID);
		$GetCleint->client = base64_encode($Request->ClientName);
		$GetCleint->property = $Request->ClientBuilding;
		$GetCleint->status = $Request->ClientStatus;
		$GetCleint->account_manager = $AccMng;
		$GetCleint->address = base64_encode($Request->ClientPickup);
		$GetCleint->save();

		$ObjHist = new ClientHistory();
		$ObjHist->client_id = $Request->AppointmentCliendID;
		$ObjHist->status = $Request->ClientStatus;
		$ObjHist->reminder_date = $Request->AppointmentDate . " " . $Request->AppointmentTime;
		$ObjHist->account_manager = $AccMng;
		$ObjHist->type = "appointment";
		$ObjHist->save();

		if(!isset($Request->AppointmentID)){
			$ApntObj = new Appointment();
		}else{
			$ApntObj = Appointment::find($Request->AppointmentID);
		}
		$ApntObj->appointment_user = session("UserID");
		$ApntObj->appointment_client = $Request->AppointmentCliendID;
		$ApntObj->appointment_status = $Request->ClientStatus;
		$ApntObj->appointment_date = $Request->AppointmentDate;
		$ApntObj->appointment_time = $Request->AppointmentTime;
		$ApntObj->appointment_duration = $Request->AppointmentDuration;
		$ApntObj->medium = $Request->AppointmentMedium;
		$ApntObj->save();

		return redirect("appointment-calendar?week=".$Request->week."&year=".$Request->year."&clientID=".$Request->AppointmentCliendID."&filter=".$Request->filter);
	}
}




