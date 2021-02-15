@include("header")
	{!! Form::open(['url' => 'AccountManager/SaveAdd', 'method' => 'post']) !!}
	<div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="float-left"><h1>Add Account Managers</h1></div>
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
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Color</label>
				<input type="color" required placeholder="Colors" name="UserColor">
			  </div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Insurance Number</label>
				<input type="text" class="form-control" name="NationalInsurance">
			  </div>
			</div>
			
			<div class="col-lg-6">
			  <div class="form-group">
				<label>Address</label>
				<input type="text" class="form-control" name="Address">
			  </div>
			</div>
		</div>


		<div class="row">
			<div class="col-lg-4">
			  <div class="form-group">
				<label>Account Sort Code</label>
				<input type="text" class="form-control" name="ShortCode">
			  </div>
			</div>
			<div class="col-lg-4">
			  <div class="form-group">
				<label>Account Name</label>
				<input type="text" class="form-control" name="AccountName">
			  </div>
			</div>
			<div class="col-lg-4">
			  <div class="form-group">
				<label>Account Number</label>
				<input type="text" class="form-control" name="AccountNumber">
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

				<div><input type="checkbox" name="Permissions[]" value="Appointment Calendar" id="Perm11"> <label for="Perm11">Appointment Calendar</label></div>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
</body>
</html>