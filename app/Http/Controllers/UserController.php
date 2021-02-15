<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Client;
use App\Model\Quote;
use App\Model\Survey;
use App\Model\User;
use App\Model\Notification;
use App\Model\PackingJob;
use App\Model\MovingJob;
use App\Model\DriverJob;

use Session;
use Validator;
use PDF;
use Mail;

class UserController extends Controller{

	public function DoLogin(Request $Request){
		$CheckAdmin = User::where('user', $Request->LoginEmail)->count();
		if($CheckAdmin > 0){
			$GetAdmin = User::where('user', $Request->LoginEmail)->first();
			$HashedPass = $GetAdmin->password;
			if(password_verify($Request->LoginPassword, $HashedPass)){
			    session(['UserID' => $GetAdmin->id]);
				session(['AgentName' => $GetAdmin->name]);
				session(['UserRole' => $GetAdmin->role]);
				session(['Permissions' => $GetAdmin->permissions]);
				
				if(session("PrvURL") == ""){
					return redirect('dashboard');
				}else{
					return redirect(session("PrvURL"));
				}
			}else{
				Session::flash('Danger', 'Invlalid Login');
			    return redirect("/");
			}
		}else{
			Session::flash('Danger', 'Invlalid Login');
			return redirect("/");
		}
	}
	
	function CheckLogin(){
		if(isset(session("_previous")["url"])){
			session(["PrvURL" => session("_previous")["url"]]);
			
			if(session("_previous")["url"] == URL("/")){
				session(["PrvURL" => ""]);
			}
			if(session("_previous")["url"] == URL("logout")){
				session(["PrvURL" => ""]);
			}
		}else{
			session(["PrvURL" => ""]);
		}
		

		return view("login");
	}
	
	function Dashboard(){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Title = "Dashboard";
		$AllNotification = Notification::where("notification_user", session("UserID"))->where("notification_status", 0)->orderBy("notification_id", "DESC")->get();
		return view("dashboard", compact("Title", "AllNotification"));
	}
	
	function Logout(){
		session()->flush();
		return redirect('/');
	}
	
	function ReadNoti(Request $Request){
		$NT = Notification::find($Request->id);
		$NT->notification_status = 1;
		$NT->save();
	}

	function SaveRecord(){
		$GetAllQuote = Quote::get();
		foreach($GetAllQuote as $GAQ){

			$PackObj = new PackingJob();
			$PackObj->packing_job_quote_id = $GAQ->id;
			$PackObj->packing_job_no_packers = $GAQ->packers_no;
			$PackObj->packing_job_extra_packers = $GAQ->extra_packers_no;
			$PackObj->packing_job_arrival_from = "";
			$PackObj->packing_job_arrival_to = "";
			$PackObj->packing_job_date = $GAQ->packaging_date;
			$PackObj->save();


			$PackObj = new MovingJob();
			$PackObj->moving_job_quote = $GAQ->id;
			$PackObj->moving_job_moving_date = $GAQ->moving_date;
			$PackObj->moving_job_confirmed = 0;
			$PackObj->moving_job_vehicles = $GAQ->vehicles_no;
			$PackObj->moving_job_arrival_from = $GAQ->moving_time;
			$PackObj->moving_job_arrival_to = $GAQ->moving_time_to;
			$PackObj->moving_job_delivery_date = $GAQ->delivery_date;
			$PackObj->moving_job_no_porters = $GAQ->porters_no;
			$PackObj->moving_job_extra_porters = $GAQ->extra_porters_no;
			$PackObj->save();

			$Driver = json_decode($GAQ->driver);
			if(isset($Driver->Name)){
				foreach($Driver->Name as $INN => $DRV){
					if($DRV != ""){
						$DriJob = new DriverJob();
						$DriJob->driver_job_quote = $GAQ->id;
						$DriJob->main_job_id = $PackObj->moving_job_id;
						$DriJob->driver_job_type = 1;
						$DriJob->driver_job_driver = $Driver->Name[$INN];
						$DriJob->driver_job_date = $GAQ->moving_date;
						$DriJob->driver_job_salary = $Driver->Salary[$INN];
						$DriJob->save();
					}
				}
			}
		}
	}
}




