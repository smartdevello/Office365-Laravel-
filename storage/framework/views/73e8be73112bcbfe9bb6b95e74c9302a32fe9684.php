<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo Form::open(['url' => 'AccountManager/SaveEdit', 'method' => 'post']); ?>

	<input type="hidden" name="ID" value="<?php echo e($GetManager->id); ?>">
	<div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="float-left"><h1>Edit Account Managers</h1></div>
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
				<input type="text" class="form-control" required placeholder="Name of User" name="UserName" value="<?php echo e($GetManager->name); ?>">
			  </div>
			</div>
			
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Username</label>
				<input type="text" class="form-control" required placeholder="Username" name="UserLoginName" value="<?php echo e($GetManager->user); ?>">
			  </div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Password</label>
				<input type="text" class="form-control" placeholder="Password" name="UserPassword">
			  </div>
			</div>
			
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Role</label>
				<select type="text" required class="form-control" name="Role">
					<option value="">Select</option>
					<option <?php if($GetManager->role == "admin"): ?> selected <?php endif; ?> value="admin">Admin</option>
					
					<option <?php if($GetManager->role == "Surveyor"): ?> selected <?php endif; ?> value="Surveyor">Surveyor</option>
					
					<option <?php if($GetManager->role == "AccMng"): ?> selected <?php endif; ?> value="AccMng">Account Manager</option>
					<option <?php if($GetManager->role == "Opertional Manager"): ?> selected <?php endif; ?> value="Opertional Manager">Opertional Manager</option>
					<option <?php if($GetManager->role == "Driver"): ?> selected <?php endif; ?> value="Driver">Driver</option>
				</select>
			  </div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Color</label>
				<input type="color" required placeholder="Colors" name="UserColor" value="<?php echo e($GetManager->colour_code); ?>">
			  </div>
			</div>
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Account Name</label>
				<input type="text" class="form-control" name="AccountName" value="<?php echo e($GetManager->account_name); ?>">
			  </div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Insurance Number</label>
				<input type="text" class="form-control" name="NationalInsurance" value="<?php echo e($GetManager->national_insurance); ?>">
			  </div>
			</div>
			
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Address</label>
				<input type="text" class="form-control" name="Address" value="<?php echo e($GetManager->address); ?>">
			  </div>
			</div>
		</div>


		<div class="row">
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Account Short Code</label>
				<input type="text" class="form-control" name="ShortCode" value="<?php echo e($GetManager->sort_code); ?>">
			  </div>
			</div>
			
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Account Number</label>
				<input type="text" class="form-control" name="AccountNumber" value="<?php echo e($GetManager->account_number); ?>">
			  </div>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group">
				<label>Permissions</label>
				<?php
				$GetAllPrm = explode(",", $GetManager->permissions);
				?>
				
				<div><input <?php if(in_array("Personal Move Plan", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Personal Move Plan" id="Perm1"> <label for="Perm1">Personal Move Plan</label></div>
				<div><input <?php if(in_array("Personal Move Plan Request", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Personal Move Plan Request" id="Perm8"> <label for="Perm8">Personal Move Plan Request</label></div>
				<div><input <?php if(in_array("Packing Material", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" type="checkbox" name="Permissions[]" value="Packing Material" id="Perm7"> <label for="Perm7">Packing Material</label></div>
				<div><input <?php if(in_array("Custom Quote", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Custom Quote" id="Perm2"> <label for="Perm2">Custom Quote</label></div>
				<div><input <?php if(in_array("Survey Audio", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Survey Audio" id="Perm9"> <label for="Perm9">Survey Audio</label></div>
				<div><input <?php if(in_array("Live Calendar", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Live Calendar" id="Perm3"> <label for="Perm3">Live Calendar</label></div>
				<div><input <?php if(in_array("Operations Calendar", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Operations Calendar" id="Perm4"> <label for="Perm4">Operations Calendar</label></div>
				<div><input <?php if(in_array("Jobsheet", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Jobsheet" id="Perm10"> <label for="Perm10">Jobsheet</label></div>
				
				<div><input <?php if(in_array("Manage Users", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Manage Users" id="Perm5"> <label for="Perm5">Manage Users</label></div>
				<div><input <?php if(in_array("Manage Vans", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Manage Vans" id="Perm6"> <label for="Perm6">Manage Vans</label></div>
				<div><input <?php if(in_array("Appointment Calendar", $GetAllPrm)): ?> checked <?php endif; ?> type="checkbox" name="Permissions[]" value="Appointment Calendar" id="Perm11"> <label for="Perm11">Appointment Calendar</label></div>
			</div>
		</div>
	</div>
	<?php echo Form::close(); ?>

</body>
</html><?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/AccountManagers/edit.blade.php ENDPATH**/ ?>