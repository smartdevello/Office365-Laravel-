<!DOCTYPE html>
<html>
<head>
    <title><?php echo e($Title); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="<?php echo e(URL('public/style.css')); ?>"/>
	
</head>
<body>
	<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo Form::open(['url' => 'AccountManager/SaveAdd', 'method' => 'post']); ?>

	<div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="float-left"><h1>Add Account Managers</h1></div>
		<div class="float-right">
			<button class="btn btn-success">Save</button>
		</div>
		<div class="clearfix">&nbsp;</div>
		
		<?php if(Session::has('Danger')): ?>
  <div class="alert alert-danger" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text"><?php echo Session::get('Danger'); ?></div>
  </div>
  <?php endif; ?>
		
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Name</label>
				<input type="text" required class="form-control" placeholder="Name of User" name="UserName">
			  </div>
			</div>
			
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Username</label>
				<input type="text" required class="form-control" placeholder="Username" name="UserLoginName">
			  </div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Password</label>
				<input type="text" required class="form-control" placeholder="Password" name="UserPassword">
			  </div>
			</div>
			
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Role</label>
				<select type="text" required class="form-control" name="Role">
					<option value="">Select</option>
					<option value="admin">Admin</option>
					<option value="AccMng">Account Manager</option>
					<option value="Surveyor">Surveyor</option>
					<option value="Opertional Manager">Opertional Manager</option>
					<option value="Driver">Driver</option>
				</select>
			  </div>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group">
				<label>Permissions</label>
				<div><input type="checkbox" name="Permissions[]" value="Personal Move Plan" id="Perm1"> <label for="Perm1">Personal Move Plan</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Personal Move Plan Request" id="Perm8"> <label for="Perm8">Personal Move Plan Request</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Packing Material" id="Perm7"> <label for="Perm7">Packing Material</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Custom Quote" id="Perm2"> <label for="Perm2">Custom Quote</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Survey Audio" id="Perm9"> <label for="Perm9">Survey Audio</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Live Calendar" id="Perm3"> <label for="Perm3">Live Calendar</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Operations Calendar" id="Perm4"> <label for="Perm4">Operations Calendar</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Jobsheet" id="Perm10"> <label for="Perm10">Jobsheet</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Manage Users" id="Perm5"> <label for="Perm5">Manage Users</label></div>
				<div><input type="checkbox" name="Permissions[]" value="Manage Vans" id="Perm6"> <label for="Perm6">Manage Vans</label></div>
			</div>
		</div>
	</div>
	<?php echo Form::close(); ?>

</body>
</html><?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/AccountManagers/add.blade.php ENDPATH**/ ?>