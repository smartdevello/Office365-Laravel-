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
        <td>Please let me know if you have any questions and if I can add your move on the calendar.</td>
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
			<a class="nav-link <?php if($QuoteID == $AlQ->id): ?> active <?php endif; ?>" href="<?php echo e(URL('personal_move_plan')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($AlQ->id); ?>">Plan <?php echo e($AlQ->id); ?> - <?php echo e($AlQ->plan_name); ?></a>
		  </li>
			
			<?php
			$CheckForService = App\Model\ServiceMatch::where("service_match_qid", $AlQ->id)->where("is_delete", 0)->count();
			?>
			
			<?php if($CheckForService > 0): ?>
			<li class="nav-item">
			<a class="nav-link" href="<?php echo e(URL('ServiceTemplate')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($AlQ->id); ?>">Service Match <?php echo e($AlQ->id); ?></a>
		  </li>
			<?php endif; ?>
			
			<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
		
		
		<?php if(Session::has('Success')): ?>
		<div class="alert alert-success" role="alert">
			<div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
			<div class="alert-text"><?php echo Session::get('Success'); ?></div>
		</div>
		<?php endif; ?>
		
		<?php
		$CheckApproval = \App\Model\Approval::where("approval_quote", $_GET['QuoteID'])->where("approval_status", 0)->count();
		?>
		
		<?php if($CheckApproval > 0): ?>
		<?php
		$CheckApproval = \App\Model\Approval::where("approval_quote", $_GET['QuoteID'])->where("approval_status", 0)->first();
		?>
		
		<div class="alert alert-danger" role="alert">
			<div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
			<div class="alert-text">Approval Already Sent on <?php echo e(date("d/m/Y", strtotime($CheckApproval->approval_date))); ?></div>
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
				<a class="dropdown-item" href="<?php echo e(URL('ServiceTemplate')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>&Type=Redelivery">Service Match</a>
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

        <?php
        $Prm = explode(",", session("Permissions"));
        ?>
		
		<?php if(in_array("Personal Move Plan Request", $Prm)): ?>
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

		
		<div class="float-right" style="margin-top: 30px;">
			<a href="<?php echo e(URL('SendNotification')); ?>?QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" class="btn" style="background: #FFF;
    border: #28a744 1px solid;
    border-radius: 0px;
    border-left: none;
    margin-left: -2px;">Send</button></a>
		</div>
		
		<div class="float-right" style="margin-top: 30px;">
			<a href="<?php echo e(URL('MailQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" <?php if($Quote->approved == 0): ?> disabled <?php endif; ?> class="btn btn-success" onclick="showMailBody()">Mail PDF</button></a>
		</div>
		
		
		<?php else: ?>
		
		<div class="float-right" style="margin-top: 30px;">
			<a href="<?php echo e(URL('MailQuote')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" <?php if($Quote->approved == 0): ?> disabled <?php endif; ?> class="btn btn-success" onclick="showMailBody()">Mail PDF</button></a>
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
		$GetClient = App\Model\Client::find(@$Survey->client_id);
		?>
		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="<?php echo e(URL('CustomQuote')); ?>?survey=<?php echo e($_GET['id']); ?>&client=<?php echo e(@$GetClient->client_id); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" class="btn btn-info inputbtn">Survey</button></a>
		</div>
		
		
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		
		<div class="text-center">
			Is £50 Deposit Paid?
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


            <h4 style="margin: 20px; text-align: center;">Total Volume <?php echo e(number_format(@$Survey->total_volume, 2)); ?></h4>

            <div id="MovingJobSheet">

                <div style="background-color: #2ACDC9; padding:10px 0px; margin-top:15px"> 
                    <div class="text-center text-white">
                        <b>Moving Job</b>
                        <div class="float-left" style="margin-left: 10px;"><button style="background: #058683" type="button" class="AddBtn" v-on:Click="AddMovingJob">+</button></div>
                    </div>
                </div>
                
                <div class="col-lg-12" v-for="(item, index) in TotalJob">
                    <input type="hidden" name="ExitingJobID[]" v-model="MovingData[index].ExtJobID">
    				<?php
    				$GetTotalVechile = explode(",", $Quote->vehicles_no);
    				$FirstValue = "";
    				if(isset($GetTotalVechile[0])){
    					$FirstValue = $GetTotalVechile[0];
    				}
    				?>

                        <div class="row MovnRowClass" style="border-bottom: #2ACDC9 1px solid;">

                            <div style="width: 30px; position: absolute; left: 0px; z-index: 999; top: 5px;" v-if="index > 0"><button style="background: #058683" type="button" class="AddBtn" v-on:Click="RemoveMovingJob(index)">-</button></div>

                            <div class="col-lg-4" style="background-color:#E9FFFF;">
                                <div class="row" style="margin:5px;">
                                    <div class="col-lg-6">Moving Date:</div>
                                    <div class="col-lg-6"><input type="date" name="moving_date[]" class="inputcontrolText MovingMovingDate" v-model="MovingData[index].MovingDate" @change="UpdatePrice()"></div> 
                                </div>
                                <div class="row" style="margin:5px;" v-if="index == 0">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-6" style="font-size: 10px;">
                                        <input type="radio" v-model="MovingData[index].Confirmed" :name="'MovingConfirmed['+index+']'" value="0"> To Be Confirmed<br>
                                        <input type="radio" v-model="MovingData[index].Confirmed" :name="'MovingConfirmed['+index+']'" value="1"> Confirmed
                                    </div> 
                                </div>

                                <div class="row" style="margin:5px;">   
                                    <div class="col-lg-6">
                                       Delivery Date:
                                    </div>    
                                    <div class="col-lg-6">
                                        <input type="date" name="delivery_date[]" class="inputcontrolText MovingDeliveryDate" v-model="MovingData[index].DeliveryDate" @change="UpdatePrice()">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" style="background-color:#E9FFFF; border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
    							
    							<div class="row" style="margin:5px;">
                                    <div class="col-lg-6">
                                        Arrival Time:
                                    </div>
                                    <div class="col-lg-3" style="padding-right: 0px;">
                                        <input type="text" name="moving_time[]" class="inputcontrolText" v-model="MovingData[index].ArrivalFrom">
                                    </div>
    								<div class="col-lg-3" style="padding-left: 0px;">
                                        <input type="text" name="moving_time_to[]" class="inputcontrolText" v-model="MovingData[index].ArrivalTo">
                                    </div>
                                </div> 
                            </div>
                            <div class="col-lg-4" style="background-color:#E9FFFF;">

                                <div class="row" style="margin:5px;" v-for="(Vehical, VIndex) in MovingData[index].TotalVehicals">
                                    <div class="col-lg-6" v-if="VIndex == 0">
                                        No Vehicles:
                                    </div>

                                    <div class="col-lg-6" v-if="VIndex > 0">&nbsp;</div>

                                    <div class="col-lg-4">
                                        <select class="inputcontrolText VechiclesSelectOption" :name="'MovingVehicle['+index+'][]'" v-model="MovingData[index].Vechicles[VIndex]" @change="UpdatePrice()">
                                           <option selected value="">select</option>
                                           <option value="maxi_mover">Maxi Mover</option>
                                           <option value="luton_van">Luton Van</option>
                                           <option value="low_loader">Low Loader</option>
                                           <option value="half_a_luton_van">Half a Luton Van</option>
                                       </select>
                                    </div> 
                                      <div class="col-lg-2" v-if="VIndex == 0">
                                          <button type="button" class="AddBtn" v-on:Click="AddExtraVehical(index, VIndex)">+</button>
                                      </div>
                                      <div class="col-lg-2" v-if="VIndex > 0">
                                          <button type="button" class="AddBtn" v-on:Click="RemoveExtraVehical(index, VIndex)">-</button>
                                      </div>
                                </div> 


                                <div class="row" style="margin-top:5px; margin-bottom:5px;">
                                    <div class="col-lg-6">
                                       No Porters:
                                    </div>    
                                    <div class="col-lg-4">
                                      <input type="number" name="porters_no[]" min="0" v-model="MovingData[index].NoPorters" class="inputcontrolText text-center">
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <button type="button" class="AddBtn" v-on:Click="ShowExtraPorters(index)">+</button>
                                    </div>
                                </div>
                                
                                <div class="row" v-if="MovingData[index].ExtraPorters"> 
                                    <div class="col-lg-6"> No Extra Porters:</div>
                                    <div class="col-lg-4">
                                      <input type="number" name="extra_porters_no[]" v-model="MovingData[index].NoExtraPorters" class="inputcontrolText text-center MovingExtraPorters" @change="UpdatePrice()">
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <button type="button" class="AddBtn" v-on:Click="RemoveExtraPorters(index)">-</button>
                                    </div>
                                </div>
                            </div>    
                        </div>
                </div> 
            </div>




            <div id="PackingJobSec">
                <div style="background-color: #2ACDC9; padding:10px 0px; margin-top:15px"> 
                    <div class="text-center text-white">
                        <b>Packaging Job</b>
                        <div class="float-left" style="margin-left: 10px;"><button style="background: #058683" type="button" class="AddBtn" v-on:Click="AddPacking">+</button></div>
                    </div>

                </div>
                
                <div v-for="(item, index) in TotalPackingJob">
                    <input type="hidden" name="ExitingPackageID[]" v-model="PackingData[index].ExtJobID">
                    <div class="col-lg-12" style="border-bottom: #2ACDC9 1px solid;">

                        <div v-if="index > 0" style="width: 30px; position: absolute; left: 0px; z-index: 999; top: 5px;"><button type="button" class="AddBtn" v-on:Click="RemovePacking(index)" style="background: #058683">-</button></div>

                        <div class="row">
                            <div class="col-lg-4" style="background-color:#E9FFFF; ">
                                
                                <div class="row" style="margin:5px;">   
                                    <div class="col-lg-6">
                                       Packaging Date:
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="date" name="packaging_date[]"  v-model="PackingData[index].PackingDate" class="inputcontrolText PackingPackingDate" @change="UpdatePrice()">
                                    </div>  
                                </div>
                            </div> 
                            <div class="col-lg-4" style="background-color:#E9FFFF; border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                                
                                <div class="row" style="margin:5px;">
                                    <div class="col-lg-6">
                                        Arrival Time:
                                    </div>
                                    <div class="col-lg-3" style="padding-right: 0px;">
                                        <input type="text" name="packing_time_from[]" class="inputcontrolText" v-model="PackingData[index].ArrivalFrom">
                                    </div>
                                    <div class="col-lg-3" style="padding-left: 0px;">
                                        <input type="text" name="packing_time_to[]" class="inputcontrolText" v-model="PackingData[index].ArrivalTo">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" style="background-color:#E9FFFF;">
                                <div class="row" style="margin:5px;">
                                    <div class="col-lg-6">
                                        No Packers:
                                    </div>
                                    <div class="col-lg-4">
                                         <input type="number" name="packers_no[]" id="packers_no" class="inputcontrolText text-center" v-model="PackingData[index].NoPackers">
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="AddBtn" v-on:Click="ShowExtraPackers(index)">+</button>
                                    </div>
                                </div>
                                
                                <div class="row" style="margin:5px;" v-if="PackingData[index].ShowExtra">
                                    <div class="col-lg-6"> No Extra Packers:
                                    </div>
                                    <div class="col-lg-4">
                                      <input type="number" name="extra_packers_no[]" v-model="PackingData[index].ExtraPacker" class="inputcontrolText text-center PackingExtraPackers"@change="UpdatePrice()">
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <button type="button" class="AddBtn" v-on:Click="RemoveExtraPackers(index)">-</button>
                                    </div>
                                </div>

                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>







            <div style="background-color: #2ACDC9; padding:10px 0px; margin-top:15px"> 
                <div class="text-center text-white">
                    <b>Extra Information</b>
                </div>
            </div>

            <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4" style="background-color:#E9FFFF;">
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
                                   Storage:
                                </div>
                                <div class="col-lg-6">
                                       <input type="text" name="storage" value="<?php echo e(@$Quote->storage); ?>" class="inputcontrolText text-center">
                                </div>  
                            </div>
                        </div>
                        <div class="col-lg-4" style="background-color:#E9FFFF; border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                            <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                   Insurance:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="insurance" value="<?php echo e(@$Quote->insurance); ?>" class="inputcontrolText text-center">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" style="background-color:#E9FFFF; ">
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Out by:
                                </div>    
                                <div class="col-lg-6">
                                  <input type="text" name="out_by" value="<?php echo e(@$Quote->out_by); ?>" class="inputcontrolText">
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
                       
                            <!--<div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    Cleaning Service:
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="cleaning_service" value="<?php echo e(@$Quote->cleaning_service); ?>" class="inputcontrolText text-center">
                                </div>
                            </div>  -->
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
							<input name="other_amount" class="form-control" id="other_amount" onBlur="CalculatePrice()" value="0">
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
                               <b id="ShowTotalPrice">£<?php echo e($Quote->final_payable_amount); ?></b>
                            </div>
							<input type="hidden" name="FinalAmount" id="FinalAmount" value="<?php echo e($Quote->final_payable_amount); ?>">
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
		var TotalVans = 0
		
		for(i = 0; i < JobApp.MovingData.length; i++){
            for(k = 0; k < JobApp.MovingData[i].Vechicles.length; k++){
                TotalVans++;

                var VchName = JobApp.MovingData[i].Vechicles[k];

    			if(VchName == "luton_van"){
                    TotalPrice += 500
                }

                if(VchName == "maxi_mover"){
                    TotalPrice += 700
                }

                if(VchName == "half_a_luton_van"){
                    TotalPrice += 350
                }

                if(VchName == "low_loader"){
                    TotalPrice += 600
                }
    		}
        }

        for(k = 0; k < app.PackingData.length; k++){
            if(app.PackingData[k].PackingDate != "" && app.PackingData[k].PackingDate != "0000-00-00"){
                CheckSame = 0;
                for(i = 0; i < JobApp.MovingData.length; i++){
                    if(JobApp.MovingData[i].MovingDate != ""){
                        if(app.PackingData[k].PackingDate == JobApp.MovingData[i].MovingDate){
                            CheckSame = 1;
                        }
                    }
                }

                if(CheckSame == 1){
                    TotalPrice += 250
                }else{
                    TotalPrice += 350
                }
            }
        }

        /*var PackagingDate = $("#PackagingDate").val()
        var MovingDate = $("#MovingDate").val()
		var DeliveryDate = $("#DeliveryDate").val()

        if(PackagingDate != ""){
            if(MovingDate != PackagingDate){
                TotalPrice += 350
            }else{
                TotalPrice += 250
            }
        }*/
		
        for(j = 0; j < JobApp.MovingData.length; j++){
            MovingDate = JobApp.MovingData[j].MovingDate;
            DeliveryDate = JobApp.MovingData[j].DeliveryDate;

            if(DeliveryDate != "" && DeliveryDate != "0000-00-00"){
        		if(DeliveryDate != MovingDate){
                    for(k = 0; k < JobApp.MovingData[j].Vechicles.length; k++){
                        TotalVans++;

                        var VchName = JobApp.MovingData[j].Vechicles[k];

                        if(VchName == "luton_van"){
                            TotalPrice += 495
                        }

                        if(VchName == "maxi_mover"){
                            TotalPrice += 495
                        }

                        if(VchName == "half_a_luton_van"){
                            TotalPrice += 495
                        }

                        if(VchName == "low_loader"){
                            TotalPrice += 495
                        }
                    }
        		}
            }
        };

        TotalExtrPort = 0;
        for(k = 0; k < JobApp.MovingData.length; k++){
            TotalExtrPort += parseInt(JobApp.MovingData[k].NoExtraPorters);
        }

        TotalExPackers = 0
        for(k = 0; k < app.PackingData.length; k++){
            TotalExPackers += parseInt(app.PackingData[k].ExtraPacker);
        }

        TotalPrice += TotalExtrPort * 110
        TotalPrice += TotalExPackers * 110

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

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
function DeleteQuote(){
	if(confirm("Are You Sure to Delete This Quote")){
		window.location = "<?php echo e(URL('DeleteQuote')); ?>?id=<?php echo e($QuoteID); ?>";
	}
}
	
