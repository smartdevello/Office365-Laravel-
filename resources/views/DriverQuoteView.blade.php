<!DOCTYPE html>
<html>
<head>
    <title>Clinet View</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{URL('public/style.css')}}"/>
</head>
<body>
<div class="clearfix">&nbsp;</div>
<div class="container">
        <div >
            <img src="{{URL('public/header.jpeg')}}" style="width:100%; height: 100%;">
        </div>
		<div class="clearfix">&nbsp;</div>
	
	<ul class="nav nav-tabs">
		  <li class="nav-item">
			<a class="nav-link active" href="#">Move Plan</a>
		  </li>
		<li class="nav-item">
			<a class="nav-link" href="{{ URL('Jobhseet')}}?survey={{ $_GET['id'] }}&QuoteID={{ $_GET['QuoteID'] }}">Jobsheet</a>
		  </li>
		</ul>
	
	<div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
    @php
    $GetTotalVechile = explode(",", $Quote->vehicles_no);
    $FirstValue = "";
    if(isset($GetTotalVechile[0])){
        $FirstValue = $GetTotalVechile[0];
    }
    @endphp
    
    <div  style="margin-top:30px;">
                <div class="text-center">
                    <div style="font-size:30px;">
                    <b>Personal Move Plan - {{$Quote->plan_name}}</b>
                </div>    
            </div>  
            
            <input type="hidden" name="qid" value="{{$Quote->id}}">

            <div class="col-lg-12" style="margin-top: 20px;background-color:#E9FFFF;">
                <div style="padding-top:8px;">
                    <div style="background-color: #2ACDC9; padding:10px 0px;"> 
                        <div class="text-center text-white">
                            <b>Job Details</b>
                        </div>
                    </div>
                    
                    <div class="row">
                         <div class="col-md-4">
                            <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    <b>Job ID:</b>
                                </div>
                                <div class="col-lg-6">
                                     <span style="font-size:14px;">{{$Quote->id}}</span>
                                </div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   <b>Customer Name:</b>
                                </div>    
                                <div class="col-lg-6">
                                    <span style="font-size:14px;">{{@$Survey->first_name}} {{@$Survey->last_name}}</span>
                                </div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    <b>Survey Date:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->survey_date}}</span></div>
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6" >
                                    <b>Surveyor:</b>
                                </div>
                                <div class="col-lg-6">
                                    <span style="font-size:14px;">{{ $Quote->surveyor }}</span>
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-4" style="border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                             <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                  <b>From:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->pickup_postcode}}</span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                  <b>Building:</b>
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->pickup_building}}</span></div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                     <b>Access:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->pickup_access}}</span></div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    <b>Parking:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->pickup_parking}}</span></div>
                            </div>         
                        </div>
                        <div class="col-md-4" >
                            <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    <b>To:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->delivery_postcode}}</span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   <b>Building:</b>
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->delivery_building}}</span></div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    <b>Access:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->delivery_access}}</span></div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    <b>Parking:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{ $Quote->delivery_parking }}</span></div>
                            </div> 
                              
                        </div>    
                    </div>
                    
                </div>        
            </div>   
            
            <div style="margin-top: 10px;background-color:#E9FFFF;">
                <div class="col-lg-12">
                    <div style="padding-top: 8px"> 
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white"><b>Mobing Job</b></div>
                        </div>

                        @foreach($MovingJob as $MVJ)
                        @php
                        $GetTotalVechile = explode(",", $MVJ->moving_job_vehicles);
                        $FirstValue = "";
                        foreach($GetTotalVechile as $GTV){
                            if($GTV == "maxi_mover"){
                                $FirstValue .= "Maxi Mover,";
                            }elseif($GTV == "luton_van"){
                                $FirstValue .= "Luton Van,";
                            }elseif($GTV == "low_loader"){
                                $FirstValue .= "Low Loader,";
                            }elseif($GTV == "half_a_luton_van"){
                                $FirstValue .= "Half a Luton Van,";
                            }
                        }
                        @endphp

                        <div class="row" style="margin-top:5px;">
                            <div class="col-lg-4" style="background-color:#E9FFFF;">
                                <div class="row" style="margin:5px;">
                                    <div class="col-lg-6">
                                        Moving Date:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">
                                        @if($MVJ->moving_job_moving_date != "0000-00-00")
                                        {{ date("d/m/Y", strtotime($MVJ->moving_job_moving_date)) }}
                                        @else
                                        N/A
                                        @endif
                                    </span></div> 
                                </div> 

                                <div class="row" style="margin:5px;">
                                    <div class="col-lg-6">
                                        No Vehicles:
                                    </div>
                                      <div class="col-lg-6"><span style="font-size:14px;">{{ $FirstValue }}</span></div>
                                </div>
                            </div>
                            <div class="col-lg-4" style="background-color:#E9FFFF; border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                                
                                <div class="row" style="margin:5px;">   
                                    <div class="col-lg-6">
                                       Delivery Date:
                                    </div>    
                                    <div class="col-lg-6"><span style="font-size:14px;">
                                        @if($MVJ->moving_job_delivery_date != "0000-00-00")
                                        {{ date("d/m/Y", strtotime($MVJ->moving_job_delivery_date)) }}
                                        @else
                                        N/A
                                        @endif
                                    </span></div>
                                </div>     
                            </div>
                            <div class="col-lg-4" style="background-color:#E9FFFF">
                                <div class="row" style="margin:5px;">   
                                    <div class="col-lg-6">
                                       No Porters:
                                    </div>    
                                    <div class="col-lg-6"><span style="font-size:14px;">{{ $MVJ->moving_job_no_porters }}</span></div>
                                </div>
                                
                                <div class="row" style="margin:5px; @if($MVJ->moving_job_extra_porters == 0) display: none @endif">
                                    <div class="col-lg-6"> No Extra Porters:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">{{ $MVJ->moving_job_extra_porters }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div style="height: 2px; background: #2ACDC9"></div>
                        @endforeach
                    </div>
                </div> 
            </div>






            <div style="margin-top: 10px;background-color:#E9FFFF;">
                <div class="col-lg-12">
                    <div style="padding-top: 8px"> 
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white"><b>Packaging Job</b></div>
                        </div>

                        @foreach($PackingJob as $MVJ)
                        @if($MVJ->packing_job_no_packers > 0)
                        <div class="row" style="margin-top:5px;">
                            <div class="col-lg-4" style="background-color:#E9FFFF;">
                                <div class="row" style="margin:5px;">   
                                    <div class="col-lg-6">
                                        No Packers:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">{{ $MVJ->packing_job_no_packers }}</span></div>
                                </div>
                                
                                <div class="row" style="margin:5px; @if($MVJ->packing_job_extra_packers == 0) display: none @endif" id="ExtraPakersDiv">   
                                    <div class="col-lg-6"> No Extra Packers:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">{{ $MVJ->packing_job_extra_packers }}</span></div>
                                </div> 
                            </div>
                            <div class="col-lg-4" style="background-color:#E9FFFF; border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                                <div class="row" style="margin:5px;">
                                    <div class="col-lg-6">
                                        Arrival Time:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">{{ $MVJ->packing_job_arrival_from }} TO {{ $MVJ->packing_job_arrival_to }}</span></div> 
                                </div>
                            </div>
                            <div class="col-lg-4" style="background-color:#E9FFFF; ">
                                <div class="row" style="margin:5px;">   
                                    <div class="col-lg-6">
                                       Packaging Date:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">
                                        @if($MVJ->packing_job_date != "0000-00-00")
                                        {{ date("d/m/Y", strtotime($MVJ->packing_job_date)) }}
                                        @else
                                        N/A
                                        @endif
                                    </span></div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div> 
            </div>

            <div style="margin-top: 10px;background-color:#E9FFFF;">
                <div class="col-lg-12">
                    <div style="padding-top: 8px"> 
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white"><b>Extra Information</b></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row" style="margin:5px;">
                                    <div class="col-lg-6">
                                        Waiting time:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->waiting_time}}</span></div> 
                                </div> 
                                <div class="row" style="margin:5px;">   
                                    <div class="col-lg-6">
                                       Out by:
                                    </div>    
                                    <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->out_by}}</span></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row" style="margin:5px;">   
                                    <div class="col-lg-6">
                                       Storage:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->storage}}</span></div>  
                                </div>
                                <div class="row" style="margin:5px;">         
                                    <div class="col-lg-6">
                                       Insurance:
                                    </div>
                                    <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->insurance}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div style="margin-top: 30px;background-color:#E9FFFF;">
                <div class="col-lg-12">
                    <div style="padding-top:8px;">    
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white">
                                <b>Services Details </b>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-6" style="background-color:#E9FFFF;padding-right:10px; ">
                                      <div class="row " style="margin:5px;">
                                <div class="col-lg-6">
                                   Loading/Unloading, Mileage:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->loading_mileage}}</span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                  Packaging Materials:
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->packaging_materials}}</span></div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    Packaging Service:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->packaging_services}}</span></div>
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    Unpacking Service:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->unpacking_service}}</span>
                                </div>
                            </div>  
                       
                      
                            </div>
                            <div class="col-lg-6" style="background-color:#E9FFFF;padding-right:5px; ">
                                <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                   Heavy Items:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->heavy_items}}</span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Dismantling service:
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->dismantling_service}}</span></div>
                            </div>
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    Assembly service:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->assembly_service}}</span>
                                </div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                  Disposal Service:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;">{{@$Quote->disposal_service}}</span>
                                </div>
                            </div>
                            </div>  
                        </div>
                    </div>    

                </div>        
            </div> 


            <div  style="margin-top: 20px;">
                <div class="col-lg-12"  style="background-color:#E9FFFF; padding-bottom: 10px" >
                    <div style="padding-top:8px;">
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white">
                                <b>Special Instructions</b>
                            </div>

                        </div>
                        <p style="font-size: 14px; margin-top:10px; margin-bottom:30px;">{{@$Quote->special_instructions}}</p>
                    </div>    
                </div>        
            </div>    

            <div  style="margin-top: 30px;">
                <div class="container" style="background-color:#2ACDC9;">
                    <div class="row" >
                        <div class="col-lg-7">
                            <div style="margin-left:150px; margin-top: 20px; margin-bottom: 20px;">
                                <div style="font-size: 15px; color:#fff;" >Our standard package quote for your move is:</div>

                                <div style="font-size: 14px; color:#fff;" ><i>All Inclusive, No Hidden Fees, Price Match Guarantee + 10% Off</i></div>

                                <div style="font-size: 15px; color:#fff;" >Free updates / cancellations up to 72h before the move:</div>
                            </div>   
                               
                        </div>
                        <div class="col-lg-5">
                            <div class="text-white" style="font-size:60px;">
                               <b id="ShowTotalPrice">£{{ number_format($Quote->final_payable_amount, 2) }}</b>
                            </div>    
                        </div>    
                    </div>    
                </div>    
            </div>  

         {!!Form::close()!!}
        <div style="width: 100%; margin-top: 20px;">
            <img src="{{URL('public/footer.JPG')}}" style="width:100%; height: 100%;">
        </div>
    <div class="clearfix">&nbsp;</div>
</div>
</body>
</html>