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
	
	<div style="font-size:30px; text-align: center"><b>Personal Move Plan - <?php echo e($Quote->plan_name); ?></b></div>

	<?php
	$GetTotalVechile = explode(",", $Quote->vehicles_no);
	$FirstValue = "";
	if(isset($GetTotalVechile[0])){
		$FirstValue = $GetTotalVechile[0];
	}
	?>
	
	<div style="margin-top: 10px; background-color:#E9FFFF; padding: 10px;">
		<div style="background-color: #2ACDC9; padding:5px 0px; text-align: center; color: #FFF"> <b>Job Details</b></div>
		<table width="100%" cellpadding="0" cellspaceing="0" border="0">
			<tr>
				<td width="33%">
					<table width="100%" cellpadding="2" cellspaceing="0" border="0">
						<tr>
							<td width="50%"><b>Job ID:</b></td>
							<td width="50%"><?php echo e($Quote->id); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Customer Name:</b></td>
							<td width="50%"><?php echo e($Survey->first_name." " . $Survey->last_name); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Survey Date:</b></td>
							<td width="50%"><?php echo e(date("d/m/Y", strtotime($Quote->survey_date))); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Surveyor:</b></td>
							<td width="50%"><?php echo e($Quote->surveyor); ?></td>
						</tr>
					</table>
				</td>

				<td width="33%" style="border-left: #FFF 5px solid; border-right: #FFF 5px solid">
					<table width="100%" cellpadding="2" cellspaceing="0" border="0">
						<tr>
							<td width="50%"><b>From:</b></td>
							<td width="50%"><?php echo e($Quote->pickup_postcode); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Building:</b></td>
							<td width="50%"><?php echo e($Quote->pickup_building); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Access:</b></td>
							<td width="50%"><?php echo e($Quote->pickup_access); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Parking:</b></td>
							<td width="50%"><?php echo e($Quote->pickup_parking); ?></td>
						</tr>
					</table>
				</td>

				<td width="33%">
					<table width="100%" cellpadding="2" cellspaceing="0" border="0">
						<tr>
							<td width="50%"><b>To:</b></td>
							<td width="50%"><?php echo e($Quote->delivery_postcode); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Building:</b></td>
							<td width="50%"><?php echo e($Quote->delivery_building); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Access:</b></td>
							<td width="50%"><?php echo e($Quote->delivery_access); ?></td>
						</tr>

						<tr>
							<td width="50%"><b>Parking:</b></td>
							<td width="50%"><?php echo e($Quote->delivery_parking); ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<div style="height: 5px; background: #FFF"></div>

		<table width="100%" cellpadding="0" cellspaceing="0" border="0">
			<tr>
				<td width="33%">
					<table width="100%" cellpadding="2" cellspaceing="0" border="0">
						<tr>
							<td width="50%"><b>No Vehicles:</b></td>
							<td width="50%">
								<?php if($FirstValue == "maxi_mover"): ?>
								Maxi Mover
								<?php elseif($FirstValue == "luton_van"): ?>
								Luton Van
								<?php elseif($FirstValue == "low_loader"): ?>
								Low Loader
								<?php elseif($FirstValue == "half_a_luton_van"): ?>
								Half a Luton Van
								<?php endif; ?>
							</td>
						</tr>
						<?php for($k = 1; $k < count($GetTotalVechile); $k++): ?>
																  <tr>
						<td width="50%"></td>
						<td width="50%">
							<?php if($GetTotalVechile[$k] == "maxi_mover"): ?>
							Maxi Mover
							<?php elseif($GetTotalVechile[$k] == "luton_van"): ?>
							Luton Van
							<?php elseif($GetTotalVechile[$k] == "low_loader"): ?>
							Low Loader
							<?php elseif($GetTotalVechile[$k] == "half_a_luton_van"): ?>
							Half a Luton Van
							<?php endif; ?>
						</td>
						</tr>
					<?php endfor; ?>

					<tr>
						<td width="50%"><b>No Porters:</b></td>
						<td width="50%"><?php echo e($Quote->porters_no); ?></td>
					</tr>

					<?php if($Quote->extra_porters_no != 0): ?>
					<tr>
						<td width="50%"><b>No Extra Porters:</b></td>
						<td width="50%"><?php echo e($Quote->extra_porters_no); ?></td>
					</tr>
					<?php endif; ?>

					<tr>
						<td width="50%"><b>No Packers:</b></td>
						<td width="50%"><?php echo e($Quote->packers_no); ?></td>
					</tr>

					<?php if($Quote->extra_packers_no != 0): ?>
					<tr>
						<td width="50%"><b>No Extra Packers:</b></td>
						<td width="50%"><?php echo e($Quote->extra_packers_no); ?></td>
					</tr>
					<?php endif; ?>

					<tr>
						<td width="50%"><b>No Cleaners:</b></td>
						<td width="50%"><?php echo e($Quote->cleaners_no); ?></td>
					</tr>
		</table>
			</td>
		<td width="33%" style="border-left: #FFF 5px solid; border-right: #FFF 5px solid">
			<table width="100%" cellpadding="2" cellspaceing="0" border="0">
				<tr>
					<td width="50%"><b>Moving Date:</b></td>
					<?php if($Quote->moving_date != "0000-00-00"): ?>
					<td width="50%"><?php echo e(date("d/m/Y", strtotime($Quote->moving_date))); ?></td>
					<?php else: ?>
					<td width="50%">N/A</td>
					<?php endif; ?>
				</tr>
				<tr>
					<td width="50%"><b>Arrival Time:</b></td>
					<td width="50%"><?php echo e($Quote->moving_time); ?> TO <?php echo e($Quote->moving_time_to); ?></td>
				</tr>

				<tr>
					<td width="50%"><b>Delivery Date:</b></td>
					<?php if($Quote->delivery_date != "000-00-00"): ?>
					<td width="50%"><?php echo e(date("d/m/Y", strtotime($Quote->delivery_date))); ?></td>
					<?php else: ?>
					<td width="50%">N/A</td>
					<?php endif; ?>
				</tr>

				<tr>
					<td width="50%"><b>Packaging Date:</b></td>
					<?php if($Quote->packaging_date != "0000-00-00"): ?>
					<td width="50%"><?php echo e(date("d/m/Y", strtotime($Quote->packaging_date))); ?></td>
					<?php else: ?>
					<td width="50%">N/A</td>
					<?php endif; ?>
				</tr>

				<tr>
					<td width="50%"><b>Cleaning Date:</b></td>
					<?php if($Quote->cleaning_date != "0000-00-00"): ?>
					<td width="50%"><?php echo e(date("d/m/Y", strtotime($Quote->cleaning_date))); ?></td>
					<?php else: ?>
					<td width="50%">N/A</td>
					<?php endif; ?>
				</tr>
			</table>
		</td>

		<td width="33%">
			<table width="100%" cellpadding="2" cellspaceing="0" border="0">
				<tr>
					<td width="50%"><b>Waiting time:</b></td>
					<td width="50%"><?php echo e($Quote->waiting_time); ?></td>
				</tr>

				<tr>
					<td width="50%"><b>Out by:</b></td>
					<td width="50%"><?php echo e($Quote->out_by); ?></td>
				</tr>

				<tr>
					<td width="50%"><b>Storage:</b></td>
					<td width="50%"><?php echo e($Quote->storage); ?></td>
				</tr>

				<tr>
					<td width="50%"><b>Insurance:</b></td>
					<td width="50%"><?php echo e($Quote->insurance); ?></td>
				</tr>
			</table>
		</td>
		</tr>
	</table>
