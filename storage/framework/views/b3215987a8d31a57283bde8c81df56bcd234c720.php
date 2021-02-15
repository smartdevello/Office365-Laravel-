<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container">
	<div class="float-left"><h1>Driver Salary</h1></div>
	<div class="clearfix">&nbsp;</div>
	
	<?php if(Session::has('Success')): ?>
	<div class="alert alert-success" role="alert">
		<div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
		<div class="alert-text"><?php echo Session::get('Success'); ?></div>
	</div>
	<?php endif; ?>
	
	<?php if(Session::has('Danger')): ?>
	<div class="alert alert-danger" role="alert">
		<div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
		<div class="alert-text"><?php echo Session::get('Danger'); ?></div>
	</div>
	<?php endif; ?>
	
	<div class="clearfix">&nbsp;</div>

	<div class="card">
		<div class="card-body">
			<form>
				<div style="margin-right: 10px; margin-top: 5px;" class="float-left"><b>Date</b></div>
				<div style="margin-right: 10px;"  class="float-left"><input name="FromDate" required="" value="<?php echo e(@$_GET['FromDate']); ?>" type="date" name="" class="form-control"></div>
				<div style="margin-right: 10px;" class="float-left"><input name="ToDate" required="" value="<?php echo e(@$_GET['ToDate']); ?>" type="date" name="" class="form-control"></div>
				<div class="float-left"><button class="btn btn-success">Fetch</button></div>
			</form>
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>

	<div class="row">
		<div class="col-3">
			<?php $__currentLoopData = $GetAllJob; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GJ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="card" style="margin-bottom: 5px;">
					<div class="card-body"><a href="<?php echo e(URL('driver-salary')); ?>?FromDate=<?php echo e($_GET['FromDate']); ?>&ToDate=<?php echo e($_GET['ToDate']); ?>&ID=<?php echo e($GJ['id']); ?>"><?php echo e($GJ["name"]); ?></a></div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>

		<div class="col-9">
			<div class="card">
				<div class="card-body">
					<table class="table table-bordered table-stripped">
						<thead>
							<tr>
								<th>Date</th>
								<th>Pickup Address</th>
								<th>Income</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$Total = 0;
							?>

							<?php $__currentLoopData = $GetAllIncome; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GAI): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
							$Total += $GAI->driver_job_salary;
							$PickupAdd = "";

							if($GAI->driver_job_type == 0){
								$GT = App\Model\PackingJob::leftjoin("quotes", "quotes.id", "packing_job.packing_job_quote_id")->find($GAI->main_job_id);
								$PickupAdd = $GT->pickup_postcode;
							}

							if($GAI->driver_job_type == 1){
								$GT = App\Model\MovingJob::leftjoin("quotes", "quotes.id", "moving_job.moving_job_quote")->find($GAI->main_job_id);
								$PickupAdd = $GT->pickup_postcode;
							}
							?>

							<tr>
								<td><?php echo e(date("d F, Y", strtotime($GAI->driver_job_date))); ?></td>
								<td><?php echo e($PickupAdd); ?></td>
								<td style="text-align: right;"><?php echo e(number_format($GAI->driver_job_salary, 2)); ?></td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
						<tfoot>
							<tr>
								<th style="text-align: right;" colspan="2">Total</th>
								<th style="text-align: right;"><?php echo e(number_format($Total, 2)); ?></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/Salary/DriverSalary.blade.php ENDPATH**/ ?>