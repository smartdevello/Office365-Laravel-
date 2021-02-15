<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Client;
use App\Model\Quote;
use App\Model\Survey;
use App\Model\User;
use App\Model\PackingJob;
use App\Model\MovingJob;
use DB;
use Session;

class CalendarController extends Controller{

	public function LiveCalendar(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Live Calendar", $Prm)){
			return redirect("dashboard");
		}
		
		Quote::where("quote_status", "!=", "3")->where("moving_date", "<", date("Y-m-d"))->update(["quote_status" => "2"]);
		
		if(@$_GET['SaveFrom'] == "Moving"){
			$Qut = MovingJob::find($_GET['quoteid']);
			$Qut->moving_job_confirmed = $_GET['QuoteStatus'];
			$Qut->moving_job_note = $_GET['note'];
			$Qut->moving_job_moving_date = $_GET['movingdate'];
			$Qut->save();

			MovingJob::where("moving_job_quote", $Qut->moving_job_quote)->update(["moving_job_confirmed" => $_GET['QuoteStatus']]);


			return redirect("live-calendar?month=".$Request->month."&year=".$Request->year);
		}


		if(@$_GET['SaveFrom'] == "Packing"){
			$Qut = PackingJob::find($_GET['quoteid']);
			$Qut->packing_job_status = $_GET['QuoteStatus'];
			$Qut->packing_note = $_GET['note'];
			$Qut->packing_job_date = $_GET['movingdate'];
			$Qut->save();
			return redirect("live-calendar?month=".$Request->month."&year=".$Request->year);
		}
		
		$HTML = $this->show();
		$GetAllDriver = User::where("role", "Driver")->get();
		
