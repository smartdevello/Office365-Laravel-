<?php echo $__env->make("header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
$GetClient = App\Model\Client::find($Survey->client_id);
?>

    <div class="container">
        <div >
            <img src="<?php echo e(URL('public/header.jpeg')); ?>" style="width:100%; height: 100%;">
        </div>
		
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
			<a class="nav-link" href="<?php echo e(URL('personal_move_plan')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($AlQ->id); ?>">Plan <?php echo e($AlQ->id); ?> - <?php echo e($AlQ->plan_name); ?></a>
		  </li>
			
			<?php
			$CheckForService = App\Model\ServiceMatch::where("service_match_qid", $AlQ->id)->where("is_delete", 0)->count();
			?>
			
			<?php if($CheckForService > 0): ?>
			<li class="nav-item">
			<a class="nav-link  <?php if($QuoteID == $AlQ->id): ?> active <?php endif; ?>" href="<?php echo e(URL('ServiceTemplate')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($AlQ->id); ?>">Service Match <?php echo e($AlQ->id); ?></a>
		  </li>
			<?php endif; ?>
			
			<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
		
		<div class="clearfix">&nbsp;</div>
        <?php echo Form::open(['url'=>'ServiceTemplateSave', 'enctype' => 'multipart/form-data', 'method'=>'post']); ?>

		
		<?php if(isset($ServiceObject->service_match_id)): ?>
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a onClick="DeleteQuote()"><button type="button" class="btn btn-danger">Delete</button></a>
        </div>
		<?php endif; ?>
		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<button type="submit" class="btn btn-primary inputbtn">Save</button>
		</div>
		
		<?php if(isset($ServiceObject->service_match_id)): ?>
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="<?php echo e(URL('MailServiceTemplate')); ?>?id=<?php echo e($_GET['id']); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" class="btn btn-success">Mail PDF</button></a>
		</div>

		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="<?php echo e(URL('ValidateServiceMatch')); ?>?id=<?php echo e(encrypt($_GET['id'])); ?>&QuoteID=<?php echo e(encrypt($ServiceObject->service_match_id)); ?>" target="_blank"><button type="button" class="btn btn-danger">Generate Link</button></a>
		</div>
		<?php endif; ?>
		
		<div class="float-right" style="margin-right: 50px; margin-top: 30px;">
			<a href="<?php echo e(URL('CustomQuote')); ?>?survey=<?php echo e($_GET['id']); ?>&client=<?php echo e($GetClient->client_id); ?>&QuoteID=<?php echo e($_GET['QuoteID']); ?>"><button type="button" class="btn btn-info inputbtn">Survey</button></a>
		</div>
		
		
		<div class="clearfix">&nbsp;</div>
		<div class="clearfix">&nbsp;</div>
		
		<div class="clearfix"></div>
		
            <div  style="margin-top:30px;">
                <div class="text-center">
                    <div style="font-size:30px;">
                    <b>Service Match Template : <?php echo e($_GET['QuoteID']); ?></b>
                </div>    
            </div>  
            
            <input type="hidden" name="qid" value="<?php echo e($Quote->id); ?>">
			<input type="hidden" name="sid" value="<?php echo e($Quote->survey_id); ?>">

            <div class="col-lg-12" style="margin-top: 20px;background-color:#E9FFFF;">
                <div style="padding-top:8px;">
					<div class="row" style="background-color: #2ACDC9; padding:10px; color: #FFF">
						<div class="col-4"></div>
						<div class="col-4">Our Service</div>
						<div class="col-4">Competition</div>
					</div>
					
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Survey Date:</b></div>
						<div class="col-4"><?php echo e(@$Quote->survey_date); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="SurveyDate" value="<?php echo e(@$ServiceObject->SurveyDate); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>From:</b></div>
						<div class="col-4"><?php echo e(@$Quote->pickup_postcode); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="From" value="<?php echo e(@$ServiceObject->From); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Building:</b></div>
						<div class="col-4"><?php echo e(@$Quote->pickup_building); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="Building" value="<?php echo e(@$ServiceObject->Building); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Access:</b></div>
						<div class="col-4"><?php echo e(@$Quote->pickup_access); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="Access" value="<?php echo e(@$ServiceObject->Access); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Parking:</b></div>
						<div class="col-4"><?php echo e(@$Quote->pickup_parking); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="Parking" value="<?php echo e(@$ServiceObject->Parking); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>To:</b></div>
						<div class="col-4"><?php echo e(@$Quote->delivery_postcode); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="To" value="<?php echo e(@$ServiceObject->To); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Building:</b></div>
						<div class="col-4"><?php echo e(@$Quote->delivery_building); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="ToBuilding" value="<?php echo e(@$ServiceObject->ToBuilding); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Access:</b></div>
						<div class="col-4"><?php echo e(@$Quote->delivery_access); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="ToAccess" value="<?php echo e(@$ServiceObject->ToAccess); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Parking:</b></div>
						<div class="col-4"><?php echo e(@$Quote->delivery_parking); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="ToParking" value="<?php echo e(@$ServiceObject->ToParking); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
                    
					<div class="row">
						<div class="col-4"><b>Total Volume:</b></div>
						<div class="col-4"><?php echo e(number_format($Survey->total_volume, 2)); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="TotalVolume" value="<?php echo e(@$ServiceObject->TotalVolume); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Vehicles:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteVehicles" value="<?php echo e($Quote->vehicles_no); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="Vehicles" value="<?php echo e(@$ServiceObject->Vehicles); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Porters:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteNoPorters" value="<?php echo e(@$Quote->porters_no); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="NoPorters" value="<?php echo e(@$ServiceObject->NoPorters); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>No Extra Porters:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteExtraPorters" value="<?php echo e(@$Quote->extra_porters_no); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="ExtraPorters" value="<?php echo e(@$ServiceObject->ExtraPorters); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Packers:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteNoPackers" value="<?php echo e(@$Quote->packers_no); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="NoPackers" value="<?php echo e(@$ServiceObject->NoPackers); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>No Extra Packers:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteNoExtraPackers" value="<?php echo e(@$Quote->extra_packers_no); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="ExtraPackers" value="<?php echo e(@$ServiceObject->ExtraPackers); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Moving Date:</b></div>
						<div class="col-4"><input type="date" class="form-control" name="QuoteMovingDate" value="<?php echo e(@$Quote->moving_date); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="MovingDate" value="<?php echo e(@$ServiceObject->MovingDate); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Arrival Time:</b></div>
						<div class="col-4"><input type="text" class="form-control" name="QuoteArrivalTime" value="<?php echo e(@$Quote->moving_time); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="ArrivalTime" value="<?php echo e(@$ServiceObject->ArrivalTime); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Delivery Date:</b></div>
						<div class="col-4"><input type="date" class="form-control" name="QuoteDeliveryDate" value="<?php echo e(@$Quote->delivery_date); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="DeliveryDate" value="<?php echo e(@$ServiceObject->DeliveryDate); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Date:</b></div>
						<div class="col-4"><input type="date" class="form-control" name="QuotePackagingDate" value="<?php echo e(@$Quote->packaging_date); ?>"></div>
						<div class="col-4"><input type="text" class="form-control" name="PackagingDate" value="<?php echo e(@$ServiceObject->PackagingDate); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Waiting time:</b></div>
						<div class="col-4"><?php echo e(@$Quote->waiting_time); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="WaitingTime" value="<?php echo e(@$ServiceObject->WaitingTime); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Out by:</b></div>
						<div class="col-4"><?php echo e(@$Quote->out_by); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="OutBy" value="<?php echo e(@$ServiceObject->OutBy); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Storage:</b></div>
						<div class="col-4"><?php echo e(@$Quote->storage); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="Storage" value="<?php echo e(@$ServiceObject->Storage); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Insurance:</b></div>
						<div class="col-4"><?php echo e(@$Quote->insurance); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="Insurance" value="<?php echo e(@$ServiceObject->Insurance); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Loading/Unloading, Mileage:</b></div>
						<div class="col-4"><?php echo e(@$Quote->loading_mileage); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="LoadingMilage" value="<?php echo e(@$ServiceObject->LoadingMilage); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Materials:</b></div>
						<div class="col-4"><?php echo e(@$Quote->packaging_materials); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="PackingMaterial" value="<?php echo e(@$ServiceObject->PackingMaterial); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Packaging Service:</b></div>
						<div class="col-4"><?php echo e(@$Quote->packaging_services); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="PackagingService" value="<?php echo e(@$ServiceObject->PackagingService); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Unpacking Service:</b></div>
						<div class="col-4"><?php echo e(@$Quote->unpacking_service); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="UnpackingService" value="<?php echo e(@$ServiceObject->UnpackingService); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Heavy Items:</b></div>
						<div class="col-4"><?php echo e(@$Quote->heavy_items); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="HeavyItem" value="<?php echo e(@$ServiceObject->HeavyItem); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Dismantling service:</b></div>
						<div class="col-4"><?php echo e(@$Quote->dismantling_service); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="DismantlingService" value="<?php echo e(@$ServiceObject->DismantlingService); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					<div class="row">
						<div class="col-4"><b>Assembly service:</b></div>
						<div class="col-4"><?php echo e(@$Quote->assembly_service); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="AssemblyService" value="<?php echo e(@$ServiceObject->AssemblyService); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Disposal service:</b></div>
						<div class="col-4"><?php echo e(@$Quote->disposal_service); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="DisposalService" value="<?php echo e(@$ServiceObject->DisposalService); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Cleaning service:</b></div>
						<div class="col-4"><?php echo e(@$Quote->cleaning_service); ?></div>
						<div class="col-4"><input type="text" class="form-control" name="CleaningService" value="<?php echo e(@$ServiceObject->CleaningService); ?>"></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					
					
					<div class="row">
						<div class="col-4"><b>Special Instruction:</b></div>
						<div class="col-4"><?php echo e(@$Quote->special_instructions); ?></div>
						<div class="col-4"><textarea type="text" class="form-control" name="SpecialInstruction"><?php echo e(@$ServiceObject->SpecialInstruction); ?></textarea></div>
					</div>
					<div class="clearfix">&nbsp;</div>
					

         <?php echo Form::close(); ?>

	</div>
			
				</div>
				
				
					<div style="width: 100%; margin-top: 20px;">
            <img src="<?php echo e(URL('public/footer.JPG')); ?>" style="width:100%; height: 100%;">
        </div>   
				
				<div class="clearfix">&nbsp;</div>
				<h1>Service Match History</h1>
				<table class="table table-bordered table-stripped">
					<thead>
						<tr>
							<td>Service No.</td>
							<td>Created At</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody>
						<?php $__currentLoopData = $AllQuote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $QInd => $AlQ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($QInd + 1); ?></td>
							<td><?php echo e(date("d F, Y", strtotime($AlQ->created_at))); ?></td>
							<td><?php echo e($AlQ->is_delete == 0 ? "Active" : "Deleted"); ?></td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
<script>
function DeleteQuote(){
	if(confirm("Are You Sure to Delete This Service Template")){
		window.location = "<?php echo e(URL('DeleteService')); ?>?id=<?php echo e($QuoteID); ?>";
	}
}	
</script>
</body>
</html>
<?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/ServiceTemplate/View.blade.php ENDPATH**/ ?>