<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://www.paypal.com/sdk/js?client-id=AePJzvfkTTctWI5EkjSLql5UTGcIZ4aUHSv1DbNhvzKI_9ebwyNlSv0omU2T3Z0lnlX9ywaA_mSkJSP4"></script>

<style type="text/css">
	.tt-menu{
		background: #FFF;
		border: #CCC 1px solid;
		padding: 10px;
	}
	.tt-suggestion{
		cursor: pointer;
		border-bottom: #CCC 1px solid;
	}
	.twitter-typeahead{
		width: 100%;
	}
</style>
<?php echo Form::open(['url'=>'save-custom-quote', 'id' => 'custom', 'enctype' => 'multipart/form-data', 'method'=>'post', 'class' => 'add_bottom_30']); ?>


<input type="hidden" name="AudioFile" id="AudioFile">
<div class="container">
	
	<?php if(isset($Msg)): ?>
	<div class="alert alert-danger"><?php echo e($Msg); ?></div>
	<?php
	die;
	?>
	<?php endif; ?>

	<h1><?php echo e(isset($SurveyObject->first_name) ? $SurveyObject->first_name : base64_decode($ClientData->client)); ?> <?php echo e(isset($SurveyObject->last_name) ? $SurveyObject->last_name : base64_decode($ClientData->client_surname)); ?></h1>
	<address><b>Pickup :</b> <?php echo e(base64_decode(@$ClientData->address)); ?></address>
	<address><b>Delivery : </b> <?php echo e(base64_decode(@$ClientData->delivery_address)); ?></address>
	
	<div class="row">
		<div class="col-md-12">
			<h3 style="display: none">Total Amount: £<span id="ta"><?php echo e(@$SurveyObject->total_price); ?></span> </h3>
			<ul id="custom-titles" class="stepy-titles">
				<li id="custom-title-1" onClick="ShowStep(1)" class="current-step"><div>Step 1</div><span>Inventory - Online</span></li>
				<li id="custom-title-5" class="" onClick="ShowStep(5)"><div>Step 2</div><span>Custom Payment</span></li>
			</ul>
			<div class="clearfix"></div>
			<input id="total_volume" name="total_volume" type="hidden" value="<?php echo e(@$SurveyObject->total_volume); ?>">
			<input id="total_amount" name="total_amount" type="hidden" value="<?php echo e(@$SurveyObject->total_price); ?>">
			
			<input id="txnnid" name="txnnid" type="hidden" value="<?php echo e(@$Quote->pay_txn_id); ?>">
			
			<input name="quote_id" type="hidden" value="<?php echo e(@$_GET['QuoteID']); ?>">
			<input name="client_id" type="hidden" value="<?php echo e($_GET['client']); ?>">
			<input name="survey_id" type="hidden" value="<?php echo e(@$_GET['survey']); ?>">
			
			<fieldset title="Step 2" class="step" id="custom-step-1" style="display: block;">
				<div class="text-right"><h4 id="HtmlVolume">Total Volume 0 mc</h4></div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<?php
					$TabCount = 0;
					?>
				<?php $__currentLoopData = $ItemList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $MainRoot => $ArrVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				  <li class="nav-item text-center">
					<a class="nav-link <?php if($TabCount == 0): ?> active <?php endif; ?>" id="<?php echo e($MainRoot); ?>-tab" data-toggle="tab" href="#<?php echo e($MainRoot); ?>" role="tab" aria-controls="home" aria-selected="true" onClick="FilterRoomObject('<?php echo e($MainRoot); ?>')">
						<?php if($MainRoot == "Bedroom"): ?>
						<i class="fa fa-bed" style="font-size: 30px;"></i><br><br>
						<?php endif; ?>
						
						<?php if($MainRoot == "Livingroom"): ?>
						<i class="fa fa-couch" style="font-size: 30px;"></i><br><br>
						<?php endif; ?>
						
						<?php if($MainRoot == "Kitchen"): ?>
						<i class="fa fa-sink" style="font-size: 30px;"></i><br><br>
						<?php endif; ?>
						
						<?php if($MainRoot == "Garden"): ?>
						<i class="fa fa-leaf" style="font-size: 30px;"></i><br><br>
						<?php endif; ?>
						
						<?php if($MainRoot == "Office"): ?>
						<i class="fas fa-print" style="font-size: 30px;"></i><br><br>
						<?php endif; ?>
						
						<?php if($MainRoot == "Boxes"): ?>
						<i class="fas fa-box" style="font-size: 30px;"></i><br><br>
						<?php endif; ?>
						
						<?php echo e($MainRoot); ?>

					  </a>
				  </li>
					<?php
					$TabCount++;
					?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
				<script>
				function QtyBoxShow(id){
					$("#ShowNoQtyBox-"+id).css("display", "none");
					$("#ShowQtyBox-"+id).fadeIn();
					$("#QtyBox-"+id).val("1");
					CalculateVolume();
				}
				function IncQty(id){
					Qty = parseInt($("#QtyBox-"+id).val());
					Qty++;
					$("#QtyBox-"+id).val(Qty);
					
					CalculateVolume();
				}
				function DscQty(id){
					Qty = parseInt($("#QtyBox-"+id).val());
					Qty--;
					$("#QtyBox-"+id).val(Qty);
					
					if(Qty == 0){
						$("#ShowQtyBox-"+id).css("display", "none");
						$("#ShowNoQtyBox-"+id).css("display", "block");
						$("#QtyBox-"+id).val("0");
					}
					CalculateVolume();
				}
				
				function CalculateVolume(){
					TotalVolume = 0;
					$(".VolumeBoxes").each(function() {
						if($(this).val() != "0"){
							TotalVolume += parseInt($(this).val()) * parseFloat($(this).data("volume"));
						}
					});
					
					TotalVolume = TotalVolume.toFixed(2);
					$("#HtmlVolume").html("Total Volume "+TotalVolume+" mc");
					$("#total_volume").val(TotalVolume);
					CalculatePrice();
				}
				</script>
				<div class="tab-content" id="myTabContent">
					<?php
					$TabCount = 0;
					$TotInvCounter = 0;
					?>
					<?php $__currentLoopData = $ItemList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $MainRoot => $ArrVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				  		<div class="tab-pane fade <?php if($TabCount == 0): ?> show active <?php endif; ?>" id="<?php echo e($MainRoot); ?>" role="tabpanel" aria-labelledby="<?php echo e($MainRoot); ?>-tab">
							<div class="row" id="AddExtraInfo-<?php echo e($MainRoot); ?>">
						<?php $__currentLoopData = $ArrVal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ItemName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
						$CheckInventory = \App\Model\Inventory::where("obj_category", $MainRoot)->where("inventory_survey", @$SurveyObject->id)->where("obj_id", $ItemName['ID'])->where("obj_qty", ">", 0)->first();
						?>
						<div class="col-6">
							<div style="padding: 5px 10px; background: #FFF; font-size: 20px; font-weight: bold; border-bottom: #CCC 1px solid;">
								<div class="float-left"><?php echo e($ItemName['Name']); ?> <small>(<?php echo e($ItemName['Vol']); ?>)</small></div>
								<div class="float-right" id="ShowNoQtyBox-<?php echo e($TotInvCounter); ?>" <?php if($CheckInventory != ""): ?> style="display: none" <?php endif; ?>><button onClick="QtyBoxShow('<?php echo e($TotInvCounter); ?>')" type="button" class="btn btn-success">+</button></div>
								<div class="float-right" id="ShowQtyBox-<?php echo e($TotInvCounter); ?>" <?php if($CheckInventory == ""): ?> style="display: none" <?php endif; ?>>
									<div class="float-left" style="margin-right: 10px;"><button type="button" onClick="DscQty('<?php echo e($TotInvCounter); ?>')" class="btn btn-danger">-</button></div>
									<div class="float-left" style="margin-right: 10px;"><input data-item-id="item-<?php echo e($MainRoot); ?><?php echo e($ItemName['ID']); ?>" data-volume="<?php echo e($ItemName['Vol']); ?>" id="QtyBox-<?php echo e($TotInvCounter); ?>" name="RoomObj[<?php echo e($MainRoot); ?>][<?php echo e($ItemName['ID']); ?>]" value="<?php echo e(@$CheckInventory->obj_qty > 0 ? $CheckInventory->obj_qty : 0); ?>" type="text" readonly class="form-control text-center VolumeBoxes" style="width: 50px;"></div>
									<div class="float-left"><button type="button" class="btn btn-success" onClick="IncQty('<?php echo e($TotInvCounter); ?>')">+</button></div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<?php
						$TotInvCounter++;
						?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
						<?php
						$TabCount++;
						?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
					<div style="padding: 10px; background: #FFF; font-size: 20px; font-weight: bold; border-bottom: #CCC 1px solid;">
						<input type="text" class="form-control" placeholder="Search New Item" id="SearchNewItem">
					</div>
					<div class="alert bg-danger" id="ShowAlertBG" style="color: #FFF; display: none">Item Already Exists</div>
				</div>
				
				<p id="custom-buttons-1" class="custom-buttons">
					<button style="margin-right: 10px; color: #FFF" name="SaveMove" value="MoveTolPlan" class="button-next">View Personal Move Plan</button>
				</p>
			</fieldset>
			
			<fieldset title="Step 6" class="step" id="custom-step-5" style="display: none;">
				<legend style="display: none;">Custom Payment</legend>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Paypal Amount</label>
							<input type="number" class="form-control" name="ppamount" id="PaypalAmount" value="50" minn="50" required>
						</div>
					</div>
				</div>
				
				<div id="paypal-button-container"></div>
				
				<p id="custom-buttons-5" class="custom-buttons">
					<a id="custom-back-5" onClick="ShowStep(3)" href="javascript:void(0);" class="button-back">Previous step</a>
					<input type="submit" class="finish" value="Finish!">
				</p>
			</fieldset><!-- End Step four --> 
			<div class="stepy-error"></div>
		</div><!-- End col-md-9 -->
	</div>
