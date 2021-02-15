<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid">
	<?php if($Message != ""): ?>
	<div class="alert alert-danger">Client ID is Not Present in URL, So Add Appointment Will Not Working</div>
	<?php endif; ?>

	<div class="card">
		<div class="card-body">
			<b>Filter :</b>
			<input checked="" type="radio" name="Filter" value="" onclick="FilterRecord(this.value)"> All &nbsp;&nbsp;
			<input <?php if(@$_GET['filter'] == "20 App in person con"): ?> checked <?php endif; ?> type="radio" name="Filter" value="20 App in person con" onclick="FilterRecord(this.value)"> In - Person &nbsp;&nbsp;
			<input <?php if(@$_GET['filter'] == "20 App online confir,20 App inventorylist"): ?> checked <?php endif; ?> type="radio" name="Filter" value="20 App online confir,20 App inventorylist" onclick="FilterRecord(this.value)"> Online
		</div>
	</div>

	<div>&nbsp;</div>

	<div id="calendar">
		<div class='header'>
			<a class="prev" href="<?php echo e(URL('/')); ?>/appointment-calendar?week=<?php echo e($week-1); ?>&year=<?php echo e($year); ?>&clientID=<?php echo e(@$_GET['clientID']); ?>&filter=<?php echo e(@$_GET['filter']); ?>"><i class="fas fa-chevron-left"></i> Previous</a>
			<a class="next" href="<?php echo e(URL('/')); ?>/appointment-calendar?week=<?php echo e($week+1); ?>&year=<?php echo e($year); ?>&clientID=<?php echo e(@$_GET['clientID']); ?>&filter=<?php echo e(@$_GET['filter']); ?>">Next <i class="fas fa-chevron-right"></i></a>

			<div style='clear:both'></div>
		</div>

		<table class="table table-bordered" style="margin-top: 10px">
			<tr>
				<?php
				$Cntr = 1;
				do {
					echo "<td>" . $dt->format('l') . "<br>" . $dt->format('d M Y') . "</td>";
					$dt->modify('+1 day');
					$Cntr++;
				} while ($Cntr <= 7);
				?>
			</tr>

			<?php for($k = 0; $k <= 48; $k++): ?>
			<?php
			$Mint = $k * 15;
			$Time = date("H:i", strtotime("+".$Mint." minutes", strtotime(date("Y-m-d 08:00:00"))));
			?>

			<tr height="40">
				<td style="position: relative">
					<div data-toggle="modal" data-target="#exampleModal" data-time='<?php echo e(date("H:i", strtotime($Time))); ?>' data-date='<?php echo e($StartDate); ?>' style="position: absolute; top: 0px; right: 0px; width: 30px; height: 30px;"><i class="fas fa-plus-circle"></i>
						<small style="font-size: 10px; position: relative; top: -10px"><?php echo e(date("H:i", strtotime($Time))); ?></small>
					</div>

					<?php
					$GetAppointData = App\Model\Appointment::select("appointment.*", "clients.*", "users.colour_code")->leftjoin("clients", "clients.id", "appointment.appointment_client")->leftjoin("users", "users.name", "clients.account_manager")->where("appointment_date", $StartDate)->where("appointment_time", $Time);

					if(isset($_GET['filter']) && $_GET['filter'] != ""){
						$Arr = explode(",", $_GET['filter']);
						$GetAppointData = $GetAppointData->whereIn("appointment_status", $Arr);
					}

					$GetAppointData = $GetAppointData->get();
					?>

					<?php $__currentLoopData = $GetAppointData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $IN => $GPD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$Left = 0;
					$Height = $GPD->appointment_duration * 40;
					if(isset($Matrix[0][$k][$GPD->appointment_id])){
						$Left = ($Matrix[0][$k][$GPD->appointment_id] -1) * 20;
					}

					$BorderColor = $GPD->colour_code;
					?>
						<div style="border-left: <?php echo e($BorderColor); ?> 4px solid; position: absolute; top: 0px; text-align: center; background: #f1f1f1; height: <?php echo e($Height); ?>px; left: <?php echo e($Left); ?>%; width: 20%; word-break: break-word; font-size: 12px; overflow: hidden;" data-toggle="modal" data-target="#EditModal" data-appointment='<?php echo e(json_encode($GPD)); ?>'>
							<?php echo e(base64_decode($GPD->client)); ?>

						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</td>
				<td style="position: relative">
					<?php
					$SecondDate = date("Y-m-d", strtotime("+1 day", strtotime($StartDate)));
					?>

					<div data-toggle="modal" data-target="#exampleModal" data-time='<?php echo e(date("H:i", strtotime($Time))); ?>' data-date='<?php echo e($SecondDate); ?>' style="position: absolute; top: 0px; right: 0px; width: 30px; height: 30px;"><i class="fas fa-plus-circle"></i>
						<small style="font-size: 10px; position: relative; top: -10px"><?php echo e(date("H:i", strtotime($Time))); ?></small>
					</div>

					<?php
					$GetAppointData = App\Model\Appointment::select("appointment.*", "clients.*", "users.colour_code")->leftjoin("clients", "clients.id", "appointment.appointment_client")->leftjoin("users", "users.name", "clients.account_manager")->where("appointment_date", $SecondDate)->where("appointment_time", $Time);

					if(isset($_GET['filter']) && $_GET['filter'] != ""){
						$Arr = explode(",", $_GET['filter']);
						$GetAppointData = $GetAppointData->whereIn("appointment_status", $Arr);
					}

					$GetAppointData = $GetAppointData->get();
					?>

					<?php $__currentLoopData = $GetAppointData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $IN => $GPD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$Left = 0;
					$Height = $GPD->appointment_duration * 40;
					if(isset($Matrix[1][$k][$GPD->appointment_id])){
						$Left = ($Matrix[1][$k][$GPD->appointment_id] -1) * 20;
					}

					$BorderColor = $GPD->colour_code;
					?>
						<div style="border-left: <?php echo e($BorderColor); ?> 4px solid; position: absolute; top: 0px; text-align: center; background: #f1f1f1; height: <?php echo e($Height); ?>px; left: <?php echo e($Left); ?>%; width: 20%; word-break: break-word; font-size: 12px; overflow: hidden;" data-toggle="modal" data-target="#EditModal" data-appointment='<?php echo e(json_encode($GPD)); ?>'>
							<?php echo e(base64_decode($GPD->client)); ?>

						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</td>
				<td style="position: relative">
					<?php
					$ThirdDate = date("Y-m-d", strtotime("+2 day", strtotime($StartDate)));
					?>

					<div data-toggle="modal" data-target="#exampleModal" data-time='<?php echo e(date("H:i", strtotime($Time))); ?>' data-date='<?php echo e($ThirdDate); ?>' style="position: absolute; top: 0px; right: 0px; width: 30px; height: 30px;"><i class="fas fa-plus-circle"></i>
						<small style="font-size: 10px; position: relative; top: -10px"><?php echo e(date("H:i", strtotime($Time))); ?></small>
					</div>

					<?php
					$GetAppointData = App\Model\Appointment::select("appointment.*", "clients.*", "users.colour_code")->leftjoin("clients", "clients.id", "appointment.appointment_client")->leftjoin("users", "users.name", "clients.account_manager")->where("appointment_date", $ThirdDate)->where("appointment_time", $Time);

					if(isset($_GET['filter']) && $_GET['filter'] != ""){
						$Arr = explode(",", $_GET['filter']);
						$GetAppointData = $GetAppointData->whereIn("appointment_status", $Arr);
					}

					$GetAppointData = $GetAppointData->get();
					?>

					<?php $__currentLoopData = $GetAppointData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $IN => $GPD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$Left = 0;
					$Height = $GPD->appointment_duration * 40;
					if(isset($Matrix[2][$k][$GPD->appointment_id])){
						$Left = ($Matrix[2][$k][$GPD->appointment_id] -1) * 20;
					}

					$BorderColor = $GPD->colour_code;
					?>
						<div style="border-left: <?php echo e($BorderColor); ?> 4px solid; position: absolute; top: 0px; text-align: center; background: #f1f1f1; height: <?php echo e($Height); ?>px; left: <?php echo e($Left); ?>%; width: 20%; word-break: break-word; font-size: 12px; overflow: hidden;" data-toggle="modal" data-target="#EditModal" data-appointment='<?php echo e(json_encode($GPD)); ?>'>
							<?php echo e(base64_decode($GPD->client)); ?>

						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</td>
				<td style="position: relative">
					<?php
					$FourthDate = date("Y-m-d", strtotime("+3 day", strtotime($StartDate)));
					?>

					<div data-toggle="modal" data-target="#exampleModal" data-time='<?php echo e(date("H:i", strtotime($Time))); ?>' data-date='<?php echo e($FourthDate); ?>' style="position: absolute; top: 0px; right: 0px; width: 30px; height: 30px;"><i class="fas fa-plus-circle"></i>
						<small style="font-size: 10px; position: relative; top: -10px"><?php echo e(date("H:i", strtotime($Time))); ?></small>
					</div>

					<?php
					$GetAppointData = App\Model\Appointment::select("appointment.*", "clients.*", "users.colour_code")->leftjoin("clients", "clients.id", "appointment.appointment_client")->leftjoin("users", "users.name", "clients.account_manager")->where("appointment_date", $FourthDate)->where("appointment_time", $Time);

					if(isset($_GET['filter']) && $_GET['filter'] != ""){
						$Arr = explode(",", $_GET['filter']);
						$GetAppointData = $GetAppointData->whereIn("appointment_status", $Arr);
					}

					$GetAppointData = $GetAppointData->get();
					?>

					<?php $__currentLoopData = $GetAppointData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $IN => $GPD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$Left = 0;
					$Height = $GPD->appointment_duration * 40;
					if(isset($Matrix[3][$k][$GPD->appointment_id])){
						$Left = ($Matrix[3][$k][$GPD->appointment_id] -1) * 20;
					}

					$BorderColor = $GPD->colour_code;
					?>
						<div style="border-left: <?php echo e($BorderColor); ?> 4px solid; position: absolute; top: 0px; text-align: center; background: #f1f1f1; height: <?php echo e($Height); ?>px; left: <?php echo e($Left); ?>%; width: 20%; word-break: break-word; font-size: 12px; overflow: hidden;" data-toggle="modal" data-target="#EditModal" data-appointment='<?php echo e(json_encode($GPD)); ?>'>
							<?php echo e(base64_decode($GPD->client)); ?>

						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</td>
				<td style="position: relative">
					<?php
					$FifthDate = date("Y-m-d", strtotime("+4 day", strtotime($StartDate)));
					?>

					<div data-toggle="modal" data-target="#exampleModal" data-time='<?php echo e(date("H:i", strtotime($Time))); ?>' data-date='<?php echo e($FifthDate); ?>' style="position: absolute; top: 0px; right: 0px; width: 30px; height: 30px;"><i class="fas fa-plus-circle"></i>
						<small style="font-size: 10px; position: relative; top: -10px"><?php echo e(date("H:i", strtotime($Time))); ?></small>
					</div>

					<?php
					$GetAppointData = App\Model\Appointment::select("appointment.*", "clients.*", "users.colour_code")->leftjoin("clients", "clients.id", "appointment.appointment_client")->leftjoin("users", "users.name", "clients.account_manager")->where("appointment_date", $FifthDate)->where("appointment_time", $Time);

					if(isset($_GET['filter']) && $_GET['filter'] != ""){
						$Arr = explode(",", $_GET['filter']);
						$GetAppointData = $GetAppointData->whereIn("appointment_status", $Arr);
					}

					$GetAppointData = $GetAppointData->get();
					?>

					<?php $__currentLoopData = $GetAppointData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $IN => $GPD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$Left = 0;
					$Height = $GPD->appointment_duration * 40;
					if(isset($Matrix[4][$k][$GPD->appointment_id])){
						$Left = ($Matrix[4][$k][$GPD->appointment_id] -1) * 20;
					}

					$BorderColor = $GPD->colour_code;
					?>
						<div style="border-left: <?php echo e($BorderColor); ?> 4px solid; position: absolute; top: 0px; text-align: center; background: #f1f1f1; height: <?php echo e($Height); ?>px; left: <?php echo e($Left); ?>%; width: 20%; word-break: break-word; font-size: 12px; overflow: hidden;" data-toggle="modal" data-target="#EditModal" data-appointment='<?php echo e(json_encode($GPD)); ?>'>
							<?php echo e(base64_decode($GPD->client)); ?>

						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</td>
				<td style="position: relative">
					<?php
					$SixthDate = date("Y-m-d", strtotime("+5 day", strtotime($StartDate)));
					?>

					<div data-toggle="modal" data-target="#exampleModal" data-time='<?php echo e(date("H:i", strtotime($Time))); ?>' data-date='<?php echo e($SixthDate); ?>' style="position: absolute; top: 0px; right: 0px; width: 30px; height: 30px;"><i class="fas fa-plus-circle"></i>
						<small style="font-size: 10px; position: relative; top: -10px"><?php echo e(date("H:i", strtotime($Time))); ?></small>
					</div>

					<?php
					$GetAppointData = App\Model\Appointment::select("appointment.*", "clients.*", "users.colour_code")->leftjoin("clients", "clients.id", "appointment.appointment_client")->leftjoin("users", "users.name", "clients.account_manager")->where("appointment_date", $SixthDate)->where("appointment_time", $Time);

					if(isset($_GET['filter']) && $_GET['filter'] != ""){
						$Arr = explode(",", $_GET['filter']);
						$GetAppointData = $GetAppointData->whereIn("appointment_status", $Arr);
					}

					$GetAppointData = $GetAppointData->get();
					?>

					<?php $__currentLoopData = $GetAppointData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $IN => $GPD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$Left = 0;
					$Height = $GPD->appointment_duration * 40;
					if(isset($Matrix[5][$k][$GPD->appointment_id])){
						$Left = ($Matrix[5][$k][$GPD->appointment_id] -1) * 20;
					}

					$BorderColor = $GPD->colour_code;
					?>
						<div style="border-left: <?php echo e($BorderColor); ?> 4px solid; position: absolute; top: 0px; text-align: center; background: #f1f1f1; height: <?php echo e($Height); ?>px; left: <?php echo e($Left); ?>%; width: 20%; word-break: break-word; font-size: 12px; overflow: hidden;" data-toggle="modal" data-target="#EditModal" data-appointment='<?php echo e(json_encode($GPD)); ?>'>
							<?php echo e(base64_decode($GPD->client)); ?>

						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</td>
				<td style="position: relative">
					<?php
					$SeventhDate = date("Y-m-d", strtotime("+6 day", strtotime($StartDate)));
					?>

					<div data-toggle="modal" data-target="#exampleModal" data-time='<?php echo e(date("H:i", strtotime($Time))); ?>' data-date='<?php echo e($SeventhDate); ?>' style="position: absolute; top: 0px; right: 0px; width: 30px; height: 30px;"><i class="fas fa-plus-circle"></i>
						<small style="font-size: 10px; position: relative; top: -10px"><?php echo e(date("H:i", strtotime($Time))); ?></small>
					</div>

					<?php
					$GetAppointData = App\Model\Appointment::select("appointment.*", "clients.*", "users.colour_code")->leftjoin("clients", "clients.id", "appointment.appointment_client")->leftjoin("users", "users.name", "clients.account_manager")->where("appointment_date", $SeventhDate)->where("appointment_time", $Time);

					if(isset($_GET['filter']) && $_GET['filter'] != ""){
						$Arr = explode(",", $_GET['filter']);
						$GetAppointData = $GetAppointData->whereIn("appointment_status", $Arr);
					}

					$GetAppointData = $GetAppointData->get();
					?>

					<?php $__currentLoopData = $GetAppointData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $IN => $GPD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					$Left = 0;
					$Height = $GPD->appointment_duration * 40;
					if(isset($Matrix[6][$k][$GPD->appointment_id])){
						$Left = ($Matrix[6][$k][$GPD->appointment_id] -1) * 20;
					}

					$BorderColor = $GPD->colour_code;
					?>
						<div style="border-left: <?php echo e($BorderColor); ?> 4px solid; position: absolute; top: 0px; text-align: center; background: #f1f1f1; height: <?php echo e($Height); ?>px; left: <?php echo e($Left); ?>%; width: 20%; word-break: break-word; font-size: 12px; overflow: hidden;" data-toggle="modal" data-target="#EditModal" data-appointment='<?php echo e(json_encode($GPD)); ?>'>
							<?php echo e(base64_decode($GPD->client)); ?>

						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</td>
			<tr>
			<?php endfor; ?>
		</table>
	</div>
