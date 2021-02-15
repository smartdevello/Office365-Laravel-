<!DOCTYPE html>
<html>
<head>
	<style>
		body{
			font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
			font-size: 12px;
			font-weight: 400;
		}
	</style>
</head>
<body>
	<img src="{{URL('public/header.jpeg')}}" style="width:100%; height: 150px;">
	<div style="clear:both">&nbsp;</div>
	
	<div style="font-size:30px; text-align: center"><b>Service Match - {{ $Quote->id }}</b></div>

	@php
	$GetTotalVechile = explode(",", $Quote->vehicles_no);
	$FirstValue = "";
	if(isset($GetTotalVechile[0])){
		$FirstValue = $GetTotalVechile[0];
	}
	@endphp
	
	<div style="margin-top: 10px; background-color:#E9FFFF; padding: 10px;">
		<div style="background-color: #2ACDC9; padding:5px 0px; text-align: center; color: #FFF">
			<div style="float: left; width: 30%">&nbsp;</div>
			<div style="float: left; width: 30%"><b>Our Service</b></div>
			<div style="float: left; width: 30%"><b>Competition</b></div>
			<div style="clear: both"></div>
		</div>
		<table width="100%" cellpadding="0" cellspaceing="0" border="0">
			<tr>
				<td width="30%"><b>Survey Date:</b></td>
				<td width="30%">{{@$Quote->survey_date}}</td>
				<td width="30%">{{ @$ServiceObject->SurveyDate }}</td>
			</tr>
			
			<tr>
				<td><b>From:</b></td>
				<td>{{@$Quote->pickup_postcode}}</td>
				<td>{{ @$ServiceObject->From }}</td>
			</tr>


			<tr>
				<td><b>Building:</b></td>
				<td>{{@$Quote->pickup_building}}</td>
				<td>{{ @$ServiceObject->Building }}</td>
			</tr>

			<tr>
				<td><b>Access:</b></td>
				<td>{{@$Quote->pickup_access}}</td>
				<td>{{ @$ServiceObject->Access }}</td>
			</tr>

			<tr>
				<td><b>Parking:</b></td>
				<td>{{@$Quote->pickup_parking}}</td>
				<td>{{ @$ServiceObject->Parking }}</td>
			</tr>

			<tr>
				<td><b>To:</b></td>
				<td>{{@$Quote->delivery_postcode}}</td>
				<td>{{ @$ServiceObject->To }}</td>
			</tr>

			<tr>
				<td><b>Building:</b></td>
				<td>{{@$Quote->delivery_building}}</td>
				<td>{{ @$ServiceObject->ToBuilding }}</td>
			</tr>
			
			<tr>
				<td><b>Access:</b></td>
				<td>{{@$Quote->delivery_access}}</td>
				<td>{{ @$ServiceObject->ToAccess }}</td>
			</tr>

			<tr>
				<td><b>Parking:</b></td>
				<td>{{@$Quote->delivery_parking}}</td>
				<td>{{ @$ServiceObject->ToParking }}</td>
			</tr>

			<tr>
				<td><b>Total Volume:</b></td>
				<td>{{ number_format($Survey->total_volume, 2) }}</td>
				<td>{{ @$ServiceObject->TotalVolume }}</td>
			</tr>

			<tr>
				<td><b>Vehicles:</b></td>
				<td>{{ $Quote->vehicles_no }}</td>
				<td>{{ @$ServiceObject->Vehicles }}</td>
			</tr>


			<tr>
				<td><b>No Porters:</b></td>
				<td>{{@$Quote->porters_no}}</td>
				<td>{{ @$ServiceObject->NoPorters }}</td>
			</tr>

			<tr>
				<td><b>No Extra Porters:</b></td>
				<td>{{@$Quote->extra_porters_no}}</td>
				<td>{{ @$ServiceObject->ExtraPorters }}</td>
			</tr>



			<tr>
				<td><b>No Packers:</b></td>
				<td>{{@$Quote->packers_no}}</td>
				<td>{{ @$ServiceObject->NoPackers }}</td>
			</tr>


			<tr>
				<td><b>No Extra Packers:</b></td>
				<td>{{@$Quote->extra_packers_no}}</td>
				<td>{{ @$ServiceObject->ExtraPackers }}</td>
			</tr>



			<tr>
				<td><b>Moving Date:</b></td>
				<td>{{@$Quote->moving_date}}</td>
				<td>{{ @$ServiceObject->MovingDate }}</td>
			</tr>


			<tr>
				<td><b>Arrival Time:</b></td>
				<td>{{@$Quote->moving_time}}</td>
				<td>{{ @$ServiceObject->ArrivalTime }}</td>
			</tr>

			<tr>
				<td><b>Delivery Date:</b></td>
				<td>{{@$Quote->delivery_date}}</td>
				<td>{{ @$ServiceObject->DeliveryDate }}</td>
			</tr>

			<tr>
				<td><b>Packaging Date:</b></td>
				<td>{{@$Quote->packaging_date}}</td>
				<td>{{ @$ServiceObject->PackagingDate }}</td>
			</tr>

			<tr>
				<td><b>Waiting time:</b></td>
				<td>{{@$Quote->waiting_time}}</td>
				<td>{{ @$ServiceObject->WaitingTime }}</td>
			</tr>


			<tr>
				<td><b>Out by:</b></td>
				<td>{{@$Quote->out_by}}</td>
				<td>{{ @$ServiceObject->OutBy }}</td>
			</tr>

			<tr>
				<td><b>Storage:</b></td>
				<td>{{@$Quote->storage}}</td>
				<td>{{ @$ServiceObject->Storage }}</td>
			</tr>

			<tr>
				<td><b>Insurance:</b></td>
				<td>{{@$Quote->insurance}}</td>
				<td>{{ @$ServiceObject->Insurance }}</td>
			</tr>

			<tr>
				<td><b>Loading/Unloading, Mileage:</b></td>
				<td>{{@$Quote->loading_mileage}}</td>
				<td>{{ @$ServiceObject->LoadingMilage }}</td>
			</tr>

			<tr>
				<td><b>Packaging Materials:</b></td>
				<td>{{@$Quote->packaging_materials}}</td>
				<td>{{ @$ServiceObject->PackingMaterial }}</td>
			</tr>

			<tr>
				<td><b>Packaging Service:</b></td>
				<td>{{@$Quote->packaging_services}}</td>
				<td>{{ @$ServiceObject->PackagingService }}</td>
			</tr>

			<tr>
				<td><b>Unpacking Service:</b></td>
				<td>{{@$Quote->unpacking_service}}</td>
				<td>{{ @$ServiceObject->UnpackingService }}</td>
			</tr>

			<tr>
				<td><b>Heavy Items:</b></td>
				<td>{{@$Quote->heavy_items}}</td>
				<td>{{ @$ServiceObject->HeavyItem }}</td>
			</tr>

			<tr>
				<td><b>Dismantling service:</b></td>
				<td>{{@$Quote->dismantling_service}}</td>
				<td>{{ @$ServiceObject->DismantlingService }}</td>
			</tr>

			<tr>
				<td><b>Assembly service:</b></td>
				<td>{{@$Quote->assembly_service}}</td>
				<td>{{ @$ServiceObject->AssemblyService }}</td>
			</tr>

			<tr>
				<td><b>Disposal service:</b></td>
				<td>{{@$Quote->disposal_service}}</td>
				<td>{{ @$ServiceObject->DisposalService }}</td>
			</tr>

			<tr>
				<td><b>Cleaning service:</b></td>
				<td>{{@$Quote->cleaning_service}}</td>
				<td>{{ @$ServiceObject->CleaningService }}</td>
			</tr>

			<tr>
				<td><b>Special Instruction:</b></td>
				<td>{{@$Quote->special_instructions}}</td>
				<td>{{ @$ServiceObject->SpecialInstruction }}</td>
			</tr>
		</table>
</div>

<div style="clear: both">&nbsp;</div>

<div style="width: 100%; margin-top: 10px;"><img src="{{URL('public/footer.JPG')}}" style="width:100%; height: 100px"></div>
</body>
</html>