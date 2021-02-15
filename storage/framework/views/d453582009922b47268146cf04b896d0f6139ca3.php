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
	
	<div style="font-size:30px; text-align: center"><b>Invoice</b></div>
	<div style="background-color: #2ACDC9; padding:5px 10px; text-align: center; color: #FFF">
		<div style="float: left"><b>No. :</b> CSR<?php echo e(date("dmY")); ?><?php echo e(substr($Survey->last_name, 0, 1)); ?></div>
		<div style="float: right"><b>Date :</b> <?php echo e(date("d.m.Y")); ?></div>
		<div style="clear: both"></div>
	</div>
	
	<div style="padding: 10px;">
		<b>To</b><br>
		<?php echo e($Survey->first_name." " . $Survey->last_name); ?><br>
		<?php echo e($Quote->pickup_postcode); ?><br>
	</div>
	
	<div style="margin-top: 10px; padding: 10px;">
		
		<table width="100%" cellpadding="20" cellspaceing="0" border="1" style="border: 1px solid #dee2e6; border-collapse: collapse;">
			<thead>
				<tr>
					<td width="50%">Description</td>
					<td width="10%">Fees</td>
					<td width="10%">VAT</td>
					<td width="20%">Total</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$TotlaPrice = $Quote->client_paid_amount;
				$NetPrice = $TotlaPrice / 1.20;
				$TotalVAT = $TotlaPrice - $NetPrice;
				?>
				<tr>
					<td>
						Removal Job ID : <?php echo e($Quote->id); ?><br>
						Deposit reserve your move 100% refundable up to 72H before moving date.
					</td>
					<td>£<?php echo e(number_format($NetPrice, 2)); ?></td>
					<td>£<?php echo e(number_format($TotalVAT, 2)); ?></td>
					<td>£<?php echo e(number_format($Quote->client_paid_amount, 2)); ?></td>
				</tr>
				<?php
				$TotlaPrice = $Quote->final_payable_amount - $Quote->client_paid_amount;
				$NetPrice = $TotlaPrice / 1.20;
				$TotalVAT = $TotlaPrice - $NetPrice;
				?>
				<tr>
					<td>
						Removal Job ID : <?php echo e($Quote->id); ?><br>
						Balance to be paid by 10am on the day of the move.
					</td>
					<td>£<?php echo e(number_format($NetPrice, 2)); ?></td>
					<td>£<?php echo e(number_format($TotalVAT, 2)); ?></td>
					<td>£<?php echo e(number_format($TotlaPrice, 2)); ?></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: right"><b>Total</b></td>
					<td width="20%"><b>£<?php echo e($Quote->final_payable_amount); ?></b></td>
				</tr>
			</tbody>
		</table>
		<div style="margin: 10px 0px;">
			<b>Account Name : </b> CORNERSTONE REMOVALS<br>
			<b>Bank Name : </b> METRO BANK<br>
			<b>Sort Code : </b> 23-05-80<br>
			<b>Account Number : </b> 32646492
		</div>
	</div>
<div style="width: 100%; margin-top: 10px;"><img src="<?php echo e(URL('public/footer.JPG')); ?>" style="width:100%; height: 100px"></div>
</body>
</html><?php /**PATH /opt/lampp/htdocs/corner/resources/views/InvoiceView.blade.php ENDPATH**/ ?>