</div>


<?php if(isset($ClientData)): ?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo Form::open(['url'=>'SaveAppointment', 'enctype' => 'multipart/form-data', 'method'=>'post']); ?>

      <input type="hidden" name="AppointmentCliendID" value="<?php echo e($CliendID); ?>">
      <input type="hidden" name="week" value="<?php echo e(@$_GET['week']); ?>">
      <input type="hidden" name="year" value="<?php echo e(@$_GET['year']); ?>">
      <input type="hidden" name="filter" value="<?php echo e(@$_GET['filter']); ?>">

      <div class="modal-body">
      	<div class="row">
      		<div class="col-6">
		      	<div class="row">
		      		<div class="col-6">
				      	<div>
					        <label for="recipient-name" class="col-form-label">Name:</label>
					        <input type="text" class="form-control" name="ClientName" value="<?php echo e(base64_decode($ClientData->client)); ?>">
					     </div>
					 </div>
					 <div class="col-6">
					    <div>
					        <label for="recipient-name" class="col-form-label">Status:</label>
					        <select type="text" class="form-control" name="ClientStatus" onChange="UpdateAccManager(this.value)">
					        	<option>20 App in person con</option> 
					        	<option>20 App online confir</option>
					        	<option>20 App inventorylist</option>
					        </select>
					     </div>
					 </div>
				</div>

				<script type="text/javascript">
					function UpdateAccManager(val){
						if(val == "20 App in person con"){
							$("#AccMngAdd").val("Group Survey In-person");
						}

						if(val == "20 App online confir"){
							$("#AccMngAdd").val("Group Survey Online");
						}

						if(val == "20 App inventorylist"){
							$("#AccMngAdd").val("Group Survey Online");
						}
					}
				</script>

				<div class="row">
					<div class="col-6">
					     <div>
					        <label for="recipient-name" class="col-form-label">Account Manager:</label>
					        <select type="text" class="form-control" name="ClientAccMngr" id="AccMngAdd" disabled="">
					        	<option>Group Survey In-person</option>
					        	<option>Group Survey Online</option>
					        </select>
					     </div>
					 </div>

					 <div class="col-6">
					     <div>
					        <label for="recipient-name" class="col-form-label">Building:</label>
					        <input type="text" class="form-control" name="ClientBuilding" value="<?php echo e($ClientData->property); ?>">
					     </div>
					 </div>
				</div>

				<div class="row">
					<div class="col-6">
				          <div>
				            <label for="recipient-name" class="col-form-label">Time:</label>
				            <input type="time" class="form-control" id="AppointmentTime" name="AppointmentTime">
				          </div>
			      	</div>
			      	<div class="col-6">
				          <div>
				            <label for="recipient-name" class="col-form-label">Date:</label>
				            <input type="date" class="form-control" id="AppointmentDate" name="AppointmentDate">
				          </div>
				      </div>
				</div>


				
	          <div class="form-group">
	            <label class="col-form-label"><b>Duration:</b></label>
	            <input type="radio" name="AppointmentDuration" checked="" value="1" id="ApntDur1"> <label for="ApntDur1">15 Min</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentDuration" value="2" id="ApntDur2"> <label for="ApntDur2">30 Min</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentDuration" value="3" id="ApntDur3"> <label for="ApntDur3">45 Min</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentDuration" value="4" id="ApntDur4"> <label for="ApntDur4">60 Min</label>
	          </div>
	    
	          <div class="form-group">
	            <label class="col-form-label"><b>Medium:</b></label>
	            <input type="radio" name="AppointmentMedium" checked="" value="Whatsapp" id="ApntMdm1"> <label for="ApntMdm1">Whatsapp</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentMedium" value="Facetime" id="ApntMdm2"> <label for="ApntMdm2">Facetime</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentMedium" value="Zoom" id="ApntMdm3"> <label for="ApntMdm3">Zoom</label>
	          </div>
			</div>
			<div class="col-6">
	          <div class="form-group">
		        <label for="recipient-name" class="col-form-label">Pickup Address:</label>
		        <input type="text" class="form-control" name="ClientPickup" id="ClientPickup" onblur="ChangeAddress()" value="<?php echo e(base64_decode($ClientData->address)); ?>">
		     </div>

		     <div id="map" style="height: 250px;"></div>
		 </div>
	    </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Book</button>
      </div>
      <?php echo Form::close(); ?>

    </div>
  </div>
