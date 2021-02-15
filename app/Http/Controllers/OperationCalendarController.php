<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Model\Client;
use App\Model\Quote;
use App\Model\Survey;
use App\Model\User;
use App\Model\Vans;
use App\Model\PackingJob;
use App\Model\MovingJob;
use App\Model\DriverJob;

use Session;

class OperationCalendarController extends Controller{

	public function LiveCalendar(Request $Request){
		if(session("UserID") == ""){
			return redirect("/");
		}
		
		$Prm = explode(",", session("Permissions"));
		if(!in_array("Operations Calendar", $Prm)){
			return redirect("dashboard");
		}
		
		Quote::where("quote_status", "!=", "3")->where("moving_date", "<", date("Y-m-d"))->update(["quote_status" => "2"]);
		
		if($Request->SaveFrom == "MovingJob"){

			$Qut = MovingJob::find($Request->quoteid);
			$Qut->moving_job_confirmed = $Request->QuoteStatus;
			$Qut->moving_job_note = $Request->note;
			$Qut->moving_job_van_reg_no = $Request->van_reg_no;
			$Qut->moving_job_vechicle_reg_no = implode(",", $Request->van);
			$Qut->save();

			if(isset($Request->driver["AlID"])){
				DriverJob::whereNotIn("driver_job_id", $Request->driver["AlID"])->where("driver_job_quote", $Qut->moving_job_quote)->where("driver_job_type", 1)->where("main_job_id", $Request->quoteid)->delete();
			}

			foreach($Request->driver["Name"] as $Indx => $Val){
				if($Val != ""){
					if(isset($Request->driver["AlID"][$Indx])){
						$DriJob = DriverJob::find($Request->driver["AlID"][$Indx]);
					}else{
						$DriJob = new DriverJob();
					}
					$DriJob->driver_job_quote = $Qut->moving_job_quote;
					$DriJob->main_job_id = $Request->quoteid;
					$DriJob->driver_job_type = 1;
					$DriJob->driver_job_driver = $Val;
					$DriJob->driver_job_date = $Qut->moving_job_moving_date;
					$DriJob->driver_job_salary = $Request->driver["Salary"][$Indx];
					$DriJob->save();
				}
			}


			return redirect("operation-calendar?month=".$Request->month."&year=".$Request->year);
		}



		if($Request->SaveFrom == "PackingJob"){
			$Qut = PackingJob::find($Request->quoteid);
			$Qut->packing_job_status = $Request->QuoteStatus;
			$Qut->packing_note = $Request->note;
			$Qut->save();

			if(isset($Request->driver["AlID"])){
				DriverJob::whereNotIn("driver_job_id", $Request->driver["AlID"])->where("driver_job_quote", $Qut->packing_job_quote_id)->where("driver_job_type", 0)->where("main_job_id", $Request->quoteid)->delete();
			}

			foreach($Request->driver["Name"] as $Indx => $Val){
				if($Val != ""){
					if(isset($Request->driver["AlID"][$Indx])){
						$DriJob = DriverJob::find($Request->driver["AlID"][$Indx]);
					}else{
						$DriJob = new DriverJob();
					}
					$DriJob->driver_job_quote = $Qut->packing_job_quote_id;
					$DriJob->driver_job_type = 0;
					$DriJob->main_job_id = $Request->quoteid;
					$DriJob->driver_job_driver = $Val;
					$DriJob->driver_job_date = $Qut->packing_job_date;
					$DriJob->driver_job_salary = $Request->driver["Salary"][$Indx];
					$DriJob->save();
				}
			}

			return redirect("operation-calendar?month=".$Request->month."&year=".$Request->year);
		}
		
		$HTML = $this->show();
		$GetAllDriver = User::where("role", "Driver")->get();
		$Title = "Operations Calendar";
		return view("LiveCalendar", compact("HTML", "GetAllDriver", "Title"));
	}
	
	
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = URL('operation-calendar');
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
		
