<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Quote;

use Session;
use Validator;

class PackingMaterialController extends Controller{

	public function View(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Packing Material", $Prm)){
			return redirect("dashboard");
		}
		
		$GetManager = Quote::where("packing_material_sent", 1)->orderBy("packing_material_sent_date", "DESC")->get();
		$Title = "Packing Material";
		return view("PackingMaterial.view", compact("GetManager", "Title"));
	}
	
	public function Status(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Packing Material", $Prm)){
			return redirect("dashboard");
		}
		
		$Qut = Quote::find($Request->id);
		$Qut->packing_material_delivered = $Request->Status;
		$Qut->save();
		
		return redirect("packing-material");
	}
}




