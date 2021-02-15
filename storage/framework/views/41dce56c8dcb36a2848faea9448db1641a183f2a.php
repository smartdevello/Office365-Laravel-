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
    <div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="float-left"><h1>Survey Audios</h1></div>
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
	<table id="example" class="table table-bordered table-stripped" style="width:100%">
        <thead>
            <tr>
				<th>Sr. No.</th>
                <th>Job ID</th>
				<th>Name</th>
                <th>Phone Number</th>
				<th>Account Manager</th>
				<th>Date</th>
				<th>Audio</th>
            </tr>
        </thead>
        <tbody>
			<?php
			$SRN = 0;
			?>
			
			<?php $__currentLoopData = $Data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GM): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<?php
			$SRN++;
			$Quote = \App\Model\Quote::where("survey_id", $GM->id)->where("quote_delete", "0")->first();
			$Client = \App\Model\Client::find($GM->client_id);
			?>
            <tr>
				<td><?php echo e($SRN); ?>

                <td><?php echo e($Quote->id); ?></td>
                <td><?php echo e($GM->first_name); ?> <?php echo e($GM->last_name); ?></td>
				<td><?php echo e($GM->phone); ?></td>
				<td><?php echo e($Client->account_manager); ?></td>
				<td><?php echo e(date("d/m/Y H:i:s", strtotime($GM->created_at))); ?></td>
				<td><audio controls><source src="<?php echo e($GM->audio_url); ?>"></audio></td>
            </tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
		</table>
	</div>
	
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#example').DataTable();
	} );
	</script>
</body>
</html><?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/CustomQuote/Audios.blade.php ENDPATH**/ ?>