<!DOCTYPE html>
<html>
<head>
    <title>{{ $Title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="{{URL('public/style.css')}}"/>
	
</head>
<body>
	@include("header")
    <div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="float-left"><h1>Packing Material</h1></div>
		<div class="clearfix">&nbsp;</div>
		
		@if(Session::has('Success'))
  <div class="alert alert-success" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text">{!!Session::get('Success')!!}</div>
  </div>
  @endif
		
		@if(Session::has('Danger'))
  <div class="alert alert-danger" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text">{!!Session::get('Danger')!!}</div>
  </div>
  @endif
		
		<div class="clearfix">&nbsp;</div>
	<table id="example" class="table table-bordered table-stripped" style="width:100%">
        <thead>
            <tr>
				<th>Sr. No.</th>
                <th>Job ID</th>
				<th>Delivery Requested</th>
                <th>Name</th>
				<th>Phone</th>
				<th>Pickup Address</th>
				<th>Material</th>
                <th>Delivered</th>
            </tr>
        </thead>
        <tbody>
			@php
			$SRN = 0;
			@endphp
			
			@foreach($GetManager as $GM)
			@php
			$SRN++;
			$Survey = \App\Model\Survey::find($GM->survey_id);
			@endphp
            <tr @if($GM->packing_material_delivered == 1) class="bg-success" @endif>
                <td>{{ $SRN }}</td>
				<td>{{ $GM->id }}</td>
                <td>{{ date("d F, Y", strtotime($GM->packing_material_sent_date)) }}</td>
				<td>{{ $Survey->first_name }} {{ $Survey->last_name }}</td>
				<td>{{ $Survey->phone }}</td>
				<td>{{ $GM->pickup_postcode }}</td>
				<td>{{ $GM->packaging_materials }}</td>
                <td>
					<input type="radio" onClick="ConfirmDelivery({{ $GM->id }}, 0)" value="0" @if($GM->packing_material_delivered == 0) checked @endif name="ConfirmPacking{{ $GM->id }}"> No
					<input type="radio" onClick="ConfirmDelivery({{ $GM->id }}, 1)" value="1" @if($GM->packing_material_delivered == 1) checked @endif name="ConfirmPacking{{ $GM->id }}"> Yes
				</td>
            </tr>
			@endforeach
		</tbody>
		</table>
	</div>
	
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#example').DataTable();
	} );
		
		function ConfirmDelivery(id, status){
			window.location = "{{ URL('change-delivery-confirm') }}?id="+id+"&Status="+status;
		}
	</script>
</body>
</html>