</div>

<?php echo Form::close(); ?>


<div class="clearfix">&nbsp;</div>
<div class="container" id="controls">
  	 
  	 
  	<button style="margin-left: 10px" class="float-right btn btn-danger" id="stopButton" disabled>Stop</button>
	
	<button style="margin-left: 10px" class="float-right btn btn-success" id="pauseButton" disabled>Pause</button>
	
	<button class="float-right btn btn-danger" id="recordButton">Record</button>
</div>


<script>
	var PrvStep = 1
	function ShowStep(step){
		$("#custom-step-"+PrvStep).css("display", "none");
		$("#custom-title-"+PrvStep).removeClass("current-step");
		
		$("#custom-step-"+step).css("display", "block");
		$("#custom-title-"+step).addClass("current-step");
		PrvStep = step;
	}
</script>


<script>
var TotalMile = 0;
function CalculatePrice(){
	var TotalPrice = 0
	var TotalVans = 0;

	$(".VechiclesSelectOption").each(function() {
		TotalVans++
		if($(this).val() == "luton_van"){
			TotalPrice += 500
		}

		if($(this).val() == "maxi_mover"){
			TotalPrice += 700
		}

		if($(this).val() == "half_a_luton_van"){
			TotalPrice += 350
		}

		if($(this).val() == "low_loader"){
			TotalPrice += 600
		}
	});

	var PackagingDate = $("#PackagingDate").val()
	var MovingDate = $("#MovingDate").val()
	var DeliveryDate = $("#DeliveryDate").val()

	if(PackagingDate != ""){
		if(MovingDate != PackagingDate){
			TotalPrice += 350
		}else{
			TotalPrice += 250
		}
	}

	if(DeliveryDate != MovingDate){
		$(".VechiclesSelectOption").each(function() { 
			if($(this).val() == "luton_van"){
				TotalPrice += 495
			}

			if($(this).val() == "maxi_mover"){
				TotalPrice += 495
			}

			if($(this).val() == "half_a_luton_van"){
				TotalPrice += 495
			}

			if($(this).val() == "low_loader"){
				TotalPrice += 495
			}
		});
	}
	
	var GetExtraPorter = parseInt($("#ExtraPorters").val())
	var GetExtraPackers = parseInt($("#ExtraPackers").val())
	TotalPrice += GetExtraPorter * 110
	TotalPrice += GetExtraPackers * 110
	TotalPrice += TotalMile * TotalVans
	if(TotalPrice > 0){
		$("#NewPotters").val(TotalVechile*2);
	}
		
	TotalVolume = 0;
	$(".VolumeBoxes").each(function() {
		if($(this).val() != "0"){
			TotalVolume += parseInt($(this).val()) * parseFloat($(this).data("volume"));
		}
	});
		
	ovtotal = 0;
	ovtotal = TotalPrice + (TotalVolume*30);
	$( "#ta" ).html(ovtotal.toFixed(2));
	$("#total_amount").val(ovtotal.toFixed(2));
	return TotalPrice;
}

	function CalculateMile(){
		var FromCode = $("#PostCodeFrom").val()
		var ToCode = $("#PostCodeTo").val()

		$.ajax({
			url: '<?php echo e(URL("GetDistance")); ?>',
			type: 'get',
			data: {From: FromCode, To: ToCode},
			cache: false,
			success: function (data) {
				TotalMile = parseFloat(data);
				CalculatePrice()
			}
		});
	}
