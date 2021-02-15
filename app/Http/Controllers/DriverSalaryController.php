<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Client;
use App\Model\User;
use App\Model\Appointment;
use App\Model\ClientHistory;
use App\Model\DriverJob;
use App\Model\Expenses;
use DB;
use Session;
use PDF;

class DriverSalaryController extends Controller{

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
		
		$GetAllJob = array();
		$GetAllIncome = array();
		$GetAllExpenses = array();
		$GetDriverData = "";

		if(isset($Request->FromDate) && isset($Request->ToDate)){
			$GetAllJob = DriverJob::select("driver_job_driver", "users.id", "users.name")->leftjoin("users", "users.id", "driver_job.driver_job_driver")->distinct("driver_job_driver")->where("driver_job_date", ">=", $Request->FromDate)->where("driver_job_date", "<=", $Request->ToDate)->get()->toArray();

			if(isset($Request->ID)){
				$GetAllIncome = DriverJob::where("driver_job_driver", $Request->ID)->where("driver_job_date", ">=", $Request->FromDate)->where("driver_job_date", "<=", $Request->ToDate)->get();

				$GetAllExpenses = Expenses::where("expenses_driver", $Request->ID)->where("expenses_date", ">=", $Request->FromDate)->where("expenses_date", "<=", $Request->ToDate)->get();

				$GetDriverData = User::find($Request->ID);
			}
		}

		$Title = "Driver Salary";
		return view("Salary.DriverSalary", compact("Title", "GetAllJob", "GetAllIncome", "GetAllExpenses", "GetDriverData"));
	}

	public function PDFSalary(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Live Calendar", $Prm)){
			return redirect("dashboard");
		}
		

		$GetAllIncome = DriverJob::where("driver_job_driver", $Request->ID)->where("driver_job_date", ">=", $Request->FromDate)->where("driver_job_date", "<=", $Request->ToDate)->get();

		$GetAllExpenses = Expenses::where("expenses_driver", $Request->ID)->where("expenses_date", ">=", $Request->FromDate)->where("expenses_date", "<=", $Request->ToDate)->get();

		$GetDriverData = User::find($Request->ID);
		//return view("Salary.SalaryPDF", compact("GetAllIncome", "GetAllExpenses", "GetDriverData"));

		$pdf = PDF::loadView("Salary.SalaryPDF", compact("GetAllIncome", "GetAllExpenses", "GetDriverData"));
		return $pdf->download('Salary '.$GetDriverData->name.'.pdf');
	}

	public function SaveExpenses(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Live Calendar", $Prm)){
			return redirect("dashboard");
		}


		$Expn = new Expenses();
		$Expn->expenses_driver = $Request->Driver;
		$Expn->expenses_added_by = session("UserID");
		$Expn->expenses_date = $Request->ExpensesDate;
		$Expn->expenses_desp = $Request->ExpensesDesp;
		$Expn->expenses_amont = $Request->ExpensesAmount;
		$Expn->save();

		return redirect()->back();
	}

	public function EditExpenses(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Live Calendar", $Prm)){
			return redirect("dashboard");
		}



		$Expn = Expenses::find($Request->ExpenseID);
		$Expn->expenses_date = $Request->ExpensesDate;
		$Expn->expenses_desp = $Request->ExpensesDesp;
		$Expn->expenses_amont = $Request->ExpensesAmount;
		$Expn->save();

		return redirect()->back();
	}

	public function ExpensesDelete(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Live Calendar", $Prm)){
			return redirect("dashboard");
		}


		Expenses::find($Request->ID)->delete();
		return redirect()->back();
	}
}