function ApprovePMP(id, status){
	window.location = "<?php echo e(URL('ApprovePMP')); ?>?id="+id+"&status="+status;
}


var JobApp = new Vue({
    el: "#MovingJobSheet",
    delimiters: ['!{', '}!'],
    data: {
        TotalJob: 0,
        MovingData:[],
    },
    methods:{
        AddMovingJob:function(){
            this.TotalJob++;
            this.MovingData.push({MovingDate: "", Confirmed: -1, Vechicles: [""], TotalVehicals: 1, ArrivalFrom: "08:00 AM", ArrivalTo: "10:00 AM", DeliveryDate: "", NoPorters: 0, ExtraPorters: false, NoExtraPorters: 0, ExtJobID: ""})
            CalculatePrice();
        },
        ShowExtraPorters:function(index){
            this.MovingData[index].ExtraPorters = true
            CalculatePrice();
        },
        RemoveExtraPorters:function(index){
            this.MovingData[index].ExtraPorters = false
            this.MovingData[index].NoExtraPorters = 0
            CalculatePrice();
        },
        RemoveMovingJob:function(index){
            this.MovingData.splice(index, 1)
            this.TotalJob--;
            CalculatePrice();
        },
        AddExtraVehical:function(Index, VIndex){
            this.MovingData[Index].TotalVehicals++
            this.MovingData[Index].Vechicles.push("")
            CalculatePrice();
        },
        RemoveExtraVehical:function(Index, VIndex){
            this.MovingData[Index].TotalVehicals--
            this.MovingData[Index].Vechicles.splice(VIndex, 1)
            CalculatePrice();
        },
        UpdatePrice:function(){
          CalculatePrice();
        }
    }
})

