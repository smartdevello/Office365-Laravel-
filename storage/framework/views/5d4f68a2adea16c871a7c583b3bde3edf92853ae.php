<!DOCTYPE html>
<html>
<head>
    <title>Clinet View</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="<?php echo e(URL('public/style.css')); ?>"/>
</head>
<body>
<div class="clearfix">&nbsp;</div>
<div class="container">
        <div >
            <img src="<?php echo e(URL('public/header.jpeg')); ?>" style="width:100%; height: 100%;">
        </div>
		<div class="clearfix">&nbsp;</div>
	
	<?php if($CheckForConfirm == 0): ?>
	<p><b>Note:</b> Our clients confirm they move on the live calendar, even if they don't have a confirmed date, for the following reasons: </p>
	<p>- To make sure they have a company that can move them when the time comes.</p>
	<p>- They can move their date as many times as they need, FREE of charges with a 72h notice.</p>
	<p>- Avoide last-minute booking charges or unavailability.</p>
	<?php else: ?>
	
	<p>In order to book your move on the live calendar there is £50 deposit fee (including in final quote)</p>
	<a href="<?php echo e(URL('MakeClientPayment')); ?>?SurveyID=<?php echo e(@$_GET['SurveyID']); ?>&QuoteID=<?php echo e(@$_GET['QuoteID']); ?>"><button class="btn btn-success">Confirm Your Booking Now</button></a>
	<?php endif; ?>
	
	<div class="clearfix">&nbsp;</div>
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
			<a class="nav-link <?php if($QuoteID == $AlQ->id): ?> active <?php endif; ?>" href="<?php echo e(URL('ValidateClient')); ?>?SurveyID=<?php echo e($_GET['SurveyID']); ?>&QuoteID=<?php echo e($AlQ->id); ?>">Plan <?php echo e($QInd +1); ?> - <?php echo e($AlQ->plan_name); ?></a>
		  </li>
			<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
		
	<?php echo Form::open(['url'=>'change-status', 'enctype' => 'multipart/form-data', 'id' => 'myform', 'method'=>'post']); ?>

	<input type="hidden" name="qid" value="<?php echo e($Quote->id); ?>">
		<div class="clearfix">&nbsp;</div>
		<div class="text-center">
			Would you like to confirm this Personal Move Plan on the Live Calendar? &nbsp;&nbsp;
			<input onClick="$('#myform').submit()" value="1" name="JobConfimed" <?php if($Quote->client_confrim == "1"): ?> checked <?php endif; ?> type="radio"> Yes
			<input onClick="$('#myform').submit()" value="0" name="JobConfimed" <?php if($Quote->client_confrim == "0"): ?> checked <?php endif; ?> type="radio"> No
			<input onClick="$('#myform').submit()" value="2" name="JobConfimed" <?php if($Quote->client_confrim == "2"): ?> checked <?php endif; ?> type="radio"> Later
		</div>
	<?php echo Form::close(); ?>

		
		<div class="clearfix">&nbsp;</div>
	<?php
	$GetTotalVechile = explode(",", $Quote->vehicles_no);
	$FirstValue = "";
	if(isset($GetTotalVechile[0])){
		$FirstValue = $GetTotalVechile[0];
	}
	?>
	
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
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->survey_date); ?></span></div>
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6" >
									<b>Surveyor:</b>
                                </div>
                                <div class="col-lg-6">
									<span style="font-size:14px;"><?php echo e($Quote->surveyor); ?></span>
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-4" style="border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                             <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                  <b>From:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->pickup_postcode); ?></span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                  <b>Building:</b>
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->pickup_building); ?></span></div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                     <b>Access:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->pickup_access); ?></span></div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    <b>Parking:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->pickup_parking); ?></span></div>
                            </div>         
                        </div>
                        <div class="col-md-4" >
                            <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    <b>To:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->delivery_postcode); ?></span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   <b>Building:</b>
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->delivery_building); ?></span></div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    <b>Access:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->delivery_access); ?></span></div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    <b>Parking:</b>
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->delivery_parking); ?></span></div>
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
                                <div class="col-lg-6">
                                    No Vehicles:
                                </div>
								  <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->vehicles_no); ?></span></div>
							</div>
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   No Porters:
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->porters_no); ?></span></div>
                            </div>
							
							<div class="row" style="margin:5px; <?php if($Quote->extra_porters_no == 0): ?> display: none <?php endif; ?>">
                                <div class="col-lg-6"> No Extra Porters:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->extra_porters_no); ?></span></div>
                            </div> 
							
							
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    No Packers:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->packers_no); ?></span></div>
                            </div>
							
							<div class="row" style="margin:5px; <?php if($Quote->extra_packers_no == 0): ?> display: none <?php endif; ?>" id="ExtraPakersDiv">   
                                <div class="col-lg-6"> No Extra Packers:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->extra_packers_no); ?></span></div>
                            </div> 
							
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    No Cleaners:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->cleaners_no); ?></span></div>
                            </div>                    
                        </div>
                        <div class="col-lg-4" style="background-color:#E9FFFF; border-left: #FFF 5px solid; border-right: #FFF 5px solid;">
                                 <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    Moving Date:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->moving_date); ?></span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Delivery Date:
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->delivery_date); ?></span></div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Packaging Date:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->packaging_date); ?></span></div>
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                   Cleaning Date:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e($Quote->cleaning_date); ?></span></div>
                            </div>  
                        </div>
                        <div class="col-lg-4" style="background-color:#E9FFFF; ">
                              <div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                    Waiting time:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->waiting_time); ?></span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Out by:
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->out_by); ?></span></div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Storage:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->storage); ?></span></div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                   Insurance:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->insurance); ?></span></div>
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
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->loading_mileage); ?></span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                  Packaging Materials:
                                </div>    
								<div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->packaging_materials); ?></span></div>
                            </div>     
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    Packaging Service:
                                </div>
								<div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->packaging_services); ?></span></div>
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    Unpacking Service:
                                </div>
								<div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->unpacking_service); ?></span>
                                </div>
                            </div>  
                       
                      
    						</div>
                            <div class="col-lg-6" style="background-color:#E9FFFF;padding-right:5px; ">
    							<div class="row" style="margin:5px;">
                                <div class="col-lg-6">
                                   Heavy Items:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->heavy_items); ?></span></div> 
                            </div> 
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                   Dismantling service:
                                </div>    
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->dismantling_service); ?></span></div>
                            </div>
                            <div class="row" style="margin:5px;">   
                                <div class="col-lg-6">
                                    Assembly service:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->assembly_service); ?></span>
                                </div>  
                            </div>
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                  Disposal Service:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->disposal_service); ?></span>
                                </div>
                            </div>  
                       
                            <div class="row" style="margin:5px;">         
                                <div class="col-lg-6">
                                    Cleaning Service:
                                </div>
                                <div class="col-lg-6"><span style="font-size:14px;"><?php echo e(@$Quote->cleaning_service); ?></span>
                                </div>
                            </div>  
    						</div>  
                        </div>
                    </div>    

                </div>        
            </div> 


            <div  style="margin-top: 20px;">
                <div class="col-lg-12"  style="background-color:#E9FFFF; padding-bottom: 10px" >
                    <div style="padding-top:8px;">
                        <div class="container" style="background-color: #2ACDC9; padding:10px 0px;"> 
                            <div class="text-center text-white">
                                <b>Special Instructions</b>
                            </div>

                        </div>
                        <p style="font-size: 14px; margin-top:10px; margin-bottom:30px;"><?php echo e(@$Quote->special_instructions); ?></p>
                    </div>    
                </div>        
            </div>    

            <div  style="margin-top: 30px;">
                <div class="container" style="background-color:#2ACDC9;">
                    <div class="row" >
                        <div class="col-lg-7">
                            <div style="margin-left:150px; margin-top: 20px; margin-bottom: 20px;">
                                <div style="font-size: 15px; color:#fff;" >Our standard package quote for your move is:</div>

                                <div style="font-size: 14px; color:#fff;" ><i>All Inclusive, No Hidden Fees, Price Match Guarantee + 10% Off</i></div>

                                <div style="font-size: 15px; color:#fff;" >Free updates / cancellations up to 72h before the move:</div>
                            </div>   
                               
                        </div>
                        <div class="col-lg-5">
                            <div class="text-white" style="font-size:60px;">
                               <b id="ShowTotalPrice">£<?php echo e(number_format($TotalPrice, 2)); ?></b>
                            </div>    
                        </div>    
                    </div>    
                </div>    
            </div>  

         <?php echo Form::close(); ?>

        <div style="width: 100%; margin-top: 20px;">
            <img src="<?php echo e(URL('public/footer.JPG')); ?>" style="width:100%; height: 100%;">
        </div>
	<div class="clearfix">&nbsp;</div>
</div>
</body>
</html><?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/ClientQuoteView.blade.php ENDPATH**/ ?>