</div>
<?php endif; ?>



<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Appointment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo Form::open(['url'=>'SaveAppointment', 'enctype' => 'multipart/form-data', 'method'=>'post']); ?>

      <input type="hidden" name="week" value="<?php echo e(@$_GET['week']); ?>">
      <input type="hidden" name="year" value="<?php echo e(@$_GET['year']); ?>">
      <input type="hidden" name="filter" value="<?php echo e(@$_GET['filter']); ?>">

      <div class="modal-body" id="EditApointment">
      	<input type="hidden" name="AppointmentCliendID" v-model="AppointmentCliendID">
      	<input type="hidden" name="AppointmentID" v-model="AppointmentID">

      	<div class="row">
      		<div class="col-6">

      			<div class="row">
      				<div class="col-6">
		      			<div>
			        <label for="recipient-name" class="col-form-label">Name:</label>
			        <input type="text" class="form-control" name="ClientName" v-model="ClientName">
			     </div>
			 		</div>

			 		<div class="col-6">
					    <div>
					        <label for="recipient-name" class="col-form-label">Status:</label>
					        <select type="text" class="form-control" name="ClientStatus" v-model="ClientStatus" @change="UpdateAccMng()">
					        	<option>20 App in person con</option>
					        	<option>20 App online confir</option>
					        	<option>20 App inventorylist</option>
					        </select>
					    </div>
					</div>
				</div>

				<div class="row">
      				<div class="col-6">
					    <div>
					        <label for="recipient-name" class="col-form-label">Account Manager:</label>
					        <select type="text" class="form-control" name="ClientAccMngr" v-model="ClientAccMngr" disabled="">
					        	<option>Group Survey In-person</option>
					        	<option>Group Survey Online</option>
					        </select>
					    </div>
					</div>

					<div class="col-6">
					    <div>
					        <label for="recipient-name" class="col-form-label">Building:</label>
					        <input type="text" class="form-control" name="ClientBuilding" v-model="ClientBuilding">
					    </div>
					</div>
				</div>

				<div class="row">
      				<div class="col-6">
				        <div>
				            <label for="recipient-name" class="col-form-label">Time:</label>
				            <input type="time" class="form-control" v-model="AppointmentTime" name="AppointmentTime">
				        </div>
				    </div>

				    <div class="col-6">
				        <div>
				            <label for="recipient-name" class="col-form-label">Date:</label>
				            <input type="date" class="form-control" v-model="AppointmentDate" name="AppointmentDate">
				        </div>
				    </div>
				</div>

				<div class="form-group">
	            <label class="col-form-label"><b>Duration:</b></label>
	            <input type="radio" name="AppointmentDuration" v-model="AppointmentDuration" checked="" value="1" id="ApntDur11"> <label for="ApntDur11">15 Min</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentDuration" v-model="AppointmentDuration" value="2" id="ApntDur21"> <label for="ApntDur21">30 Min</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentDuration" v-model="AppointmentDuration" value="3" id="ApntDur31"> <label for="ApntDur31">45 Min</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentDuration" v-model="AppointmentDuration" value="4" id="ApntDur41"> <label for="ApntDur41">60 Min</label>
	          </div>
	    
	          <div class="form-group">
	            <label class="col-form-label"><b>Medium:</b></label>
	            <input type="radio" name="AppointmentMedium" checked="" v-model="AppointmentMedium" value="Whatsapp" id="ApntMdm11"> <label for="ApntMdm11">Whatsapp</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentMedium" value="Facetime" v-model="AppointmentMedium" id="ApntMdm21"> <label for="ApntMdm21">Facetime</label> &nbsp; &nbsp;
	            <input type="radio" name="AppointmentMedium" value="Zoom" v-model="AppointmentMedium" id="ApntMdm31"> <label for="ApntMdm31">Zoom</label>
	          </div>
		    </div>

		    <div class="col-6">
		        <div class="form-group">
			        <label for="recipient-name" class="col-form-label">Pickup Address:</label>
			        <input type="text" class="form-control" name="ClientPickup" v-model="ClientPickup1" v-on:blur="updateMap()" id="ClientPickup1">
			    </div>

			     <div id="map1" style="height: 250px;"></div>
			</div>
		</div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
      <?php echo Form::close(); ?>

    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script type="text/javascript">
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  $('#AppointmentTime').val(button.data('time'))
  $('#AppointmentDate').val(button.data('date'))
})

