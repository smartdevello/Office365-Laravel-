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
	<div class="clearfix">&nbsp;</div>
		
	<ul class="nav nav-tabs">
			
			@php
			$CountTotalActive = 0;
			@endphp
			
			@foreach($AllQuote as $QInd => $AlQ)
			@php
			$CountTotalActive++;
			@endphp
			
		  <li class="nav-item">
			<a class="nav-link @if($QuoteID == $AlQ->service_match_id) active @endif" href="{{ URL('ServiceValidateClient') }}?SurveyID={{ $_GET['SurveyID'] }}&QuoteID={{ $AlQ->service_match_id }}">Plan {{ $QInd +1 }}</a>
		  </li>
			@endforeach
		</ul>
		
		<div class="clearfix">&nbsp;</div>
	<div  style="margin-top:30px;">
                <div class="text-center">
                    <div style="font-size:30px;">
                    <b>Service Match - {{$Quote->plan_name}}</b>
                </div>    
            </div>  
            
            <div class="col-lg-12" style="margin-top: 20px;background-color:#E9FFFF;">
                <div style="padding-top:8px;">
					<div class="row" style="background-color: #2ACDC9; padding:10px; color: #FFF">
						<div class="col-4"></div>
						<div class="col-4">Our Service</div>
						<div class="col-4">Competition</div>
					</div>
					
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Survey Date:</b></div>
						<div class="col-4">{{@$Quote->survey_date}}</div>
						<div class="col-4">{{ @$ServiceObject->SurveyDate }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>From:</b></div>
						<div class="col-4">{{@$Quote->pickup_postcode}}</div>
						<div class="col-4">{{ @$ServiceObject->From }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Building:</b></div>
						<div class="col-4">{{@$Quote->pickup_building}}</div>
						<div class="col-4">{{ @$ServiceObject->Building }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Access:</b></div>
						<div class="col-4">{{@$Quote->pickup_access}}</div>
						<div class="col-4">{{ @$ServiceObject->Access }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Parking:</b></div>
						<div class="col-4">{{@$Quote->pickup_parking}}</div>
						<div class="col-4">{{ @$ServiceObject->Parking }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>To:</b></div>
						<div class="col-4">{{@$Quote->delivery_postcode}}</div>
						<div class="col-4">{{ @$ServiceObject->To }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Building:</b></div>
						<div class="col-4">{{@$Quote->delivery_building}}</div>
						<div class="col-4">{{ @$ServiceObject->ToBuilding }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Access:</b></div>
						<div class="col-4">{{@$Quote->delivery_access}}</div>
						<div class="col-4">{{ @$ServiceObject->ToAccess }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Parking:</b></div>
						<div class="col-4">{{@$Quote->delivery_parking}}</div>
						<div class="col-4">{{ @$ServiceObject->ToParking }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
                    
					<div class="row">
						<div class="col-4"><b>Total Volume:</b></div>
						<div class="col-4">{{ number_format($Survey->total_volume, 2) }}</div>
						<div class="col-4">{{ @$ServiceObject->TotalVolume }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Vehicles:</b></div>
						<div class="col-4">{{ $Quote->vehicles_no }}</div>
						<div class="col-4">{{ @$ServiceObject->Vehicles }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Porters:</b></div>
						<div class="col-4">{{@$Quote->porters_no}}</div>
						<div class="col-4">{{ @$ServiceObject->NoPorters }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>No Extra Porters:</b></div>
						<div class="col-4">{{@$Quote->extra_porters_no}}</div>
						<div class="col-4">{{ @$ServiceObject->ExtraPorters }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Packers:</b></div>
						<div class="col-4">{{@$Quote->packers_no}}</div>
						<div class="col-4">{{ @$ServiceObject->NoPackers }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Extra Packers:</b></div>
						<div class="col-4">{{@$Quote->extra_packers_no}}</div>
						<div class="col-4">{{ @$ServiceObject->ExtraPackers }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Moving Date:</b></div>
						<div class="col-4">{{@$Quote->moving_date}}</div>
						<div class="col-4">{{ @$ServiceObject->MovingDate }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Arrival Time:</b></div>
						<div class="col-4">{{@$Quote->moving_time}}</div>
						<div class="col-4">{{ @$ServiceObject->ArrivalTime }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Delivery Date:</b></div>
						<div class="col-4">{{@$Quote->delivery_date}}</div>
						<div class="col-4">{{ @$ServiceObject->DeliveryDate }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Date:</b></div>
						<div class="col-4">{{@$Quote->packaging_date}}</div>
						<div class="col-4">{{ @$ServiceObject->PackagingDate }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Waiting time:</b></div>
						<div class="col-4">{{@$Quote->waiting_time}}</div>
						<div class="col-4">{{ @$ServiceObject->WaitingTime }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Out by:</b></div>
						<div class="col-4">{{@$Quote->out_by}}</div>
						<div class="col-4">{{ @$ServiceObject->OutBy }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Storage:</b></div>
						<div class="col-4">{{@$Quote->storage}}</div>
						<div class="col-4">{{ @$ServiceObject->Storage }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Insurance:</b></div>
						<div class="col-4">{{@$Quote->insurance}}</div>
						<div class="col-4">{{ @$ServiceObject->Insurance }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Loading/Unloading, Mileage:</b></div>
						<div class="col-4">{{@$Quote->loading_mileage}}</div>
						<div class="col-4">{{ @$ServiceObject->LoadingMilage }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Materials:</b></div>
						<div class="col-4">{{@$Quote->packaging_materials}}</div>
						<div class="col-4">{{ @$ServiceObject->PackingMaterial }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Service:</b></div>
						<div class="col-4">{{@$Quote->packaging_services}}</div>
						<div class="col-4">{{ @$ServiceObject->PackagingService }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Unpacking Service:</b></div>
						<div class="col-4">{{@$Quote->unpacking_service}}</div>
						<div class="col-4">{{ @$ServiceObject->UnpackingService }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Heavy Items:</b></div>
						<div class="col-4">{{@$Quote->heavy_items}}</div>
						<div class="col-4">{{ @$ServiceObject->HeavyItem }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Dismantling service:</b></div>
						<div class="col-4">{{@$Quote->dismantling_service}}</div>
						<div class="col-4">{{ @$ServiceObject->DismantlingService }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Assembly service:</b></div>
						<div class="col-4">{{@$Quote->assembly_service}}</div>
						<div class="col-4">{{ @$ServiceObject->AssemblyService }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Disposal service:</b></div>
						<div class="col-4">{{@$Quote->disposal_service}}</div>
						<div class="col-4">{{ @$ServiceObject->DisposalService }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Cleaning service:</b></div>
						<div class="col-4">{{@$Quote->cleaning_service}}</div>
						<div class="col-4">{{ @$ServiceObject->CleaningService }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Special Instruction:</b></div>
						<div class="col-4">{{@$Quote->special_instructions}}</div>
						<div class="col-4">{{ @$ServiceObject->SpecialInstruction }}</div>
					</div>
					<div class="clearfix">&nbsp;</div>
					

				</div>
	</div>
        <div style="width: 100%; margin-top: 20px;">
            <img src="{{URL('public/footer.JPG')}}" style="width:100%; height: 100%;">
        </div>
	<div class="clearfix">&nbsp;</div>
</div>
</body>
</html>