var app = new Vue({
    el: '#PackingJobSec',
    data: {
        TotalPackingJob: 0,
        PackingData:[],
    },
    methods:{
        AddPacking:function(){
            this.TotalPackingJob++;
            this.PackingData.push({NoPackers: 0, ShowExtra: false, ExtraPacker: 0, ArrivalFrom: "08:00 AM", ArrivalTo: "10:00 AM",  PackingDate: "", ExtJobID: ""})
            CalculatePrice();
        },
        ShowExtraPackers:function(index){
            this.PackingData[index].ShowExtra = true
            CalculatePrice();
        },
        RemoveExtraPackers:function(index){
            this.PackingData[index].ShowExtra = false
            this.PackingData[index].ExtraPacker = 0
            CalculatePrice();
        },
        RemovePacking:function(index){
            this.PackingData.splice(index, 1)
            this.TotalPackingJob--;
            CalculatePrice();
        },
        UpdatePrice:function(){
          CalculatePrice();
        }
    }
})

<?php $__currentLoopData = $PackingJob; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $PKJ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
checktrue = false
<?php if($PKJ->packing_job_extra_packers > 0): ?>
checktrue = true
<?php endif; ?>

app.PackingData.push({NoPackers: <?php echo e($PKJ->packing_job_no_packers); ?>, ShowExtra: checktrue, ExtraPacker: <?php echo e($PKJ->packing_job_extra_packers); ?>, ArrivalFrom: '<?php echo e($PKJ->packing_job_arrival_from); ?>', ArrivalTo: '<?php echo e($PKJ->packing_job_arrival_to); ?>',  PackingDate: '<?php echo e($PKJ->packing_job_date); ?>', ExtJobID: "<?php echo e($PKJ->packing_job_id); ?>" })
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
app.TotalPackingJob = <?php echo e(count($PackingJob)); ?>