$('#EditModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  Appnt = button.data('appointment');

  EditAppointment.AppointmentID = Appnt.appointment_id;
  EditAppointment.ClientName = atob(Appnt.client);
  EditAppointment.ClientStatus = Appnt.appointment_status;
  EditAppointment.ClientAccMngr = Appnt.account_manager;
  EditAppointment.ClientBuilding = Appnt.property;
  EditAppointment.AppointmentTime = Appnt.appointment_time;
  EditAppointment.AppointmentDate = Appnt.appointment_date;
  EditAppointment.AppointmentDuration = Appnt.appointment_duration;
  EditAppointment.AppointmentMedium = Appnt.medium;
  EditAppointment.ClientPickup1 = atob(Appnt.address);
  EditAppointment.AppointmentCliendID = Appnt.appointment_client

  DecodeAddress1(atob(Appnt.address))
})

var EditAppointment = new Vue({
    el: "#EditApointment",
    delimiters: ['!{', '}!'],
    data: {
        AppointmentID: 0,
        ClientName: "",
        ClientAccMngr: "",
        ClientStatus: "",
        ClientBuilding: "",
        AppointmentTime: "",
        AppointmentDate: "",
        AppointmentDuration: "",
        AppointmentMedium: "",
        ClientPickup1: "",
        AppointmentCliendID: ""
    },
    methods:{
		UpdateAccMng: function(){
			if(this.ClientStatus == "20 App in person con"){
				this.ClientAccMngr = "Group Survey In-person";
			}

			if(this.ClientStatus == "20 App online confir"){
				this.ClientAccMngr = "Group Survey Online";
			}

			if(this.ClientStatus == "20 App inventorylist"){
				this.ClientAccMngr = "Group Survey Online";
			}
		},
		updateMap:function(){
			DecodeAddress1(this.ClientPickup1);
		}
	}
});
</script>

