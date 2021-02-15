
	<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
    <div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="float-left"><h1>Account Managers</h1></div>
		<div class="float-right">
			<a href="<?php echo e(URL('AccountManager/Add')); ?>"><button class="btn btn-info">Add New</button></a>
		</div>
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
                <th>Name</th>
                <th>User Name</th>
				<th>Privilege</th>
				<th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
			<?php $__currentLoopData = $GetManager; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GM): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($GM->name); ?></td>
                <td><?php echo e($GM->user); ?></td>
				<td>
					<?php
					$EmpPrm = explode(",", $GM->permissions);
					?>
					
					<?php $__currentLoopData = $EmpPrm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $PM): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php echo e($PM); ?><br>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
				</td>
				<td><?php echo e($GM->role); ?></td>
                <td>
					<a href="<?php echo e(URL('AccountManager/Edit')); ?>/<?php echo e($GM->id); ?>">Edit</a> |
					<a onClick="return ConfrmDelete()" href="<?php echo e(URL('AccountManager/Delete')); ?>/<?php echo e($GM->id); ?>">Delete</a>
				</td>
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
		
		function ConfrmDelete(){
			if(confirm('Are You Sure to Delete this Record')){
				return true
			}
			return false
		}
	</script>
</body>
</html><?php /**PATH /opt/lampp/htdocs/corner/resources/views/AccountManagers/view.blade.php ENDPATH**/ ?>