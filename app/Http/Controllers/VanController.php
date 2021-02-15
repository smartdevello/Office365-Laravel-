<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Vans;

use Session;
use Validator;

class VanController extends Controller{

	public function View(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Vans", $Prm)){
			return redirect("dashboard");
		}
		
		$GetManager = Vans::get();
		$Title = "View Vans";
		return view("Van.view", compact("GetManager", "Title"));
	}
	
	public function Edit(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Vans", $Prm)){
			return redirect("dashboard");
		}
		
		$GetManager = Vans::find($Request->ID);
		$Title = "Edit Vans";
		return view("Van.edit", compact("GetManager", "Title"));
	}
	
	public function SaveAdd(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Vans", $Prm)){
			return redirect("dashboard");
		}
		
		$SaveNewAgent = new Vans();
		$SaveNewAgent->van_type = $Request->Type;
		$SaveNewAgent->van_reg_no = $Request->RegNo;
		$SaveNewAgent->save();
		Session::flash('Success', 'Van Created Successfully');
		return redirect('vans');
	}
	
	public function SaveEdit(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Vans", $Prm)){
			return redirect("dashboard");
		}
		
		$SaveNewAgent = Vans::find($Request->ID);
		$SaveNewAgent->van_type = $Request->Type;
		$SaveNewAgent->van_reg_no = $Request->RegNo;
		$SaveNewAgent->save();
		Session::flash('Success', 'Van Updated Successfully');
		return redirect('vans');
	}
	
	public function Delete(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Manage Vans", $Prm)){
			return redirect("dashboard");
		}
		
		Vans::find($Request->ID)->delete();
		
		Session::flash('Danger', 'Van Deleted Successfully');
		return redirect('vans');
	}
}




