<!DOCTYPE html>
<html>
<head>
    <title>{{ $Title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>


    <link rel="stylesheet" href="{{URL('public/style.css')}}"/>
</head>
<body style="margin-bottom:100px;">
	
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Corner Stone Removals</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
	
	@php
	$Prm = explode(",", session("Permissions"));
	@endphp
	
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">

    	<li class="nav-item">
        <a class="nav-link" href="{{ URL('dashboard') }}">Dashboard</a>
      </li>

		@if(in_array("Manage Users", $Prm))
      <li class="nav-item">
        <a class="nav-link" href="{{ URL('AccountManager') }}">Users</a>
      </li>
		@endif
	
		@if(in_array("Manage Vans", $Prm))
	<li class="nav-item">
        <a class="nav-link" href="{{ URL('vans') }}">Vans</a>
    </li>
		@endif
		
		@if(in_array("Packing Material", $Prm))
	<li class="nav-item">
        <a class="nav-link" href="{{ URL('packing-material') }}">Packing Material</a>
    </li>
		@endif
		
		
		
		@if(in_array("Operations Calendar", $Prm))
	<li class="nav-item">
        <a class="nav-link" href="{{ URL('operation-calendar') }}">Operations Calendar</a>
    </li>
		@endif
		
		@if(in_array("Custom Quote", $Prm))
	<li class="nav-item">
        <a class="nav-link" href="{{ URL('CustomQuote') }}">Custom Quote</a>
      </li>
		@endif
		
		@if(in_array("Live Calendar", $Prm))
	<li class="nav-item">
        <a class="nav-link" href="{{ URL('live-calendar') }}">Live Calendar</a>
      </li>
		@endif
		
		@if(in_array("Personal Move Plan Request", $Prm))
	<li class="nav-item">
        <a class="nav-link" href="{{ URL('pmp-request') }}">PMP</a>
    </li>
		@endif
		
		
		@if(in_array("Survey Audio", $Prm))
	<li class="nav-item">
        <a class="nav-link" href="{{ URL('survey-audio') }}">Survey Audio</a>
    </li>
		@endif

		<li class="nav-item">
	        <a class="nav-link" href="{{ URL('appointment-calendar') }}">Appointment Calendar</a>
	    </li>

	    <li class="nav-item">
	        <a class="nav-link" href="{{ URL('driver-salary') }}">Driver Salary</a>
	    </li>
		
      <li class="nav-item">
        <a class="nav-link" href="{{ URL('logout') }}">Logout</a>
      </li>
    </ul>
  </div>
</nav>
	
	<div class="clearfix">&nbsp;</div>