		$Title = "Live Calendar";
		return view("LiveCalendar", compact("HTML", "GetAllDriver", "Title"));
	}
	
	
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = URL('live-calendar');
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
     
    private $currentYear=0;
     
    private $currentMonth=0;
     
    private $currentDay=0;
     
    private $currentDate=null;
     
    private $daysInMonth=0;
     
    private $naviHref= "";
     
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show() {
        $year  = null;
         
        $month = null;
         
        if(null==$year&&isset($_GET['year'])){
 
            $year = $_GET['year'];
         
        }else if(null==$year){
 
            $year = date("Y",time());  
         
        }          
         
        if(null==$month&&isset($_GET['month'])){
 
            $month = $_GET['month'];
         
        }else if(null==$month){
 
            $month = date("m",time());
         
        }                  
         
        $this->currentYear=$year;
         
        $this->currentMonth=$month;
         
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                        '<div class="box">'.
                        $this->_createNavi().
                        '</div>'.
                        '<table width="100%" cellspacing="0" cellpadding="5" class="table table-bordered">'.
                                '<thead><tr><ul class="label">'.$this->_createLabels().'</tr></thead>';
                                $content.='<tbody>';
                                $weeksInMonth = $this->_weeksInMonth($month,$year);
                                for( $i=0; $i<$weeksInMonth; $i++ ){
									$content.='<tr>';
                                    for($j=1;$j<=7;$j++){
										$content.='<td>';
                                        $content.=$this->_showDay($i*7+$j);
										$content.='</td>';
                                    }
									$content.='</tr>';
                                }
                                 
                                $content.='</tbody>';
                        $content.='</tbody>';
                 
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber){
         
        if($this->currentDay==0){
             
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                 
                $this->currentDay=1;
                 
            }
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
             
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
             
            $cellContent = $this->currentDay;
             
            $this->currentDay++;   
             
        }else{
             
            $this->currentDate =null;
 
            $cellContent=null;
        }
		
		$NewLI = "";

		if($this->currentDate != ""){
			\DB::connection()->enableQueryLog();
			$CheckEvent = MovingJob::leftjoin("quotes", "quotes.id", "moving_job.moving_job_quote")->where("moving_job_moving_date", $this->currentDate)->orWhere("moving_job_delivery_date", $this->currentDate)->where("job_confirmed", "1")->where("quote_delete", "0")->count();


			$queries = \DB::getQueryLog();

	        $NewLI = $cellContent;
			
			if($CheckEvent > 0){
				$CheckEvent = MovingJob::leftjoin("quotes", "quotes.id", "moving_job.moving_job_quote")->select("moving_job.*", "quotes.*", "SUV.first_name", "SUV.last_name", "SUV.client_id", "SUV.total_volume", "SUV.email", "SUV.phone")->leftjoin("surveys as SUV", "SUV.id", "quotes.survey_id")->where("moving_job_moving_date", $this->currentDate)->orWhere("moving_job_delivery_date", $this->currentDate)->where("job_confirmed", "1")->where("quote_delete", "0")->get();

				foreach($CheckEvent as $EventInfo){
					$Client = Client::find($EventInfo->client_id);
					$URL = URL("personal_move_plan?id=".$EventInfo->survey_id."&QuoteID=".$EventInfo->id);
					
					$NewLI .= "<form method='get'><div class='alert alert-primary' style='margin-bottom: 5px;'>
					<input type='hidden' name='month' value='".$this->currentMonth."'>
					<input type='hidden' name='year' value='".$this->currentYear."'>
					<input type='hidden' name='quoteid' value='".$EventInfo->moving_job_id."'>";

					$NewLI .= "<div><b>Job ID: </b> ".$EventInfo->id."</div>";
					$NewLI .= "<div><b>Name: </b> ".$EventInfo->first_name." ".$EventInfo->last_name."</div>";
					$NewLI .= "<div><b>Phone: </b> <a href='tel:".$EventInfo->phone."'>".$EventInfo->phone."</a></div>";
					$NewLI .= "<div><b>From: </b> ".$EventInfo->pickup_postcode."</div>";
					$NewLI .= "<div><b>To: </b> ".$EventInfo->delivery_postcode."</div>";
					$NewLI .= "<div><b>MC: </b> ".$EventInfo->total_volume."</div>";
					$NewLI .= "<div><b>Acc. Mng.: </b> ".@$Client->account_manager."</div>";
					
					$NewLI .= "<div><b>VAN: </b> ".$EventInfo->moving_job_vehicles."</div>";

					
					$Status = "";
					
					if($EventInfo->moving_job_confirmed == "0"){
						$Status = "To Be Confirmed";
					}
					
					if($EventInfo->moving_job_confirmed == "1"){
						$Status = "Confirmed";
					}
					
					if($EventInfo->moving_job_confirmed == "2"){
						$Status = "Completed";
					}
					
					if($EventInfo->moving_job_confirmed == "3"){
						$Status = "Cancelled";
					}
					$NewLI .= "<div><b>Status: </b> ".$Status."</div>";
					
					$NewLI .= "<div class='row'>
					<div class='col-lg-12'>
						<input type='date' name='movingdate' class='form-control' value='".$EventInfo->moving_job_moving_date."'>
					</div>
					";
					
					
					
					$NewLI .= "</div>
					<div style='margin-top: 5px;'><textarea name='note' class='form-control'>".$EventInfo->moving_job_note."</textarea></div>";
					$NewLI .= "<div style='margin-top: 5px;'>
					<button class='btn btn-success' name='SaveFrom' value='Moving'>Save</button>
					<a href='".$URL."' target='_blank'><button class='btn btn-primary' type='button'>Details</button></a>
					</div></div></form>";
				}
			}
		}
		
		
		
		

		$CheckEvent = PackingJob::leftjoin("quotes", "quotes.id", "packing_job.packing_job_quote_id")->where("packing_job_date", $this->currentDate)->where("job_confirmed", "1")->where("quote_delete", "0")->count();
		
		if($CheckEvent > 0){
			$CheckEvent = PackingJob::leftjoin("quotes", "quotes.id", "packing_job.packing_job_quote_id")->select("packing_job.*", "quotes.*", "SUV.first_name", "SUV.last_name", "SUV.client_id", "SUV.total_volume", "SUV.email", "SUV.phone")->leftjoin("surveys as SUV", "SUV.id", "quotes.survey_id")->where("packing_job_date", $this->currentDate)->where("job_confirmed", "1")->where("quote_delete", "0")->get();

			foreach($CheckEvent as $EventInfo){
				if($EventInfo->packing_job_date != "0000-00-00"){
					$Client = Client::find($EventInfo->client_id);
					
					$URL = URL("personal_move_plan?id=".$EventInfo->survey_id."&QuoteID=".$EventInfo->id);

					$NewLI .= "<form method='get'><div class='alert alert-primary' style='margin-bottom: 5px; background-color: #f1af88; color: #850000; border-color: #f1af88'>
					<input type='hidden' name='month' value='".$this->currentMonth."'>
					<input type='hidden' name='year' value='".$this->currentYear."'>
					<input type='hidden' name='quoteid' value='".$EventInfo->packing_job_id."'>";

					$NewLI .= "<div><b>Job ID: </b> ".$EventInfo->id."</div>";
					$NewLI .= "<div><b>Name: </b> ".$EventInfo->first_name." ".$EventInfo->last_name."</div>";
					$NewLI .= "<div><b>Phone: </b> <a href='tel:".$EventInfo->phone."'>".$EventInfo->phone."</a></div>";
					$NewLI .= "<div><b>Acc. Mng.: </b> ".@$Client->account_manager."</div>";
					$NewLI .= "<div><b>From: </b> ".$EventInfo->pickup_postcode."</div>";
					$NewLI .= "<div><b>To: </b> ".$EventInfo->delivery_postcode."</div>";

					$Status = "";
					
					if($EventInfo->packing_job_status == "0"){
						$Status = "To Be Confirmed";
					}
					
					if($EventInfo->packing_job_status == "1"){
						$Status = "Confirmed";
					}
					
					if($EventInfo->packing_job_status == "2"){
						$Status = "Completed";
					}
					
					if($EventInfo->packing_job_status == "3"){
						$Status = "Cancelled";
					}
					$NewLI .= "<div><b>Status: </b> ".$Status."</div>";


					$NewLI .= "<div class='row'>
					<div class='col-lg-12'>
						<input type='date' name='movingdate' class='form-control' value='".$EventInfo->packing_job_date."'>
					</div>
					";


					$NewLI .= "</div>
					<div style='margin-top: 5px;'><textarea name='note' class='form-control'>".$EventInfo->packing_note."</textarea></div>";
					$NewLI .= "<div style='margin-top: 5px;'>
					<button class='btn btn-success' name='SaveFrom' value='Packing'>Save</button>
					<a href='".$URL."' target='_blank'><button class='btn btn-primary' type='button'>Details</button></a>
					</div></div></form>";
				}
			}
		}
		
		return $NewLI;
    }
     
    /**
    * create navigation
    */
    private function _createNavi(){
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
         
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
         
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
         
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
         
        return
            '<div class="header">'.
                '<a class="prev" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels(){  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label){
             
            $content.='<td width="14%" class="'.($label==6?'end title':'start title').' title">'.$label.'</td>';
 
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){
         
        if( null==($year) ) {
            $year =  date("Y",time()); 
        }
         
        if(null==($month)) {
            $month = date("m",time());
        }
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay){
             
            $numOfweeks++;
         
        }
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
}