		$GetAllVan = Vans::get();
		$GetAllDriver = User::where("role", "Driver")->get();
		$NewLI = $cellContent;
		
		
		if($this->currentDate != ""){
			$CheckEvent = MovingJob::leftjoin("quotes", "quotes.id", "moving_job.moving_job_quote")->where("moving_job_moving_date", $this->currentDate)->orWhere("moving_job_delivery_date", $this->currentDate)->where("job_confirmed", "1")->where("quote_delete", "0")->count();
			
			if($CheckEvent > 0){
				$CheckEvent = MovingJob::leftjoin("quotes", "quotes.id", "moving_job.moving_job_quote")->select("moving_job.*", "quotes.*", "SUV.first_name", "SUV.last_name", "SUV.client_id", "SUV.total_volume", "SUV.email", "SUV.phone")->leftjoin("surveys as SUV", "SUV.id", "quotes.survey_id")->where("moving_job_moving_date", $this->currentDate)->orWhere("moving_job_delivery_date", $this->currentDate)->where("job_confirmed", "1")->where("quote_delete", "0")->get();

				foreach($CheckEvent as $EventInfo){
					
					$MainIndex = $EventInfo->moving_job_id;
					$GetClientData = Client::find($EventInfo->client_id);
					
					$URL = URL("DriverQuote?id=".$EventInfo->survey_id."&QuoteID=".$EventInfo->id);
					$SurveyURL = URL("CustomQuote?survey=".$EventInfo->survey_id."&client=".(@$GetClientData->client_id)."&QuoteID=".$EventInfo->id);
					$JobsheetURL = URL("Jobhseet?survey=".$EventInfo->survey_id."&QuoteID=".$EventInfo->id);
					$DetailURL = URL("personal_move_plan?id=".$EventInfo->survey_id."&QuoteID=".$EventInfo->id);
					
					$NewLI .= "<form method='post'><div class='alert alert-primary' style='margin-bottom: 5px; padding: 5px;'>
					<input type='hidden' name='month' value='".$this->currentMonth."'>
					<input type='hidden' name='year' value='".$this->currentYear."'>
					<input type='hidden' name='quoteid' value='".$EventInfo->moving_job_id."'>
					";
					
					$NewLI .= "<div><b>Job ID: </b> ".$EventInfo->id."</div>";
					$NewLI .= "<div><b>Name: </b> ".$EventInfo->first_name." ".$EventInfo->last_name."</div>";
					$NewLI .= "<div><b>Phone: </b> <a href='tel:".$EventInfo->phone."'>".$EventInfo->phone."</a></div>";
					$NewLI .= "<div><b>From: </b> ".$EventInfo->pickup_postcode."</div>";
					$NewLI .= "<div><b>To: </b> ".$EventInfo->delivery_postcode."</div>";
					$NewLI .= "<div><b>Building Type: </b> ".$EventInfo->pickup_building."</div>";
					$NewLI .= "<div><b>MC: </b> ".$EventInfo->total_volume."</div>";
					$NewLI .= "<div><b>Acc. Mng.: </b> ".@$GetClientData->account_manager."</div>";
					$NewLI .= "<div><b>Price: </b> ".$EventInfo->final_payable_amount."</div>";
					$NewLI .= "<div><b>Moving Date: </b> ".$EventInfo->moving_job_moving_date."</div>";
					
					
					$SavedDriver = DriverJob::where("driver_job_quote", $EventInfo->id)->where("main_job_id", $EventInfo->moving_job_id)->where("driver_job_type", 1)->get();
						foreach($SavedDriver as $Key => $SDR){
							$NewLI .= '
							<div id="ExtDri'.$MainIndex.'">
								<input type="hidden" name="driver[AlID][]" value="'.$SDR->driver_job_id.'">
								<div style="float: left; width: 40%">
									<select class="form-control" name="driver[Name][]">
										<option value="">Select</option>';
										foreach($GetAllDriver as $GAD){
											$Selected = "";
											if($SDR->driver_job_driver == $GAD->id){
												$Selected = "selected";
											}
											$NewLI .= '<option '.$Selected.' value="'.$GAD->id.'">'.$GAD->name.'</option>';
										}


									$NewLI .= '</select>
								</div>
								<div style="float: left; width: 40%">
									<input type="number" min="0" name="driver[Salary][]" class="form-control" value="'.$SDR->driver_job_salary.'">
								</div>
								<div style="cursor: pointer; float: left; width: 20%" onClick="RemoveExtDriver('.$MainIndex.')">Remove</div>

							</div><div style="clear: both"></div>';
						}
					
					$NewLI .= '
					<div>
						<div style="float: left; width: 40%">
							<select class="form-control" name="driver[Name][]">
								<option value="">Select</option>';
								foreach($GetAllDriver as $GAD){
									$NewLI .= '<option value="'.$GAD->id.'">'.$GAD->name.'</option>';
								}
							
					
							$NewLI .= '</select>
						</div>
						<div style="float: left; width: 40%">
							<input type="number" min="0" name="driver[Salary][]" class="form-control" value="0">
						</div>
						<div onClick="AddNewDriver('.$MainIndex.')" style="cursor: pointer; float: left; width: 20%">Add</div>
					</div>
					<div style="clear: both"></div>
					<div id="LoadNewDriver'.$MainIndex.'"></div>
					';
					
					$GetAllVans = explode(",", $EventInfo->moving_job_vehicles);
					$VanRegNo = explode(",", $EventInfo->moving_job_vechicle_reg_no);
					foreach($GetAllVans as $k => $VansAll){
						$NewLI .= '
						<div style="margin-top: 5px; margin-bottom: 5px;">
							<div style="float: left; width: 40%">'.$VansAll.'</div>
							<div style="float: left; width: 60%">
								<select class="form-control" name="van[]">
									<option value="">Select</option>';
									foreach($GetAllVan as $GAD){
										$selected = "";
										
										if(isset($VanRegNo[$k]) && $VanRegNo[$k] == $GAD->van_reg_no){
											$selected = "selected";
										}
										
										$NewLI .= '<option '.$selected.' value="'.$GAD->van_reg_no.'">'.$GAD->van_reg_no.' ('.$GAD->van_type.')</option>';
									}


								$NewLI .= '</select>
							</div>
						</div>
						<div style="clear: both"></div>
						';
					}
					
					
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
					
					$NewLI .= "
					<div style='margin-top: 5px;'><textarea name='note' class='form-control'>".$EventInfo->moving_job_note."</textarea></div>";
					$NewLI .= "<div style='margin-top: 5px;'>
					<button class='btn btn-success' name='SaveFrom' value='MovingJob'>Save</button>
					<a href='".$URL."' target='_blank'><button class='btn btn-success' type='button'>Jobsheet</button></a>
					<a href='".$SurveyURL."' target='_blank'><button class='btn btn-danger' type='button'>Survey</button></a>
					<a href='".$DetailURL."' target='_blank'><button class='btn btn-primary' type='button'>Details</button></a>
					</div></div></form>";
				}
			}
			
			
			
			
			
			
			
			$CheckEvent = PackingJob::leftjoin("quotes", "quotes.id", "packing_job.packing_job_quote_id")->where("packing_job_date", $this->currentDate)->where("job_confirmed", "1")->where("quote_delete", "0")->count();
			
			if($CheckEvent > 0){
				$CheckEvent = PackingJob::leftjoin("quotes", "quotes.id", "packing_job.packing_job_quote_id")->select("packing_job.*", "quotes.*", "SUV.first_name", "SUV.last_name", "SUV.client_id", "SUV.total_volume", "SUV.email", "SUV.phone")->leftjoin("surveys as SUV", "SUV.id", "quotes.survey_id")->where("packing_job_date", $this->currentDate)->where("job_confirmed", "1")->where("quote_delete", "0")->get();

				foreach($CheckEvent as $EventInfo){
					if($EventInfo->packing_job_date != "0000-00-00"){
						$MainIndex = $EventInfo->id."0000";
						$GetClientData = Client::find($EventInfo->client_id);

						$URL = URL("DriverQuote?id=".$EventInfo->survey_id."&QuoteID=".$EventInfo->id);
						$SurveyURL = URL("CustomQuote?survey=".$EventInfo->survey_id."&client=".(@$GetClientData->client_id)."&QuoteID=".$EventInfo->id);
						$JobsheetURL = URL("Jobhseet?survey=".$EventInfo->survey_id."&QuoteID=".$EventInfo->id);
						$DetailURL = URL("personal_move_plan?id=".$EventInfo->survey_id."&QuoteID=".$EventInfo->id);

						$NewLI .= "<form method='post'><div class='alert alert-primary' style='margin-bottom: 5px; background-color: #f1af88; color: #850000; border-color: #f1af88'>
						<input type='hidden' name='month' value='".$this->currentMonth."'>
						<input type='hidden' name='year' value='".$this->currentYear."'>
						<input type='hidden' name='quoteid' value='".$EventInfo->packing_job_id."'>
						";

						$NewLI .= "<div><b>Job ID: </b> ".$EventInfo->id."</div>";
						$NewLI .= "<div><b>Name: </b> ".$EventInfo->first_name." ".$EventInfo->last_name."</div>";
						$NewLI .= "<div><b>Phone: </b> <a href='tel:".$EventInfo->phone."'>".$EventInfo->phone."</a></div>";
						$NewLI .= "<div><b>From: </b> ".$EventInfo->pickup_postcode."</div>";
						$NewLI .= "<div><b>To: </b> ".$EventInfo->delivery_postcode."</div>";
						$NewLI .= "<div><b>Building Type: </b> ".$EventInfo->pickup_building."</div>";
						$NewLI .= "<div><b>Packing Date: </b> ".$EventInfo->packing_job_date."</div>";
						$NewLI .= "<div><b>Acc. Mng.: </b> ".@$GetClientData->account_manager."</div>";
						$NewLI .= "<div><b>Packing Material: </b> ".$EventInfo->packaging_materials."</div>";


						$SavedDriver = DriverJob::where("driver_job_quote", $EventInfo->id)->where("main_job_id", $EventInfo->packing_job_id)->where("driver_job_type", 0)->get();
						foreach($SavedDriver as $Key => $SDR){
							$NewLI .= '
							<div id="ExtDri'.$MainIndex.'">
								<input type="hidden" name="driver[AlID][]" value="'.$SDR->driver_job_id.'">
								<div style="float: left; width: 40%">
									<select class="form-control" name="driver[Name][]">
										<option value="">Select</option>';
										foreach($GetAllDriver as $GAD){
											$Selected = "";
											if($SDR->driver_job_driver == $GAD->id){
												$Selected = "selected";
											}
											$NewLI .= '<option '.$Selected.' value="'.$GAD->id.'">'.$GAD->name.'</option>';
										}


									$NewLI .= '</select>
								</div>
								<div style="float: left; width: 40%">
									<input type="number" min="0" name="driver[Salary][]" class="form-control" value="'.$SDR->driver_job_salary.'">
								</div>
								<div style="cursor: pointer; float: left; width: 20%" onClick="RemoveExtDriver('.$MainIndex.')">Remove</div>

							</div><div style="clear: both"></div>';
						}

						$NewLI .= '
						<div>
							<div style="float: left; width: 40%">
								<select class="form-control" name="driver[Name][]">
									<option value="">Select</option>';
									foreach($GetAllDriver as $GAD){
										$NewLI .= '<option value="'.$GAD->id.'">'.$GAD->name.'</option>';
									}


								$NewLI .= '</select>
							</div>
							<div style="float: left; width: 40%">
								<input type="number" min="0" name="driver[Salary][]" class="form-control" value="0">
							</div>
							<div onClick="AddNewDriver('.$MainIndex.')" style="cursor: pointer; float: left; width: 20%">Add</div>
						</div>
						<div style="clear: both"></div>
						<div id="LoadNewDriver'.$MainIndex.'"></div>
						';


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
						

						$NewLI .= "
						<div style='margin-top: 5px;'><textarea name='note' class='form-control'>".$EventInfo->packing_note."</textarea></div>";
						$NewLI .= "<div style='margin-top: 5px;'>
						<button class='btn btn-success' name='SaveFrom' value='PackingJob'>Save</button>
						<a href='".$URL."' target='_blank'><button class='btn btn-success' type='button'>Jobsheet</button></a>
						<a href='".$SurveyURL."' target='_blank'><button class='btn btn-danger' type='button'>Survey</button></a>
						<a href='".$DetailURL."' target='_blank'><button class='btn btn-primary' type='button'>Details</button></a>
						</div></div></form>";
					}
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




