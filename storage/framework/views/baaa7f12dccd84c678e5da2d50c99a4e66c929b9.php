<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($Title); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

      <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="<?php echo e(URL('public/style.css')); ?>"/>
</head>
<body style="margin-bottom:100px;">
	
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
	
	<?php
	$Prm = explode(",", session("Permissions"));
	?>
	
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
		<?php if(in_array("Manage Users", $Prm)): ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('AccountManager')); ?>">Users</a>
      </li>
		<?php endif; ?>
	
		<?php if(in_array("Manage Vans", $Prm)): ?>
	<li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('vans')); ?>">Vans</a>
    </li>
		<?php endif; ?>
		
		<?php if(in_array("Packing Material", $Prm)): ?>
	<li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('packing-material')); ?>">Packing Material</a>
    </li>
		<?php endif; ?>
		
		
		
		<?php if(in_array("Operations Calendar", $Prm)): ?>
	<li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('operation-calendar')); ?>">Operations Calendar</a>
    </li>
		<?php endif; ?>
		
		<?php if(in_array("Custom Quote", $Prm)): ?>
	<li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('CustomQuote')); ?>">Custom Quote</a>
      </li>
		<?php endif; ?>
		
		<?php if(in_array("Live Calendar", $Prm)): ?>
	<li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('live-calendar')); ?>">Live Calendar</a>
      </li>
		<?php endif; ?>
		
		<?php if(in_array("Personal Move Plan Request", $Prm)): ?>
	<li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('pmp-request')); ?>">PMP</a>
    </li>
		<?php endif; ?>
		
		
		<?php if(in_array("Survey Audio", $Prm)): ?>
	<li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('survey-audio')); ?>">Survey Audio</a>
    </li>
		<?php endif; ?>
		
      <li class="nav-item">
        <a class="nav-link" href="<?php echo e(URL('logout')); ?>">Logout</a>
      </li>
    </ul>
  </div>
</nav>
	
	<div class="clearfix">&nbsp;</div><?php /**PATH /var/www/vhosts/cornerstoneremovals.com/laravel.cornerstoneremovals.com/resources/views/header.blade.php ENDPATH**/ ?>