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
				<h4 class="modal-title">Sign In</h4>
			</div>
			<div class="modal-body">
				<?php if(Session::has('Danger')): ?>
  <div class="alert alert-danger" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text"><?php echo Session::get('Danger'); ?></div>
  </div>
  <?php endif; ?>
				<?php echo Form::open(['url' => 'DoLogin', 'method' => 'post']); ?>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" name="LoginEmail" placeholder="Username" required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control" name="LoginPassword" placeholder="Password" required="required">
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
					</div>
				<?php echo Form::close(); ?>

			</div>
		</div>
	</div>
</div>
	</body>
</html><?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/login.blade.php ENDPATH**/ ?>