<script type="text/javascript">
var geocoder;
var map;
var map1;
var MapMarker;
function initMap() {
	geocoder = new google.maps.Geocoder();

	<?php if(isset($ClientData)): ?>
	const uluru = { lat: -25.344, lng: 131.036 };
	map = new google.maps.Map(document.getElementById("map"), {zoom: 8,center: uluru});
	var address = "<?php echo e(base64_decode($ClientData->address)); ?>";
	DecodeAddress(address);
	<?php endif; ?>

	initMap1()
}

function initMap1() {
	const uluru = { lat: -25.344, lng: 131.036 };
	map1 = new google.maps.Map(document.getElementById("map1"), {zoom: 8,center: uluru});
}

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
    	$("#ClientPickup").val(responses[0].formatted_address)
    	$("#ClientPickup1").val(responses[0].formatted_address)
    }
  });
}



<?php if(isset($ClientData)): ?>
function DecodeAddress(address){
	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == 'OK') {
	    map.setCenter(results[0].geometry.location);

	    if(MapMarker != null){
		    MapMarker.setMap(null)
		}
	    MapMarker = new google.maps.Marker({map: map, position: results[0].geometry.location, draggable:true});
	    MapMarker.addListener('dragend', function() {
			console.log('Drag ended');
			geocodePosition(MapMarker.getPosition());
		});
	  } else {
	    alert('Geocode was not successful for the following reason: ' + status);
	  }
	});
}
<?php endif; ?>


function DecodeAddress1(Address){
	var address = Address;
	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == 'OK') {
	  	console.log(results);
	    map1.setCenter(results[0].geometry.location);
	    
	    if(MapMarker != null){
		    MapMarker.setMap(null)
		}
		
	    MapMarker = new google.maps.Marker({map: map1, position: results[0].geometry.location, draggable:true});
	    MapMarker.addListener('dragend', function() {
			console.log('Drag ended');
			geocodePosition(MapMarker.getPosition());
		});
	  } else {
	    alert('Geocode was not successful for the following reason: ' + status);
	  }
	});
}

function ChangeAddress(){
	DecodeAddress($("#ClientPickup").val());
}

function FilterRecord(val){
	window.location = "<?php echo e(URL('appointment-calendar')); ?>?week=<?php echo e(@$_GET['week']); ?>&year=<?php echo e(@$_GET['year']); ?>&clientID=<?php echo e(@$_GET['clientID']); ?>&filter="+val;
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXGXDXrvcv8hNOcR4TZ3rZyCcdMbNSD70&callback=initMap&libraries=&v=weekly"></script>
</body>
</html>
<?php /**PATH /opt/lampp/htdocs/corner/resources/views/appointment-calendar.blade.php ENDPATH**/ ?>