<?php if(count($PackingJob) == 0): ?>
app.TotalPackingJob = 1;
app.PackingData.push({NoPackers: 0, ShowExtra: false, ExtraPacker: 0, ArrivalFrom: "08:00 AM", ArrivalTo: "10:00 AM",  PackingDate: "", ExtJobID: ""})
<?php endif; ?>





<?php $__currentLoopData = $MovingJob; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $PKJ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
var checktrue = false
var Vehicles = Array()


<?php if($PKJ->moving_job_extra_porters > 0): ?>
checktrue = true
<?php endif; ?>


<?php
$VeAr = explode(",", $PKJ->moving_job_vehicles);
?>
<?php $__currentLoopData = $VeAr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $V): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    Vehicles.push("<?php echo e($V); ?>");
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


TotalVeh = Vehicles.length

if(Vehicles.length == 0){
    TotalVeh = 1
    Vehicles[0] = "";
}

JobApp.MovingData.push({MovingDate: "<?php echo e($PKJ->moving_job_moving_date); ?>", Confirmed: <?php echo e($PKJ->moving_job_confirmed); ?>, Vechicles: Vehicles, TotalVehicals: TotalVeh, ArrivalFrom: "<?php echo e($PKJ->moving_job_arrival_from); ?>", ArrivalTo: "<?php echo e($PKJ->moving_job_arrival_to); ?>", DeliveryDate: "<?php echo e($PKJ->moving_job_delivery_date); ?>", NoPorters: "<?php echo e($PKJ->moving_job_no_porters); ?>", ExtraPorters: checktrue, NoExtraPorters: "<?php echo e($PKJ->moving_job_extra_porters); ?>", ExtJobID: "<?php echo e($PKJ->moving_job_id); ?>" })
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
JobApp.TotalJob = <?php echo e(count($MovingJob)); ?>



<?php if(count($MovingJob) == 0): ?>
JobApp.TotalJob = 1;
JobApp.MovingData.push({MovingDate: "", Confirmed: -1, Vechicles: [""], TotalVehicals: 1, ArrivalFrom: "08:00 AM", ArrivalTo: "10:00 AM", DeliveryDate: "", NoPorters: 0, ExtraPorters: false, NoExtraPorters: 0, ExtJobID: ""})
<?php endif; ?>
</script>

</body>
</html>
<?php /**PATH /opt/lampp/htdocs/corner/resources/views/personal_move_plan.blade.php ENDPATH**/ ?>