</script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="<?php echo e(URL('public/typeahead.bundle.min.js	')); ?>"></script>

<script>
	var AddedItem = 2500;
	SelectedRoomObj = "Office";
	function FilterRoomObject(obj){
		SelectedRoomObj = obj;
	}
	var bestPictures = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("id", 'text', 'Width', 'Height', 'Depth', 'Volume'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        url: '<?php echo e(URL("SearchRoomObject")); ?>?',
		  replace: function(url, uriEncodedQuery) {
            var val = SelectedRoomObj;
            var res = (url + "q="+$('#SearchNewItem').val()+"&Obj=" + SelectedRoomObj);
            return res
          },
        wildcard: '%QUERY'
      }
    });
	$('#SearchNewItem').typeahead(null, {
        name: 'best-pictures',
        minLength: 2,
        showHintOnFocus: true,
        display: 'text',
        limit: Infinity,
        source: bestPictures.ttAdapter(),
        templates: {
            suggestion: function(data) {
                a = '<p>'+data.text + "</p>";
                return a;
            }
        }
    });
	
	$('#SearchNewItem').on('typeahead:select', function(evt, item) {
		$("#ShowAlertBG").fadeOut("fast");
		
		ItemFound = 0
		$(".VolumeBoxes").each(function() {
			NeIDD = "item-"+SelectedRoomObj+item.id;
			
			if($(this).data("item-id") == NeIDD){
				ItemFound = 1;
			}
		});
		
		
		if(ItemFound == 0){
			HTML = "";
			HTML += '<div class="col-6">';
			HTML += '<div style="padding: 5px 10px; background: #FFF; font-size: 20px; font-weight: bold; border-bottom: #CCC 1px solid;">';
			HTML += '<div class="float-left">'+item.text+' <small>('+item.Volume+')</small></div>';
			HTML += '<div class="float-right" id="ShowNoQtyBox-'+AddedItem+'"  style="display: none"><button onClick="QtyBoxShow('+AddedItem+')" type="button" class="btn btn-success">+</button></div>';
			HTML += '<div class="float-right" id="ShowQtyBox-'+AddedItem+'">';
			HTML += '<div class="float-left" style="margin-right: 10px;"><button type="button" onClick="DscQty('+AddedItem+')" class="btn btn-danger">-</button></div>';
			HTML += '<div class="float-left" style="margin-right: 10px;"><input data-item-id="item-'+SelectedRoomObj+item.id+'" data-volume="'+item.Volume+'" id="QtyBox-'+AddedItem+'" name="RoomObj['+SelectedRoomObj+']['+item.id+']" value="1" type="text" readonly class="form-control text-center VolumeBoxes" style="width: 50px;"></div>';
			HTML += '<div class="float-left"><button type="button" class="btn btn-success" onClick="IncQty('+AddedItem+')">+</button></div>';
			HTML += '</div>';
			HTML += '<div class="clearfix"></div>';
			HTML += '</div>';
			HTML += '</div>';
			$("#AddExtraInfo-"+SelectedRoomObj).append(HTML);
			$('#SearchNewItem').val("");
			AddedItem++;
			CalculateVolume();
		}else{
			$("#ShowAlertBG").fadeIn("fast");
		}
    });
  </script>