</div>

<div style="clear: both">&nbsp;</div>

<div style="padding: 5px; background-color:#E9FFFF; ">
	<div style="background-color: #2ACDC9; padding:5px 0px; text-align: center; color: #FFF"> <b>Services Details </b></div>
	<table width="100%" cellpadding="0" cellspaceing="0" border="0">
		<tr>
			<td width="50%">
				<table width="100%" cellpadding="2" cellspaceing="0" border="0">
					<tr>
						<td width="50%"><b>Loading/Unloading, Mileage:</b></td>
						<td width="50%"><?php echo e($Quote->loading_mileage); ?></td>
					</tr>
					
					<tr>
						<td width="50%"><b>Packaging Materials:</b></td>
						<td width="50%"><?php echo e($Quote->packaging_materials); ?></td>
					</tr>
					
					<tr>
						<td width="50%"><b>Packaging Service:</b></td>
						<td width="50%"><?php echo e($Quote->packaging_services); ?></td>
					</tr>
					
					<tr>
						<td width="50%"><b>Unpacking Service:</b></td>
						<td width="50%"><?php echo e($Quote->unpacking_service); ?></td>
					</tr>
				</table>
			</td>
			
			<td width="50%">
				<table width="100%" cellpadding="2" cellspaceing="0" border="0">
					<tr>
						<td width="50%"><b>Heavy Items:</b></td>
						<td width="50%"><?php echo e($Quote->heavy_items); ?></td>
					</tr>
					
					<tr>
						<td width="50%"><b>Dismantling service:</b></td>
						<td width="50%"><?php echo e($Quote->dismantling_service); ?></td>
					</tr>
					
					<tr>
						<td width="50%"><b>Assembly service:</b></td>
						<td width="50%"><?php echo e($Quote->assembly_service); ?></td>
					</tr>
					
					<tr>
						<td width="50%"><b>Disposal service:</b></td>
						<td width="50%"><?php echo e($Quote->disposal_service); ?></td>
					</tr>
					
					<tr>
						<td width="50%"><b>Cleaning Service:</b></td>
						<td width="50%"><?php echo e($Quote->cleaning_service); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>

<div style="clear: both">&nbsp;</div>

<div style="background-color:#E9FFFF; padding: 10px;">
	<div style="background-color: #2ACDC9; padding:5px 0px; text-align: center; color: #FFF"><b>Special Instructions</b></div>
	<p style="font-size: 14px; padding: 10px"><?php echo e($Quote->special_instructions); ?></p>
</div>

<div style="clear: both">&nbsp;</div>

<div style="padding: 5px; background-color:#2ACDC9;">
	<table width="100%" cellpadding="0" cellspaceing="0" border="0">
		<tr>
			<td width="5%"></td>
			<td width="50%">
				<div style="font-size: 12px; color:#fff;">Our standard package quote for your move is:</div>
				<div style="font-size: 12px; color:#fff;"><i>All Inclusive, No Hidden Fees, Price Match Guarantee + 10% Off</i></div>
				<div style="font-size: 12px; color:#fff;">Free updates / cancellations up to 72h before the move:</div>
			</td>
			<td width="40%"><div style="color: #FFF; font-size:40px; text-align: center"><b>£<?php echo e(round($TotalPrice, 2)); ?></b></div></td>
		</tr>
	</table>
</div>

<div style="width: 100%; margin-top: 10px;"><img src="<?php echo e(URL('public/footer.JPG')); ?>" style="width:100%; height: 100px"></div>
</body>
</html><?php /**PATH /var/www/vhosts/cornerstoneremovals.com/laravel.cornerstoneremovals.com/resources/views/PDFView.blade.php ENDPATH**/ ?>