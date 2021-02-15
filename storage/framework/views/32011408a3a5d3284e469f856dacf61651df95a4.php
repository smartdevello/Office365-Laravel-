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
				<a href="<?php echo e(URL('driver-salary')); ?>?FromDate=<?php echo e($_GET['FromDate']); ?>&ToDate=<?php echo e($_GET['ToDate']); ?>&ID=<?php echo e($GJ['id']); ?>" style="text-decoration: none;">
					<div class="card" style="margin-bottom: 5px; background: #033d67; color: #FFF;">
						<div class="card-body"><?php echo e($GJ["name"]); ?></div>
					</div>
				</a>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>

		<div class="col-9">
			<?php if(isset($_GET['ID'])): ?>
			<div class="card">
				<div class="card-body">
					<div class="float-left"><h4><?php echo e($GetDriverData->name); ?></h4></div>
					<div class="float-right"><a href="<?php echo e(URL('pdf-salary')); ?>?FromDate=<?php echo e($_GET['FromDate']); ?>&ToDate=<?php echo e($_GET['ToDate']); ?>&ID=<?php echo e($_GET['ID']); ?>"><button class="btn btn-info">Generate PDF</button></a></div>
					<div class="clearfix"></div>
					<hr>
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

					<div class="float-right"><button data-toggle="modal" data-target="#exampleModal" class="btn btn-danger">Add Expenses</button></div>

					<div class="clearfix">&nbsp;</div>
					<div class="clearfix">&nbsp;</div>
					<table class="table table-stripped table-bordered">
						<thead>
							<tr>
								<td>Sr. No.</td>
								<td>Date</td>
								<td>Description</td>
								<td>Amount</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php
							$ExpnTotal = 0;
							?>

							<?php $__currentLoopData = $GetAllExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $SRN => $GAE): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
							$ExpnTotal += $GAE->expenses_amont;
							?>
							<tr>
								<td><?php echo e($SRN + 1); ?></td>
								<td><?php echo e(date("d F, Y", strtotime($GAE->expenses_date))); ?></td>
								<td><?php echo e($GAE->expenses_desp); ?></td>
								<td style="text-align: right;"><?php echo e(number_format($GAE->expenses_amont, 2)); ?></td>
								<td>
									<a href="#" data-toggle="modal" data-target="#EditModal" data-appointment='<?php echo e(json_encode($GAE)); ?>'>Edit</a> | <a onclick="return Conf()" href="<?php echo e(URL('ExpensesDelete')); ?>/<?php echo e($GAE->expenses_id); ?>">Delete</a>
								</td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
						<tfoot>
							<tr>
								<th style="text-align: right;" colspan="3">Total</th>
								<th style="text-align: right;"><?php echo e(number_format($ExpnTotal, 2)); ?></th>
								<th></th>
							</tr>
						</tfoot>
					</table>

					<div class="text-right"><h3>Grand Total : <?php echo e(number_format($Total + $ExpnTotal, 2)); ?></h3> </div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Expenses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo Form::open(['url' => 'SaveExpenses', 'method' => 'post']); ?>

      <input type="hidden" name="Driver" value="<?php echo e(@$_GET['ID']); ?>">
      <div class="modal-body">
        	<div class="form-group">
        		<label>Date</label>
				<input type="date" class="form-control" name="ExpensesDate" required="">
			</div>

			<div class="form-group">
        		<label>Description</label>
				<textarea class="form-control" name="ExpensesDesp"></textarea>
			</div>

			<div class="form-group">
        		<label>Amount</label>
				<input type="number" class="form-control" name="ExpensesAmount" required="" value="0">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      <?php echo Form::close(); ?>

    </div>
  </div>
</div>


<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Expenses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo Form::open(['url' => 'EditExpenses', 'method' => 'post']); ?>

      <div class="modal-body" id="EditApointment">
      		<input type="hidden" name="ExpenseID" v-model="ExpenseID">
        	<div class="form-group">
        		<label>Date</label>
				<input type="date" class="form-control" name="ExpensesDate" v-model="ExpensesDate" required="">
			</div>

			<div class="form-group">
        		<label>Description</label>
				<textarea class="form-control" name="ExpensesDesp" v-model="ExpensesDesp"></textarea>
			</div>

			<div class="form-group">
        		<label>Amount</label>
				<input type="number" class="form-control" name="ExpensesAmount" v-model="ExpensesAmount" required="" value="0">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      <?php echo Form::close(); ?>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script type="text/javascript">
	function Conf(){
		if(confirm("Are You Sure to Delete This Record")){
			return true;
		}

		return false;
	}

$('#EditModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  Appnt = button.data('appointment');

  console.log(Appnt);

  EditAppointment.ExpenseID = Appnt.expenses_id;
  EditAppointment.ExpensesDate = Appnt.expenses_date;
  EditAppointment.ExpensesDesp = Appnt.expenses_desp;
  EditAppointment.ExpensesAmount = Appnt.expenses_amont;
})

var EditAppointment = new Vue({
    el: "#EditApointment",
    delimiters: ['!{', '}!'],
    data: {
        ExpenseID: 0,
        ExpensesDate: "",
        ExpensesDesp: "",
        ExpensesAmount: "",
    },
});
</script>
</body>
</html>
<?php /**PATH /opt/lampp/htdocs/corner/resources/views/Salary/DriverSalary.blade.php ENDPATH**/ ?>