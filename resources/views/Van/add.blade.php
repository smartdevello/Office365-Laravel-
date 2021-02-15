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
	{!! Form::open(['url' => 'vans/SaveAdd', 'method' => 'post']) !!}
	<div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="float-left"><h1>Add Van Detail</h1></div>
		<div class="float-right">
			<button class="btn btn-success">Save</button>
		</div>
		<div class="clearfix">&nbsp;</div>
		
		@if(Session::has('Danger'))
  <div class="alert alert-danger" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text">{!!Session::get('Danger')!!}</div>
  </div>
  @endif
		
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Reg. No.</label>
				<input type="text" required class="form-control" name="RegNo">
			  </div>
			</div>
			
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Type</label>
				<select type="text" required class="form-control" name="Type">
					<option value="">Select</option>
					<option>Maxi Mover</option>
					<option>Luton Van</option>
					<option>Low Loader</option>
					<option>Half A Luton Van</option>
				</select>
			  </div>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
</body>
</html>