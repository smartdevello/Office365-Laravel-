@include("header")
@php
$GetClient = App\Model\Client::find($Survey->client_id);
@endphp

    <div class="container">
        <div >
            <img src="{{URL('public/header.jpeg')}}" style="width:100%; height: 100%;">
        </div>
		
		<div class="clearfix">&nbsp;</div>
		<ul class="nav nav-tabs">
			@php
			$CountTotalActive = 0;
			@endphp
			
			@foreach($AllQuote as $QInd => $AlQ)
			@if($AlQ->quote_delete == "0")
			
			@php
			$CountTotalActive++;
			@endphp
			
		  <li class="nav-item">
			<a class="nav-link" href="{{ URL('personal_move_plan') }}?id={{ $_GET['id'] }}&QuoteID={{ $AlQ->id }}">Plan {{ $AlQ->id }} - {{$AlQ->plan_name}}</a>
		  </li>
			
			@php
			$CheckForService = App\Model\ServiceMatch::where("service_match_qid", $AlQ->id)->where("is_delete", 0)->count();
			@endphp
			
			@if($CheckForService > 0)
			<li class="nav-item">
			<a class="nav-link  @if($QuoteID == $AlQ->id) active @endif" href="{{ URL('ServiceTemplate') }}?id={{ $_GET['id'] }}&QuoteID={{ $AlQ->id }}">Service Match {{ $AlQ->id }}</a>
		  </li>
			@endif
			
			@endif
			@endforeach
		</ul>
		
		<div class="clearfix">&nbsp;</div>
        {!!Form::open(['url'=>'ServiceTemplateSave', 'enctype' => 'multipart/form-data', 'method'=>'post']) !!}
		
		@if(isset($ServiceObject->service_match_id))
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a onClick="DeleteQuote()"><button type="button" class="btn btn-danger">Delete</button></a>
        </div>
		@endif
		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<button type="submit" class="btn btn-primary inputbtn">Save</button>
		</div>
		
		@if(isset($ServiceObject->service_match_id))
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="{{ URL('MailServiceTemplate') }}?id={{ $_GET['id'] }}&QuoteID={{ $_GET['QuoteID'] }}"><button type="button" class="btn btn-success">Mail PDF</button></a>
		</div>

		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="{{ URL('ValidateServiceMatch') }}?id={{ encrypt($_GET['id']) }}&QuoteID={{ encrypt($ServiceObject->service_match_id) }}" target="_blank"><button type="button" class="btn btn-danger">Generate Link</button></a>
		</div>
		@endif
		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="{{ URL('CustomQuote') }}?survey={{ $_GET['id'] }}&client={{ $GetClient->client_id }}&QuoteID={{ $_GET['QuoteID'] }}"><button type="button" class="btn btn-info inputbtn">Survey</button></a>
		</div>
		
		
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		
		<div class="clearfix"></div>
		
            <div  style="margin-top:30px;">
                <div class="text-center">
                    <div style="font-size:30px;">
                    <b>Service Match Template : {{ $_GET['QuoteID'] }}</b>
                </div>    
            </div>  
            
            <input type="hidden" name="qid" value="{{$Quote->id}}">
			<input type="hidden" name="sid" value="{{$Quote->survey_id}}">

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
						<div class="col-4"><input type="text" class="form-control" name="SurveyDate" value="{{ @$ServiceObject->SurveyDate }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>From:</b></div>
						<div class="col-4">{{@$Quote->pickup_postcode}}</div>
						<div class="col-4"><input type="text" class="form-control" name="From" value="{{ @$ServiceObject->From }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Building:</b></div>
						<div class="col-4">{{@$Quote->pickup_building}}</div>
						<div class="col-4"><input type="text" class="form-control" name="Building" value="{{ @$ServiceObject->Building }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Access:</b></div>
						<div class="col-4">{{@$Quote->pickup_access}}</div>
						<div class="col-4"><input type="text" class="form-control" name="Access" value="{{ @$ServiceObject->Access }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Parking:</b></div>
						<div class="col-4">{{@$Quote->pickup_parking}}</div>
						<div class="col-4"><input type="text" class="form-control" name="Parking" value="{{ @$ServiceObject->Parking }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>To:</b></div>
						<div class="col-4">{{@$Quote->delivery_postcode}}</div>
						<div class="col-4"><input type="text" class="form-control" name="To" value="{{ @$ServiceObject->To }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Building:</b></div>
						<div class="col-4">{{@$Quote->delivery_building}}</div>
						<div class="col-4"><input type="text" class="form-control" name="ToBuilding" value="{{ @$ServiceObject->ToBuilding }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Access:</b></div>
						<div class="col-4">{{@$Quote->delivery_access}}</div>
						<div class="col-4"><input type="text" class="form-control" name="ToAccess" value="{{ @$ServiceObject->ToAccess }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Parking:</b></div>
						<div class="col-4">{{@$Quote->delivery_parking}}</div>
						<div class="col-4"><input type="text" class="form-control" name="ToParking" value="{{ @$ServiceObject->ToParking }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
                    
					<div class="row">
						<div class="col-4"><b>Total Volume:</b></div>
						<div class="col-4">{{ number_format($Survey->total_volume, 2) }}</div>
						<div class="col-4"><input type="text" class="form-control" name="TotalVolume" value="{{ @$ServiceObject->TotalVolume }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Vehicles:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteVehicles" value="{{ $Quote->vehicles_no }}"></div>
						<div class="col-4"><input type="text" class="form-control" name="Vehicles" value="{{ @$ServiceObject->Vehicles }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Porters:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteNoPorters" value="{{@$Quote->porters_no}}"></div>
						<div class="col-4"><input type="text" class="form-control" name="NoPorters" value="{{ @$ServiceObject->NoPorters }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>No Extra Porters:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteExtraPorters" value="{{@$Quote->extra_porters_no}}"></div>
						<div class="col-4"><input type="text" class="form-control" name="ExtraPorters" value="{{ @$ServiceObject->ExtraPorters }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Packers:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteNoPackers" value="{{@$Quote->packers_no}}"></div>
						<div class="col-4"><input type="text" class="form-control" name="NoPackers" value="{{ @$ServiceObject->NoPackers }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Extra Packers:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteNoExtraPackers" value="{{@$Quote->extra_packers_no}}"></div>
						<div class="col-4"><input type="text" class="form-control" name="ExtraPackers" value="{{ @$ServiceObject->ExtraPackers }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Moving Date:</b></div>
						<div class="col-4"><input type="date" class="form-control" name="QuoteMovingDate" value="{{@$Quote->moving_date}}"></div>
						<div class="col-4"><input type="text" class="form-control" name="MovingDate" value="{{ @$ServiceObject->MovingDate }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Arrival Time:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteArrivalTime" value="{{@$Quote->moving_time}}"></div>
						<div class="col-4"><input type="text" class="form-control" name="ArrivalTime" value="{{ @$ServiceObject->ArrivalTime }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Delivery Date:</b></div>
						<div class="col-4"><input type="date" class="form-control" name="QuoteDeliveryDate" value="{{@$Quote->delivery_date}}"></div>
						<div class="col-4"><input type="text" class="form-control" name="DeliveryDate" value="{{ @$ServiceObject->DeliveryDate }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Date:</b></div>
						<div class="col-4"><input type="date" class="form-control" name="QuotePackagingDate" value="{{@$Quote->packaging_date}}"></div>
						<div class="col-4"><input type="text" class="form-control" name="PackagingDate" value="{{ @$ServiceObject->PackagingDate }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Waiting time:</b></div>
						<div class="col-4">{{@$Quote->waiting_time}}</div>
						<div class="col-4"><input type="text" class="form-control" name="WaitingTime" value="{{ @$ServiceObject->WaitingTime }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Out by:</b></div>
						<div class="col-4">{{@$Quote->out_by}}</div>
						<div class="col-4"><input type="text" class="form-control" name="OutBy" value="{{ @$ServiceObject->OutBy }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Storage:</b></div>
						<div class="col-4">{{@$Quote->storage}}</div>
						<div class="col-4"><input type="text" class="form-control" name="Storage" value="{{ @$ServiceObject->Storage }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Insurance:</b></div>
						<div class="col-4">{{@$Quote->insurance}}</div>
						<div class="col-4"><input type="text" class="form-control" name="Insurance" value="{{ @$ServiceObject->Insurance }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Loading/Unloading, Mileage:</b></div>
						<div class="col-4">{{@$Quote->loading_mileage}}</div>
						<div class="col-4"><input type="text" class="form-control" name="LoadingMilage" value="{{ @$ServiceObject->LoadingMilage }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Materials:</b></div>
						<div class="col-4">{{@$Quote->packaging_materials}}</div>
						<div class="col-4"><input type="text" class="form-control" name="PackingMaterial" value="{{ @$ServiceObject->PackingMaterial }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Service:</b></div>
						<div class="col-4">{{@$Quote->packaging_services}}</div>
						<div class="col-4"><input type="text" class="form-control" name="PackagingService" value="{{ @$ServiceObject->PackagingService }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Unpacking Service:</b></div>
						<div class="col-4">{{@$Quote->unpacking_service}}</div>
						<div class="col-4"><input type="text" class="form-control" name="UnpackingService" value="{{ @$ServiceObject->UnpackingService }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Heavy Items:</b></div>
						<div class="col-4">{{@$Quote->heavy_items}}</div>
						<div class="col-4"><input type="text" class="form-control" name="HeavyItem" value="{{ @$ServiceObject->HeavyItem }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Dismantling service:</b></div>
						<div class="col-4">{{@$Quote->dismantling_service}}</div>
						<div class="col-4"><input type="text" class="form-control" name="DismantlingService" value="{{ @$ServiceObject->DismantlingService }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Assembly service:</b></div>
						<div class="col-4">{{@$Quote->assembly_service}}</div>
						<div class="col-4"><input type="text" class="form-control" name="AssemblyService" value="{{ @$ServiceObject->AssemblyService }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Disposal service:</b></div>
						<div class="col-4">{{@$Quote->disposal_service}}</div>
						<div class="col-4"><input type="text" class="form-control" name="DisposalService" value="{{ @$ServiceObject->DisposalService }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Cleaning service:</b></div>
						<div class="col-4">{{@$Quote->cleaning_service}}</div>
						<div class="col-4"><input type="text" class="form-control" name="CleaningService" value="{{ @$ServiceObject->CleaningService }}"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Special Instruction:</b></div>
						<div class="col-4">{{@$Quote->special_instructions}}</div>
						<div class="col-4"><textarea type="text" class="form-control" name="SpecialInstruction">{{ @$ServiceObject->SpecialInstruction }}</textarea></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					

         {!!Form::close()!!}
	</div>
			
				</div>
				
				
					<div style="width: 100%; margin-top: 20px;">
            <img src="{{URL('public/footer.JPG')}}" style="width:100%; height: 100%;">
        </div>   
				
				<div class="clearfix">&nbsp;</div>
				<h1>Service Match History</h1>
				<table class="table table-bordered table-stripped">
					<thead>
						<tr>
							<td>Service No.</td>
							<td>Created At</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
						@foreach($AllQuote as $QInd => $AlQ)
						<tr>
							<td>{{ $QInd + 1 }}</td>
							<td>{{ date("d F, Y", strtotime($AlQ->created_at)) }}</td>
							<td>{{ $AlQ->is_delete == 0 ? "Active" : "Deleted" }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
<script>
function DeleteQuote(){
	if(confirm("Are You Sure to Delete This Service Template")){
		window.location = "{{ URL('DeleteService') }}?id={{ $QuoteID }}";
	}
}	
</script>
</body>
</html>
