<!DOCTYPE html>
<html>
<head>
    <title>Personal Move Plan</title>
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
		<div class="float-left"><h1>Van Details</h1></div>
		<div class="float-right">
			<a href="{{ URL('vans/Add') }}"><button class="btn btn-info">Add New</button></a>
		</div>
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
                <th>Reg No.</th>
				<th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
			@foreach($GetManager as $GM)
            <tr>
                <td>{{ $GM->van_reg_no }}</td>
                <td>{{ $GM->van_type }}</td>
                <td>
					<a href="{{ URL('vans/Edit') }}/{{ $GM->van_id }}">Edit</a> |
					<a onClick="return ConfrmDelete()" href="{{ URL('vans/Delete') }}/{{ $GM->van_id }}">Delete</a>
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
		
		function ConfrmDelete(){
			if(confirm('Are You Sure to Delete this Record')){
				return true
			}
			return false
		}
	</script>
</body>
</html>