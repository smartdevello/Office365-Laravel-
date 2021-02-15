<!DOCTYPE html>
<html>
<head>
	<style>
		body{
			font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
			font-size: 12px;
			font-weight: 400;
		}
	</style>
</head>
<body>
	<img src="<?php echo e(URL('public/header.jpeg')); ?>" style="width:100%; height: 150px;">
	<div style="clear:both">&nbsp;</div>
	
	<div style="font-size:30px; text-align: center"><b>Service Match - <?php echo e($Quote->id); ?></b></div>

	<?php
	$GetTotalVechile = explode(",", $Quote->vehicles_no);
	$FirstValue = "";
	if(isset($GetTotalVechile[0])){
		$FirstValue = $GetTotalVechile[0];
	}
	?>
	
	<div style="margin-top: 10px; background-color:#E9FFFF; padding: 10px;">
		<div style="background-color: #2ACDC9; padding:5px 0px; text-align: center; color: #FFF">
			<div style="float: left; width: 30%">&nbsp;</div>
			<div style="float: left; width: 30%"><b>Our Service</b></div>
			<div style="float: left; width: 30%"><b>Competition</b></div>
			<div style="clear: both"></div>
		</div>
		<table width="100%" cellpadding="0" cellspaceing="0" border="0">
			<tr>
				<td width="30%"><b>Survey Date:</b></td>
				<td width="30%"><?php echo e(@$Quote->survey_date); ?></td>
				<td width="30%"><?php echo e(@$ServiceObject->SurveyDate); ?></td>
			</tr>
			
			<tr>
				<td><b>From:</b></td>
				<td><?php echo e(@$Quote->pickup_postcode); ?></td>
				<td><?php echo e(@$ServiceObject->From); ?></td>
			</tr>


			<tr>
				<td><b>Building:</b></td>
				<td><?php echo e(@$Quote->pickup_building); ?></td>
				<td><?php echo e(@$ServiceObject->Building); ?></td>
			</tr>

			<tr>
				<td><b>Access:</b></td>
				<td><?php echo e(@$Quote->pickup_access); ?></td>
				<td><?php echo e(@$ServiceObject->Access); ?></td>
			</tr>

			<tr>
				<td><b>Parking:</b></td>
				<td><?php echo e(@$Quote->pickup_parking); ?></td>
				<td><?php echo e(@$ServiceObject->Parking); ?></td>
			</tr>

			<tr>
				<td><b>To:</b></td>
				<td><?php echo e(@$Quote->delivery_postcode); ?></td>
				<td><?php echo e(@$ServiceObject->To); ?></td>
			</tr>

			<tr>
				<td><b>Building:</b></td>
				<td><?php echo e(@$Quote->delivery_building); ?></td>
				<td><?php echo e(@$ServiceObject->ToBuilding); ?></td>
			</tr>
			
			<tr>
				<td><b>Access:</b></td>
				<td><?php echo e(@$Quote->delivery_access); ?></td>
				<td><?php echo e(@$ServiceObject->ToAccess); ?></td>
			</tr>

			<tr>
				<td><b>Parking:</b></td>
				<td><?php echo e(@$Quote->delivery_parking); ?></td>
				<td><?php echo e(@$ServiceObject->ToParking); ?></td>
			</tr>

			<tr>
				<td><b>Total Volume:</b></td>
				<td><?php echo e(number_format($Survey->total_volume, 2)); ?></td>
				<td><?php echo e(@$ServiceObject->TotalVolume); ?></td>
			</tr>

			<tr>
				<td><b>Vehicles:</b></td>
				<td><?php echo e($Quote->vehicles_no); ?></td>
				<td><?php echo e(@$ServiceObject->Vehicles); ?></td>
			</tr>


			<tr>
				<td><b>No Porters:</b></td>
				<td><?php echo e(@$Quote->porters_no); ?></td>
				<td><?php echo e(@$ServiceObject->NoPorters); ?></td>
			</tr>

			<tr>
				<td><b>No Extra Porters:</b></td>
				<td><?php echo e(@$Quote->extra_porters_no); ?></td>
				<td><?php echo e(@$ServiceObject->ExtraPorters); ?></td>
			</tr>



			<tr>
				<td><b>No Packers:</b></td>
				<td><?php echo e(@$Quote->packers_no); ?></td>
				<td><?php echo e(@$ServiceObject->NoPackers); ?></td>
			</tr>


			<tr>
				<td><b>No Extra Packers:</b></td>
				<td><?php echo e(@$Quote->extra_packers_no); ?></td>
				<td><?php echo e(@$ServiceObject->ExtraPackers); ?></td>
			</tr>



			<tr>
				<td><b>Moving Date:</b></td>
				<td><?php echo e(@$Quote->moving_date); ?></td>
				<td><?php echo e(@$ServiceObject->MovingDate); ?></td>
			</tr>


			<tr>
				<td><b>Arrival Time:</b></td>
				<td><?php echo e(@$Quote->moving_time); ?></td>
				<td><?php echo e(@$ServiceObject->ArrivalTime); ?></td>
			</tr>

			<tr>
				<td><b>Delivery Date:</b></td>
				<td><?php echo e(@$Quote->delivery_date); ?></td>
				<td><?php echo e(@$ServiceObject->DeliveryDate); ?></td>
			</tr>

			<tr>
				<td><b>Packaging Date:</b></td>
				<td><?php echo e(@$Quote->packaging_date); ?></td>
				<td><?php echo e(@$ServiceObject->PackagingDate); ?></td>
			</tr>

			<tr>
				<td><b>Waiting time:</b></td>
				<td><?php echo e(@$Quote->waiting_time); ?></td>
				<td><?php echo e(@$ServiceObject->WaitingTime); ?></td>
			</tr>


			<tr>
				<td><b>Out by:</b></td>
				<td><?php echo e(@$Quote->out_by); ?></td>
				<td><?php echo e(@$ServiceObject->OutBy); ?></td>
			</tr>

			<tr>
				<td><b>Storage:</b></td>
				<td><?php echo e(@$Quote->storage); ?></td>
				<td><?php echo e(@$ServiceObject->Storage); ?></td>
			</tr>

			<tr>
				<td><b>Insurance:</b></td>
				<td><?php echo e(@$Quote->insurance); ?></td>
				<td><?php echo e(@$ServiceObject->Insurance); ?></td>
			</tr>

			<tr>
				<td><b>Loading/Unloading, Mileage:</b></td>
				<td><?php echo e(@$Quote->loading_mileage); ?></td>
				<td><?php echo e(@$ServiceObject->LoadingMilage); ?></td>
			</tr>

			<tr>
				<td><b>Packaging Materials:</b></td>
				<td><?php echo e(@$Quote->packaging_materials); ?></td>
				<td><?php echo e(@$ServiceObject->PackingMaterial); ?></td>
			</tr>

			<tr>
				<td><b>Packaging Service:</b></td>
				<td><?php echo e(@$Quote->packaging_services); ?></td>
				<td><?php echo e(@$ServiceObject->PackagingService); ?></td>
			</tr>

			<tr>
				<td><b>Unpacking Service:</b></td>
				<td><?php echo e(@$Quote->unpacking_service); ?></td>
				<td><?php echo e(@$ServiceObject->UnpackingService); ?></td>
			</tr>

			<tr>
				<td><b>Heavy Items:</b></td>
				<td><?php echo e(@$Quote->heavy_items); ?></td>
				<td><?php echo e(@$ServiceObject->HeavyItem); ?></td>
			</tr>

			<tr>
				<td><b>Dismantling service:</b></td>
				<td><?php echo e(@$Quote->dismantling_service); ?></td>
				<td><?php echo e(@$ServiceObject->DismantlingService); ?></td>
			</tr>

			<tr>
				<td><b>Assembly service:</b></td>
				<td><?php echo e(@$Quote->assembly_service); ?></td>
				<td><?php echo e(@$ServiceObject->AssemblyService); ?></td>
			</tr>

			<tr>
				<td><b>Disposal service:</b></td>
				<td><?php echo e(@$Quote->disposal_service); ?></td>
				<td><?php echo e(@$ServiceObject->DisposalService); ?></td>
			</tr>

			<tr>
				<td><b>Cleaning service:</b></td>
				<td><?php echo e(@$Quote->cleaning_service); ?></td>
				<td><?php echo e(@$ServiceObject->CleaningService); ?></td>
			</tr>

			<tr>
				<td><b>Special Instruction:</b></td>
				<td><?php echo e(@$Quote->special_instructions); ?></td>
				<td><?php echo e(@$ServiceObject->SpecialInstruction); ?></td>
			</tr>
		</table>
</div>

<div style="clear: both">&nbsp;</div>

<div style="width: 100%; margin-top: 10px;"><img src="<?php echo e(URL('public/footer.JPG')); ?>" style="width:100%; height: 100px"></div>
</body>
</html><?php /**PATH /var/www/vhosts/cornerstoneremovals.co.uk/dev1.cornerstoneremovals.co.uk/resources/views/ServiceTemplate/PDFView.blade.php ENDPATH**/ ?>