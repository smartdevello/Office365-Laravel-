<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<style type="text/css">
table{
	font-size: 0.7rem !important;
}
.form-control, select .form-control{
	font-size: 0.7rem !important;
	padding: 2px !important;
	height: auto !important;
}
</style>
<div class="container-fluid">
	<?php echo $HTML; ?>

</div>

<script>
	DriverCounter = 0;
	function AddNewDriver(id){
		DriverCounter++;
		HTML = "";
		HTML += '<div id="DrvrDiv'+DriverCounter+id+'">';
		HTML += '<div style="float: left; width: 40%">';
		HTML += '<select class="form-control" name="driver[Name][]">';
		HTML += '<option value="">Select</option>';
		<?php $__currentLoopData = $GetAllDriver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $GAD): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			HTML += '<option value="<?php echo e($GAD->id); ?>"><?php echo e($GAD->name); ?></option>';
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		HTML += '</select>';
		HTML += '</div>';
		HTML += '<div style="float: left; width: 40%">';
		HTML += '<input type="number" min="0" name="driver[Salary][]" class="form-control" value="0">';
		HTML += '</div>';
		HTML += '<div onClick="RemoveDriver('+DriverCounter+id+')" style="cursor: pointer; float: left; width: 20%">Remove</div>';
		HTML += '</div>';
		$("#LoadNewDriver"+id).append(HTML);
	}
	
	function RemoveDriver(id){
		$("#DrvrDiv"+id).remove();
	}
	
	function RemoveExtDriver(id){
		$("#ExtDri"+id).remove();
	}
</script>
</body>
</html>
<?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/LiveCalendar.blade.php ENDPATH**/ ?>