<script>
paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
			currency_code: "USD",
            value: $("#PaypalAmount").val()
          }
        }]
      });
    },
	onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
		console.log(details);
		 if(details.status == "COMPLETED"){
		  $("#txnnid").val(details.id);
		  $("#custom").submit();
		 }
      });
    }
  }).render('#paypal-button-container');
	
CalculateVolume();
	
<?php if(@$_GET['Redirect']): ?>
<?php
$URL = URL("personal_move_plan")."?QuoteID=".$_GET['QuoteID']."&id=".$_GET['survey']
?>
window.open('<?php echo $URL; ?>', '_blank')
<?php endif; ?>
</script>


<script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
<script>
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb. 
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var pauseButton = document.getElementById("pauseButton");

//add events to those 2 buttons
recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
pauseButton.addEventListener("click", pauseRecording);

function startRecording() {
	console.log("recordButton clicked");

	/*
		Simple constraints object, for more advanced audio features see
		https://addpipe.com/blog/audio-constraints-getusermedia/
	*/
    
    var constraints = { audio: true, video:false }

 	/*
    	Disable the record button until we get a success or fail from getUserMedia() 
	*/

	recordButton.disabled = true;
	stopButton.disabled = false;
	pauseButton.disabled = false

	/*
    	We're using the standard promise based getUserMedia() 
    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
	*/

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		console.log("getUserMedia() success, stream created, initializing Recorder.js ...");

		/*
			create an audio context after getUserMedia is called
			sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
			the sampleRate defaults to the one set in your OS for your playback device

		*/
		audioContext = new AudioContext();

		/*  assign to gumStream for later use  */
		gumStream = stream;
		
		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);

		/* 
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
		*/
		rec = new Recorder(input,{numChannels:1})

		//start the recording process
		rec.record()

		console.log("Recording started");

	}).catch(function(err) {
	  	//enable the record button if getUserMedia() fails
    	recordButton.disabled = false;
    	stopButton.disabled = true;
    	pauseButton.disabled = true
	});
}

