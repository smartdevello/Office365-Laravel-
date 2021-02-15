<!DOCTYPE html>
<html>
<head>
    <title>Personal Move Plan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div id="myModal" class="modal fade show" aria-modal="true" style="display: block;">
	<div class="modal-dialog modal-login">
		<div class="modal-content">
			<div class="modal-header">				
				<h4 class="modal-title">Fill Up Your Information</h4>
			</div>
			<div class="modal-body">
				<?php if(Session::has('Danger')): ?>
  <div class="alert alert-danger" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text"><?php echo Session::get('Danger'); ?></div>
  </div>
  <?php endif; ?>
				<?php echo Form::open(['url' => 'ValidateClient', 'method' => 'post']); ?>

				<input type="hidden" name="SurveyID" value="<?php echo e($SurveyID); ?>">
				<input type="hidden" name="QuoteID" value="<?php echo e($QuoteID); ?>">
					<div class="form-group">
						<label>Registered Email</label>
						<input type="text" class="form-control" name="Email" required="required">
					</div>
				
					<div class="form-group">
						<label>First Name</label>
						<input type="text" class="form-control" name="From" required="required">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block btn-lg">Validate</button>
					</div>
				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>
	</body>
</html><?php /**PATH /opt/lampp/htdocs/corner/resources/views/ValidateClient.blade.php ENDPATH**/ ?>