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

use Validator;
use PDF;
use Mail;
use Session;

class InvoiceController extends Controller{

	public function ViewInvoice(Request $request){
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
		
		//return view('InvoiceView', compact('Quote', 'Survey', 'QuoteID', 'TotalPrice'));
		
		$pdf = PDF::loadView('InvoiceView', compact('Quote', 'Survey', 'QuoteID', 'TotalPrice'));
		//\Storage::put('public/pdf/Quote'.$QuoteID.'.pdf', $pdf->output());
		//$pdf->save('public/pdf/Quote'.$QuoteID.'.pdf');
		return $pdf->download('Invoice'.$QuoteID.'.pdf');
		
		$data = array();
		
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
}