function pauseRecording(){
	console.log("pauseButton clicked rec.recording=",rec.recording );
	if (rec.recording){
		//pause
		rec.stop();
		pauseButton.innerHTML="Resume";
	}else{
		//resume
		rec.record()
		pauseButton.innerHTML="Pause";

	}
}

function stopRecording() {
	console.log("stopButton clicked");

	//disable the stop button, enable the record too allow for new recordings
	stopButton.disabled = true;
	recordButton.disabled = false;
	pauseButton.disabled = true;

	//reset button just in case the recording is stopped while paused
	pauseButton.innerHTML="Pause";
	
	//tell the recorder to stop the recording
	rec.stop();

	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	//create the wav blob and pass it on to createDownloadLink
	rec.exportWAV(createDownloadLink);
}

function createDownloadLink(blob) {
	$("#ShwLoading").fadeIn("fast");
	var filename = new Date().toISOString()+".mp3";
	var xhr=new XMLHttpRequest();
	xhr.onload=function(e) {
		$("#ShwLoading").fadeOut("fast");
		if(this.readyState === 4) {
			$("#AudioFile").val(e.target.responseText);
			
		}
	};
	var fd=new FormData();
	fd.append("audio_data",blob, filename);
	xhr.open("POST","<?php echo e(URL('UploadAudio')); ?>",true);
	xhr.send(fd);
}
</script>

<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<div style="position: fixed; width: 100%; display: none; height: 100%; top: 0px; left: 0px; z-index: 99999; background: rgba(0,0,0,0.5)" id="ShwLoading">
	<div style="position: fixed; padding: 30px; width: 40%; border-radius: 30px; background: #FFF; z-index: 99999999; top: 20%; left: 30%"><lottie-player src="https://assets7.lottiefiles.com/packages/lf20_pMMQPe.json"  background="transparent"  speed="1"  style="width: 100%; height: 30%;" loop autoplay></lottie-player><br>Audio Uploading....</div>
</div>
</body>
</html>
<?php /**PATH /opt/lampp/htdocs/corner/resources/views/custom-quote.blade.php ENDPATH**/ ?>