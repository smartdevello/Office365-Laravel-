<!DOCTYPE html>
<html>
<head>
    <title>Clinet View</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

    <link rel="stylesheet" href="<?php echo e(URL('public/style.css')); ?>"/>
</head>
<body>
<div class="clearfix">&nbsp;</div>
<div class="container">
	<img src="<?php echo e(URL('public/header.jpeg')); ?>" style="width:100%">
    <div class="clearfix">&nbsp;</div>
	
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link" href="<?php echo e(URL('DriverQuote')); ?>?id=<?php echo e($_GET['survey']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>">Move Plan</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" href="#">Jobsheet</a>
		</li>
	</ul>
	
	<h1 style="text-align: center">Jobsheet</h1>
	<h5 style="text-align: center">Listing ID: <?php echo e($Quote->id); ?> - <?php echo e($Quote->pickup_building); ?></h5>
	<div>&nbsp;</div>
	<p><b>Job Date:</b> <?php echo e(date("d F, Y", strtotime($Quote->moving_date))); ?></p>
	<p><b>Client Name:</b> <?php echo e($CleintName); ?></p>
	<p><b>Phone Number:</b> <?php echo e($GetClient->mobile); ?></p>
	
	<div >&nbsp;</div>
	<h5><b>Inventory / Notes / Special Requirement</b></h5>
	<p>6 wardrobes boxes Medium 20</p>
	
	<div>&nbsp;</div>
	<h5><b>Check in / check out documentation</b></h5>
	<b>Liability Waiver Form</b>
	<p>By Signing the waiver form you agree that our liability is waivered, in the event of something being damaged, as a  result of the being moved.</p>
	<div style="border: #000 1px solid; padding: 10px;">
		<div class="float-left"><?php echo e($CleintName); ?></div>
		<?php if($Quote->sign_waiver != ""): ?>
		<div class="float-right"><img src="<?php echo e(URL('public/sign')); ?>/<?php echo e($Quote->sign_waiver); ?>?date=<?php echo e(date('Y-m-d h:i:s')); ?>" width="100"></div>
		<?php endif; ?>
		<div class="clearfix"></div>
	</div>
	
	<button data-toggle="modal" data-target="#exampleModal" onClick="SignType('Liability')" class="btn btn-primary">Sign Liability Waiver Form</button>
	
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<b>Pickup - <?php echo e($Quote->id); ?></b>
	<p>By Signing the waiver form you agree that our liability is waivered, in the event of something being damaged, as a  result of the being moved.</p>
	<div style="border: #000 1px solid; padding: 10px;">
		<div class="float-left"><?php echo e($CleintName); ?></div>
		<?php if($Quote->sign_pickup != ""): ?>
		<div class="float-right"><img src="<?php echo e(URL('public/sign')); ?>/<?php echo e($Quote->sign_pickup); ?>?date=<?php echo e(date('Y-m-d h:i:s')); ?>" width="100"></div>
		<?php endif; ?>
		<div class="clearfix"></div>
	</div>
	<button data-toggle="modal" data-target="#exampleModal" onClick="SignType('Pickup')" class="btn btn-primary">Sign Pickup Confirm</button>
	
	
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<b>Delivery - <?php echo e($Quote->id); ?></b>
	<p>The delivery has been completed without issues, in accordance with my instruction.</p>
	<div style="border: #000 1px solid; padding: 10px;">
		<div class="float-left"><?php echo e($CleintName); ?></div>
		<?php if($Quote->sign_delivery != ""): ?>
		<div class="float-right"><img src="<?php echo e(URL('public/sign')); ?>/<?php echo e($Quote->sign_delivery); ?>?date=<?php echo e(date('Y-m-d h:i:s')); ?>" width="100"></div>
		<?php endif; ?>
		<div class="clearfix"></div>
	</div>
	<button data-toggle="modal" data-target="#exampleModal" onClick="SignType('Delivery')" class="btn btn-primary">Sign Delivery Confirm</button>
	
	
	<div style="width: 100%; margin-top: 20px;">
            <img src="<?php echo e(URL('public/footer.JPG')); ?>" style="width:100%">
        </div>
	<div class="clearfix">&nbsp;</div>
</div>
	
	
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sign Here</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  <canvas id="signature-pad" width="400" height="200"></canvas>
		  <div id="Info" class="alert alert-info"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="clear">Clear</button>
        <button type="button" class="btn btn-primary" id="save">Save</button>
      </div>
    </div>
  </div>
</div>
	
<script>
var QuoteId = "<?php echo e($_GET['QuoteID']); ?>";
var SignFor = "";
var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
  backgroundColor: 'rgba(255, 255, 255, 0)',
  penColor: 'rgb(0, 0, 0)'
});
var saveButton = document.getElementById('save');
var cancelButton = document.getElementById('clear');

saveButton.addEventListener('click', function (event) {
  var data = signaturePad.toDataURL('image/png');
	$("#Info").html("Please wait while we saving sign");
	$.ajax({
		url: '<?php echo e(URL("SaveSign")); ?>',
		type: 'post',
		data: {sign: data, ID: QuoteId, SignFor: SignFor},
		cache: false,
		success: function (data) {
			$("#Info").html("Signature Saved Successfully");
			signaturePad.clear();
			$("#exampleModal").modal("hide");
			window.location.reload();
		}
	});
});

cancelButton.addEventListener('click', function (event) {
	$("#Info").html("");
	signaturePad.clear();
});
	
function SignType(Sign){
	$("#Info").html("");
	SignFor = Sign;
	console.log(Sign);
}
	</script>
</body>
</html><?php /**PATH /opt/lampp/htdocs/corner/resources/views/Jobhseet.blade.php ENDPATH**/ ?>