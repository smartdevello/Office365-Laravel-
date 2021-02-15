<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://cdn.tiny.cloud/1/zsrql76n3hbsfejrt3239enwm13k2dmkr3j6igkm3z6xewp0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

	<script type="text/javascript">
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            height: 400,
            menubar: false,
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            },
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | code',
            //content_css: '//www.tiny.cloud/css/codepen.min.css',
            
        });
    </script>
    <div class="container">
        <div >
            <img src="<?php echo e(URL('public/header.jpeg')); ?>" style="width:100%; height: 100%;">
        </div>
<?php
$mailBody = "<table border='0'>
    <tr>
        <td>Thank you for your time</td>
    </tr>
    <tr>
        <td>I attached your Personal Move Plan and Quote including: 1 Luton and 1 Maxi Mover, 4 Porters, Insurance, packaging materials, ... etc</td>
    </tr>
    <tr>
        <td>Please sign the accept sheet so I can add your move to the calendar or let me know if you have any questions.</td>
    </tr>
    <tr>
        <td>Note: Service Match at 10% Better Price. We will try to match any quote you might have from any removal company that is part of an UK association of removers, plus 10% - 15% OFF.</td>
    </tr>
</table>";
?>		
		<div class="clearfix">&nbsp;</div>
		<ul class="nav nav-tabs">
			
			<?php
			$CountTotalActive = 0;
			?>
			
			<?php $__currentLoopData = $AllQuote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $QInd => $AlQ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if($AlQ->quote_delete == "0"): ?>
			
			<?php
			$CountTotalActive++;
			?>
			
		  <li class="nav-item">
			<a class="nav-link <?php if($QuoteID == $AlQ->id): ?> active <?php endif; ?>" href="<?php echo e(URL('personal_move_plan')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($AlQ->id); ?>">Plan <?php echo e($QInd +1); ?> - <?php echo e($AlQ->plan_name); ?></a>
		  </li>
			<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
		
		
		<?php if(Session::has('Success')): ?>
		<div class="alert alert-success" role="alert">
			<div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
			<div class="alert-text"><?php echo Session::get('Success'); ?></div>
		</div>
		<?php endif; ?>
		
        <?php echo Form::open(['url'=>'save-edit', 'enctype' => 'multipart/form-data', 'method'=>'post']); ?>

        
		<div class="dropdown" style="margin-right: 50px; margin-top: 30px; float: right">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Add New Quote
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="<?php echo e(URL('CreateQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>&Type=Premium">Premium</a>
				<a class="dropdown-item" href="<?php echo e(URL('CreateQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>&Type=Standard">Standard</a>
				<a class="dropdown-item" href="<?php echo e(URL('CreateQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>&Type=Multiple Trips">Multiple Trips</a>
				<a class="dropdown-item" href="<?php echo e(URL('CreateQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>&Type=Storage">Storage</a>
				<a class="dropdown-item" href="<?php echo e(URL('CreateQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>&Type=Redelivery">Redelivery</a>
				<a class="dropdown-item" href="<?php echo e(URL('ServiceTemplate')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>&Type=Redelivery">Generate Service Match</a>
			</div>
		</div>
		
		<?php if($CountTotalActive > 1): ?>
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a onClick="DeleteQuote()"><button type="button" class="btn btn-danger">Delete</button></a>
        </div>
		<?php endif; ?>
		
		<div class="float-right" style="margin-right: 50px; margin-left: 50px; margin-top: 30px;">
			<button type="submit" class="btn btn-primary inputbtn">Save</button>
		</div>
		
		<?php if(session("UserRole") == "admin"): ?>
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			PMP Approved?<br>
			<input onClick="ApprovePMP('<?php echo e($Quote->id); ?>', '1')" type="radio" <?php if($Quote->approved == 1): ?> checked <?php endif; ?> name="PmpApproved"> Yes &nbsp;
			<input onClick="ApprovePMP('<?php echo e($Quote->id); ?>', '0')" <?php if($Quote->approved == 0): ?> checked <?php endif; ?> type="radio" name="PmpApproved"> No
		</div>
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="<?php echo e(URL('MailQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" class="btn btn-success" onclick="showMailBody()">Mail PDF</button></a>
		</div>
		<?php else: ?>
		<?php if($Quote->approved == 0): ?>
		<?php
		$CheckApproval = \App\Model\Approval::where("approval_quote", $_GET['QuoteID'])->count();
		?>
		
		<div class="float-right" style="margin-top: 30px;">
			<a href="<?php echo e(URL('SendNotification')); ?>?QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" class="btn" style="background: #FFF;
    border: #28a744 1px solid;
    border-radius: 0px;
    border-left: none;
    margin-left: -2px;">Send</button></a>
		</div>
		<div class="float-right" style="margin-top: 30px;">
			<a href="<?php echo e(URL('MailQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" <?php if($Quote->approved == 0): ?> disabled <?php endif; ?> class="btn btn-success">Mail PDF</button></a>
		</div>
		
		<?php else: ?>
		
		<div class="float-right" style="margin-top: 30px;">
			<a href="<?php echo e(URL('MailQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" <?php if($Quote->approved == 0): ?> disabled <?php endif; ?> class="btn btn-success">Mail PDF</button></a>
		</div>
		
		<?php endif; ?>
		<?php endif; ?>
		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="<?php echo e(URL('MailInvoice')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" class="btn btn-success">Mail Invoice</button></a>
		</div>
		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="<?php echo e(URL('ValidateQuote')); ?>?id=<?php echo e(encrypt($_GET['id'])); ?>&QuoteID=<?php echo e(encrypt($_GET['QuoteID'])); ?>" target="_blank"><button type="button" class="btn btn-danger">Generate Link</button></a>
		</div>
		
		<?php
		$GetClient = App\Model\Client::find($Survey->client_id);
		?>
		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="<?php echo e(URL('CustomQuote')); ?>?survey=<?php echo e($_GET['id']); ?>&client=<?php echo e($GetClient->client_id); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" class="btn btn-info inputbtn">Survey</button></a>
		</div>
		
		
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		
		<div class="text-center">
			Is Job Confirmed?
			<input value="1" name="JobConfimed" <?php if($Quote->job_confirmed == 1): ?> checked <?php endif; ?> type="radio"> Yes
			<input value="0" name="JobConfimed" <?php if($Quote->job_confirmed == 0): ?> checked <?php endif; ?> type="radio"> No
		</div>
		<div class="clearfix"></div>
	                <div class="text-center" id="mail-body" style="display: none">
                    <div style="font-size:30px;">
                        <textarea name="mail_body_text" id="mail_body_text" class="form-control tinymce-editor"><?php echo e($mailBody); ?></textarea>
                        <button type="button" class="btn btn-success" onclick="sendQuotes()">Send Quotes</button>
                    </div>    
                </div> 	
            <div  style="margin-top:30px;">
                <div class="text-center">
                    <div style="font-size:30px;">
                    <b>Personal Move Plan - <?php echo e($Quote->plan_name); ?></b>
                </div>    
            </div>  
            
            <input type="hidden" name="qid" value="<?php echo e($Quote->id); ?>">

            <div class="col-lg-12" style="margin-top: 20px;background-color:#E9FFFF;">
                <div style="padding-top:8px;">
                    <div style="background-color: #2ACDC9; padding:10px 0px;"> 
                        <div class="text-center text-white">
                            <b>Job Details</b>
                        </div>
                    </div>
                    
                    <div class="row">
                         <div class="col-md-4">
                            <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    <b>Job ID:</b>
                                </div>
                                <div class="col-lg-6">
                                     <span style="font-size:14px;"><?php echo e($Quote->id); ?></span>
                                </div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   <b>Customer Name:</b>
                                </div>    
                                <div class="col-lg-6">
                                    <span style="font-size:14px;"><?php echo e(@$Survey->first_name); ?> <?php echo e(@$Survey->last_name); ?></span>
                                </div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    <b>Survey Date:</b>
                                </div>
                                <div class="col-lg-6">
                                    <input type="date" name="survey_date" value="<?php echo e(@$Quote->survey_date); ?>" class="inputcontrolText">
                                </div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6" >
									<b>Surveyor:</b>
                                </div>
								<?php
								$Surveyor = App\Model\User::where("role", "Surveyor")->get();
								?>
                                <div class="col-lg-6">
                                   <select class="inputcontrolText" name="surveyor">
                                       <option value="">select</option>
									   <?php $__currentLoopData = $Surveyor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Sur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option <?php if($Quote->surveyor == $Sur->name): ?> selected <?php endif; ?>><?php echo e($Sur->name); ?></option>
									   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   </select>
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-4" style="border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                             <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                  <b>From:</b>
                                </div>
                                <div class="col-lg-6">
                                    <textarea type="text" name="from" style="height: 60px;" class="inputcontrolText" onBlur="CalculateMile()" id="PostCodeFrom"><?php echo e(@$Quote->pickup_postcode); ?></textarea>
                                </div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                  <b>Building:</b>
                                </div>    
                                <div class="col-lg-6">
                                    <input type="text" name="bulding" value="<?php echo e(@$Quote->pickup_building); ?>" class="inputcontrolText">
                                    
                                </div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                     <b>Access:</b>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="access" value="<?php echo e(@$Quote->pickup_access); ?>" class="inputcontrolText">
                                   
                                </div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    <b>Parking:</b>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="parking" value="<?php echo e(@$Quote->pickup_parking); ?>" class="inputcontrolText">
                                </div>
                            </div>         
                        </div>
                        <div class="col-md-4" >
                            <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    <b>To:</b>
                                </div>
                                <div class="col-lg-6">
                                    <textarea type="text" name="to" style="height: 60px;" class="inputcontrolText" id="PostCodeTo" onBlur="CalculateMile()"><?php echo e(@$Quote->delivery_postcode); ?></textarea>
                                        
                                </div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   <b>Building:</b>
                                </div>    
                                <div class="col-lg-6">
                                    <input type="text" name="delivery_building" value="<?php echo e(@$Quote->delivery_building); ?>" class="inputcontrolText">
                                 
                                </div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    <b>Access:</b>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="delivery_access" value="<?php echo e(@$Quote->delivery_access); ?>" class="inputcontrolText">
                                
                                </div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    <b>Parking:</b>
                                </div>
                                <div class="col-lg-6">
                                   <input type="text" name="delivery_parking" value="<?php echo e($Quote->delivery_parking); ?>" class="inputcontrolText">
                                
                                </div>
                            </div> 
                              
                        </div>    
                    </div>
                    
                </div>        
            </div>   
            
            <div class="col-lg-12">
				<?php
				$GetTotalVechile = explode(",", $Quote->vehicles_no);
				$FirstValue = "";
				if(isset($GetTotalVechile[0])){
					$FirstValue = $GetTotalVechile[0];
				}
				?>

                    <div class="row" style="margin-top:5px;">
                        <div class="col-lg-4" style="background-color:#E9FFFF;">
							
							
							
							<div class="row" style="margin:5px;">
                                <div class="col-lg-6">Total Volume</div>
                                <div class="col-lg-6"><?php echo e(number_format($Survey->total_volume, 2)); ?></div> 
                            </div> 
							
                              <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    No Vehicles:
                                </div>
                                <div class="col-lg-4">
                                    <select class="inputcontrolText VechiclesSelectOption" name="vechle[]" onChange="CalculatePrice()">
                                       <option selected value="">select</option>
                                       <option <?php if($FirstValue == "maxi_mover"): ?> selected <?php endif; ?> value="maxi_mover">Maxi Mover</option>
                                       <option <?php if($FirstValue == "luton_van"): ?> selected <?php endif; ?> value="luton_van">Luton Van</option>
                                       <option <?php if($FirstValue == "low_loader"): ?> selected <?php endif; ?> value="low_loader">Low Loader</option>
                                       <option <?php if($FirstValue == "half_a_luton_van"): ?> selected <?php endif; ?> value="half_a_luton_van">Half a Luton Van</option>
                                   </select>
                                </div> 
								  <div class="col-lg-2">
									  <button type="button" class="AddBtn" onClick="AddMoreVechile()">+</button>
								  </div>
                            </div> 
							
							<div id="LoadNewVechild">
								<?php for($k = 1; $k < count($GetTotalVechile); $k++): ?>
								<div class="row" style="margin:5px;" id="ExVchDiv<?php echo e($k); ?>">
									<div class="col-lg-6"></div>
									<div class="col-lg-4">
										<select class="inputcontrolText VechiclesSelectOption" name="vechle[]" onChange="CalculatePrice()">
										   <option selected value="">select</option>
										   <option <?php if($GetTotalVechile[$k] == "maxi_mover"): ?> selected <?php endif; ?> value="maxi_mover">Maxi Mover</option>
										   <option <?php if($GetTotalVechile[$k] == "luton_van"): ?> selected <?php endif; ?> value="luton_van">Luton Van</option>
										   <option <?php if($GetTotalVechile[$k] == "low_loader"): ?> selected <?php endif; ?> value="low_loader">Low Loader</option>
										   <option <?php if($GetTotalVechile[$k] == "half_a_luton_van"): ?> selected <?php endif; ?> value="half_a_luton_van">Half a Luton Van</option>
									   </select>
									</div> 
									  <div class="col-lg-2">
										  <button type="button" class="AddBtn" onClick="RemoveVechile('ExVchDiv<?php echo e($k); ?>')">-</button>
									  </div>
								</div>
								<?php endfor; ?>
							</div>
							
							<script>
								var TotalVechile = <?php echo e(count($GetTotalVechile) == 0 ? 1 : count($GetTotalVechile)); ?>;
								function AddMoreVechile(){
									TotalVechile++;
									var HTML = "";
									var ID = "ExVchDiv"+TotalVechile;
									HTML += '<div class="row" style="margin:5px;" id="'+ID+'">';
									HTML += '<div class="col-lg-6"></div>';
									HTML += '<div class="col-lg-4">';
									HTML += '<select class="inputcontrolText VechiclesSelectOption" name="vechle[]" required onChange="CalculatePrice()">';
									HTML += '<option value="">select</option>';
									HTML += '<option value="maxi_mover">Maxi Mover</option>';
									HTML += '<option value="luton_van">Luton Van</option>';
									HTML += '<option value="low_loader">Low Loader</option>';
									HTML += '<option value="half_a_luton_van">Half a Luton Van</option>';
									HTML += '</select>';
									HTML += '</div>';
									HTML += '<div class="col-lg-2">';
									HTML += '<button type="button" class="AddBtn" onClick=RemoveVechile("'+ID+'")>-</button>';
									HTML += '</div>';
									HTML += '</div>';

									$("#LoadNewVechild").append(HTML);
								}
								
								function RemoveVechile(id){
									$( "#"+id ).remove();
									TotalVechile--;
									CalculatePrice()
								}
								
								function ShowExtraPorter(){
									$("#ExtraPorterDiv").css("display", "flex");
								}
								
								function RemoveExtraPorter(){
									$("#ExtraPorterDiv").css("display", "none");
									$("#ExtraPorters").val(0)
									CalculatePrice();
								}
								
								function ShowExtraPackers(){
									$("#ExtraPakersDiv").css("display", "flex");
								}
								
								function RemoveExtraPackers(){
									$("#ExtraPakersDiv").css("display", "none");
									$("#ExtraPackers").val(0)
									CalculatePrice()
								}
							</script>
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   No Porters:
                                </div>    
                                <div class="col-lg-4">
                                  <input type="number" name="porters_no" id="NewPotters" min="0" value="<?php echo e($Quote->porters_no); ?>" class="inputcontrolText text-center">
                                </div>
								
								<div class="col-lg-2">
									<button type="button" class="AddBtn" onClick="ShowExtraPorter()">+</button>
								</div>
                            </div>
							
							<div class="row" style="margin:5px; <?php if($Quote->extra_porters_no == 0): ?> display: none <?php endif; ?>" id="ExtraPorterDiv">   
                                <div class="col-lg-6"> No Extra Porters:
                                </div>
                                <div class="col-lg-4">
                                  <input type="number" name="extra_porters_no" value="<?php echo e($Quote->extra_porters_no); ?>" id="ExtraPorters" class="inputcontrolText text-center" onblur="CalculatePrice()">
                                </div>
								
								<div class="col-lg-2">
									<button type="button" class="AddBtn" onClick="RemoveExtraPorter()">-</button>
								</div>
                            </div> 
							
							
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    No Packers:
                                </div>
                                <div class="col-lg-4">
                                     <input type="number" name="packers_no" id="packers_no" value="<?php echo e($Quote->packers_no); ?>" class="inputcontrolText text-center" onblur="CalculatePrice()">
								</div>
								<div class="col-lg-2">
									<button type="button" class="AddBtn" onClick="ShowExtraPackers()">+</button>
								</div>
                            </div>
							
							<div class="row" style="margin:5px; <?php if($Quote->extra_packers_no == 0): ?> display: none <?php endif; ?>" id="ExtraPakersDiv">   
                                <div class="col-lg-6"> No Extra Packers:
                                </div>
                                <div class="col-lg-4">
                                  <input type="number" name="extra_packers_no" value="<?php echo e($Quote->extra_packers_no); ?>" id="ExtraPackers" class="inputcontrolText text-center" onblur="CalculatePrice()">
                                </div>
								
								<div class="col-lg-2">
									<button type="button" class="AddBtn" onClick="RemoveExtraPackers()">-</button>
								</div>
                            </div> 
							
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    No Cleaners:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="cleaners_no" value="<?php echo e($Quote->cleaners_no); ?>" class="inputcontrolText text-center">
                                </div>
                            </div>                    
                        </div>
                        <div class="col-lg-4" style="background-color:#E9FFFF; border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                                 <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    Moving Date:
                                </div>
                                <div class="col-lg-6">
                                    <input type="date" name="moving_date" value="<?php echo e($Quote->moving_date); ?>" class="inputcontrolText" id="MovingDate" onblur="CalculatePrice()">
                                 
                                </div> 
                            </div> 
							
							<div class="row" style="margin:5px;">
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6" style="font-size: 10px;">
									<input type="radio" <?php if($Quote->quote_status == "0"): ?> checked <?php endif; ?> name="QutoeStatus" value="0"> To Be Confirmed<br>
                                    <input type="radio" <?php if($Quote->quote_status == "1"): ?> checked <?php endif; ?> name="QutoeStatus" value="1"> Confirmed
                                </div> 
                            </div> 
							
							
							
							<div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    Arrival Time:
                                </div>
                                <div class="col-lg-3" style="padding-right: 0px;">
                                    <input type="text" name="moving_time" class="inputcontrolText" value="<?php echo e($Quote->moving_time); ?>">
                                </div>
								<div class="col-lg-3" style="padding-left: 0px;">
                                    <input type="text" name="moving_time_to" class="inputcontrolText" value="<?php echo e($Quote->moving_time_to); ?>">
                                </div>
                            </div> 
							
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Delivery Date:
                                </div>    
                                <div class="col-lg-6">
                                    <input type="date" name="delivery_date" value="<?php echo e($Quote->delivery_date); ?>" class="inputcontrolText" id="DeliveryDate" onblur="CalculatePrice()">
                                </div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Packaging Date:
                                </div>
                                <div class="col-lg-6">
                                    <input type="date" name="packaging_date" value="<?php echo e($Quote->packaging_date); ?>" class="inputcontrolText" id="PackagingDate" onblur="CalculatePrice()">
                                </div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                   Cleaning Date:
                                </div>
                                <div class="col-lg-6">
                                     <input type="date" name="cleaning_date" value="<?php echo e($Quote->cleaning_date); ?>" class="inputcontrolText">
                                
                                </div>
                            </div>  
                        </div>
                        <div class="col-lg-4" style="background-color:#E9FFFF; ">
                              <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    Waiting time:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="waiting_time" value="<?php echo e(@$Quote->waiting_time); ?>" class="inputcontrolText text-center">
                                </div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Out by:
                                </div>    
                                <div class="col-lg-6">
                                  <input type="text" name="out_by" value="<?php echo e(@$Quote->out_by); ?>" class="inputcontrolText">
                                </div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Storage:
                                </div>
                                <div class="col-lg-6">
                                       <input type="text" name="storage" value="<?php echo e(@$Quote->storage); ?>" class="inputcontrolText text-center">
                                </div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                   Insurance:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="insurance" value="<?php echo e(@$Quote->insurance); ?>" class="inputcontrolText text-center">
                                </div>
                            </div>  
                       
                        </div>    
                    </div>
            </div> 


            <div style="margin-top: 30px;background-color:#E9FFFF;">
                <div class="col-lg-12">
                    <div style="padding-top:8px;">    
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white">
                                <b>Services Details </b>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-6" style="background-color:#E9FFFF;padding-right:10px; ">
                            	      <div class="row " style="margin:5px;">
                                <div class="col-lg-6">
                                   Loading/Unloading, Mileage:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="loading_mileage" value="<?php echo e(@$Quote->loading_mileage); ?>" class="inputcontrolText text-center">
                                </div> 
                            </div> 
                            <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                  Packaging Materials:
                                </div>    
                                <div class="col-lg-6">
                                    <textarea type="text" name="packaging_materials" class="inputcontrolText" required><?php echo e(@$Quote->packaging_materials); ?></textarea>
                                </div>
                            </div>
							
							<?php if($Quote->job_confirmed == 1): ?>
								<?php if($Quote->packing_material_sent == "0"): ?>
								<div class="row" style="margin:5px;">
									<div class="col-lg-6"></div>
									<div class="col-lg-6">
										<button name="SendPacking" value="1" class="btn btn-danger">Send Packaging Material</button>
									</div>
								</div>
								<?php else: ?>
								<div class="row" style="margin:5px;">
									<div class="col-lg-6"></div>
									<div class="col-lg-6">
										<p style="font-size: 12px;">Delivery Requested on : <?php echo e(date("d F, Y", strtotime($Quote->packing_material_sent_date))); ?></p>
									</div>
								</div>
								<?php endif; ?>
							<?php endif; ?>
								
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    Packaging Service:
                                </div>
                                <div class="col-lg-6">
									<select class="inputcontrolText text-center" name="packaging_services">
										<option <?php if(@$Quote->packaging_services == "N/A"): ?> selected <?php endif; ?> value="N/A">N/A</option>
										<option <?php if(@$Quote->packaging_services == "Premium"): ?> selected <?php endif; ?> value="Premium">Premium</option>
									</select>
                                </div>
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    Unpacking Service:
                                </div>
                                <div class="col-lg-6">
									<select class="inputcontrolText text-center" name="unpacking_service">
										<option <?php if(@$Quote->unpacking_service == "N/A"): ?> selected <?php endif; ?> value="N/A">N/A</option>
										<option <?php if(@$Quote->unpacking_service == "Premium"): ?> selected <?php endif; ?> value="Premium">Premium</option>
									</select>
                                </div>
                            </div>  
                       
                      
    						</div>
                            <div class="col-lg-6" style="background-color:#E9FFFF;padding-right:5px; ">
    							<div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                   Heavy Items:
                                </div>
                                <div class="col-lg-6">
                                   <textarea name="heavy_items" class="inputcontrolText"><?php echo e(@$Quote->heavy_items); ?></textarea> 
                                </div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Dismantling service:
                                </div>    
                                <div class="col-lg-6">
                                    <input type="text" name="dismantling_service" value="<?php echo e(@$Quote->dismantling_service); ?>" class="inputcontrolText text-center">
                                </div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    Assembly service:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="assembly_service" value="<?php echo e(@$Quote->assembly_service); ?>" class="inputcontrolText text-center">
                                </div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                  Disposal Service:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="disposal_service" value="<?php echo e(@$Quote->disposal_service); ?>" class="inputcontrolText text-center">
                                </div>
                            </div>  
                       
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    Cleaning Service:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="cleaning_service" value="<?php echo e(@$Quote->cleaning_service); ?>" class="inputcontrolText text-center">
                                </div>
                            </div>  
    						</div>  
                        </div>
                    </div>    

                </div>        
            </div> 


            <div style="margin-top: 20px;">
                <div class="col-lg-12"  style="background-color:#E9FFFF; padding-bottom: 10px" >
                    <div style="padding-top:8px;">
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white">
                                <b>Special Instructions</b>
                            </div>

                        </div>
                        <p style="font-size: 14px; margin-top:10px; margin-bottom:30px;" >
							<textarea name="special_instructions" class="form-control"><?php echo e(@$Quote->special_instructions); ?></textarea>
                        </p>
                    </div>    
                </div>        
            </div>
		
			<div style="margin-top: 20px;">
                <div class="col-lg-12"  style="background-color:#E9FFFF; padding-bottom: 10px" >
                    <div style="padding-top:8px;">
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white">
                                <b>Extra Amount</b>
                            </div>

                        </div>
                        <p style="font-size: 14px; margin-top:10px; margin-bottom:30px;" >
							<input name="other_amount" class="form-control" id="other_amount" onBlur="CalculatePrice()" value="<?php echo e(@$Quote->other_amount == "" ? 0 : $Quote->other_amount); ?>">
                        </p>
                    </div>    
                </div>        
            </div> 

            <div  style="margin-top: 30px;">
                <div class="container" style="background-color:#2ACDC9;">
                    <div class="row" >
                        <div class="col-lg-8">
                            <div style="margin-left:150px; margin-top: 20px; margin-bottom: 20px;">
                                <div style="font-size: 15px; color:#fff;" >Our standard package quote for your move is:</div>

                                <div style="font-size: 14px; color:#fff;" ><i>All Inclusive, No Hidden Fees, Price Match Guarantee + 10% Off</i></div>

                                <div style="font-size: 15px; color:#fff;" >Free updates / cancellations up to 72h before the move:</div>
                            </div>   
                               
                        </div>
                        <div class="col-lg-4">
                            <div class="text-white" style="font-size:60px;">
                               <b id="ShowTotalPrice">£000</b>
                            </div>
							<input type="hidden" name="FinalAmount" id="FinalAmount" value="0">
                        </div>    
                    </div>    
                </div>    
            </div>  

         <?php echo Form::close(); ?>

        <div style="width: 100%; margin-top: 20px;">
            <img src="<?php echo e(URL('public/footer.JPG')); ?>" style="width:100%; height: 100%;">
        </div>   
				
				<div class="clearfix">&nbsp;</div>
				<h1>Quote History</h1>
				<table class="table table-bordered table-stripped">
					<thead>
						<tr>
							<td>Quote No.</td>
							<td>Plan</td>
							<td>Created At</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
						<?php $__currentLoopData = $AllQuote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $QInd => $AlQ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($QInd + 1); ?></td>
							<td><?php echo e($AlQ->plan_name); ?></td>
							<td><?php echo e(date("d F, Y", strtotime($AlQ->created_at))); ?></td>
							<td><?php echo e($AlQ->quote_delete == 0 ? "Active" : "Deleted"); ?></td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
    
    </div>
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
				
				OtherValue = parseFloat($("#other_amount").val());
				if(OtherValue > 0){
					TotalPrice = OtherValue;
				}
				
				
				TotalPrice = TotalPrice.toFixed(2);
				
                $("#ShowTotalPrice").html("£"+TotalPrice)
				$("#FinalAmount").val(TotalPrice);
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
			
			CalculateMile()
			CalculatePrice()
                
                function showMailBody(){
                    $("#mail-body").css({"display":""});
                }
                function sendQuotes(){
                    //var mailBody = $("#mail_body_text").val();
                    var $ta = $("#mail_body_text");
                    var mailBody = $ta.val();
                    //var mailBody = $('#' + 'mail_body_text').html( tinymce.get('mail_body_text').getContent() );
                    $.ajax({
                            url: '<?php echo e(URL("SendMailQuote")); ?>',
                            type: 'POST',
                            data: {
                                "_token": "<?php echo e(csrf_token()); ?>",
                                "mailBody": mailBody,
                                "id" : '<?php echo  $_GET['id']; ?>',
                                "QuoteID" : '<?php echo  $_GET['QuoteID']; ?>'
                            },
                            cache: false,
                            success: function (response) {
                                if(response) {  
                                    alert("Send quotes successfully");
                                    $("#mail-body").css({"display":"none"});
                                }
                            }
			});
                }			
		</script>

<script>
	function DeleteQuote(){
		if(confirm("Are You Sure to Delete This Quote")){
			window.location = "<?php echo e(URL('DeleteQuote')); ?>?id=<?php echo e($QuoteID); ?>";
		}
	}
	
function ApprovePMP(id, status){
	window.location = "<?php echo e(URL('ApprovePMP')); ?>?id="+id+"&status="+status;
}
	</script>
</body>
</html><?php /**PATH /var/www/vhosts/cornerstoneremovals.com/laravel.cornerstoneremovals.com/resources/views/personal_move_plan.blade.php ENDPATH**/ ?>