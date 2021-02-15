<!DOCTYPE html>
<html>
<head>
	<style>
		body{
			font-family:"arial";
			font-size: 12px;
			font-weight: 400;
		}
	</style>
</head>
<body>
	<div style="float: left; margin-left: 50px;">
		<div><h2>{{ $GetDriverData->name }} Invoice</h2></div>
		<div>{{ $GetDriverData->address }}</div>
		<div>{{ $GetDriverData->city }}</div>
		<div>{{ $GetDriverData->postcode }}</div>

		<div><b>Insurance Number :</b> {{ $GetDriverData->national_insurance }}</div>
		<div><b>Account Name :</b> {{ $GetDriverData->account_name }}</div>
		<div><b>Sort Code :</b> {{ $GetDriverData->sort_code }}</div>
		<div><b>Account Number :</b> {{ $GetDriverData->account_number }}</div>
	</div>

	<div style="float: right; margin-right: 50px;">
		<div><h2>To: Cornerstone Removals,</h2></div>
		<div>4 Longcliffe Path,</div>
		<div>Watford, WD19 7PH</div>
		<div>Hertfordshire</div>
		<div>email: cornel@cornerstoreremovals.co.uk</div>
		<div>Tel: 0755 137 2377</div>
	</div>

	<div style="clear: both;"></div>

	<br><br>
	<h2 style="text-align: center;">** SELF BILLING INVOICE **</h2>
	<h3 style="text-align: center;">Invoice Number: {{ substr(strtoupper($GetDriverData->name),0, 2) }}{{ date("dmY") }}</h3>
	<div style="text-align: center;">Invoice Date: {{ date("d.m.Y") }}</div>

	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>

	<table width="100%" border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; display: table;">
		<thead>
			<tr>
				<th>Date</th>
				<th>Pickup Address</th>
				<th>Income</th>
			</tr>
		</thead>
		<tbody>
			@php
			$Total = 0;
			@endphp

			@foreach($GetAllIncome as $GAI)
			@php
			$Total += $GAI->driver_job_salary;
			$PickupAdd = "";

			if($GAI->driver_job_type == 0){
				$GT = App\Model\PackingJob::leftjoin("quotes", "quotes.id", "packing_job.packing_job_quote_id")->find($GAI->main_job_id);
				$PickupAdd = $GT->pickup_postcode;
			}

			if($GAI->driver_job_type == 1){
				$GT = App\Model\MovingJob::leftjoin("quotes", "quotes.id", "moving_job.moving_job_quote")->find($GAI->main_job_id);
				$PickupAdd = $GT->pickup_postcode;
			}
			@endphp

			<tr>
				<td>{{ date("d F, Y", strtotime($GAI->driver_job_date)) }}</td>
				<td>{{ $PickupAdd }}</td>
				<td style="text-align: right;">{{ number_format($GAI->driver_job_salary, 2) }}</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th style="text-align: right;" colspan="2">Total</th>
				<th style="text-align: right;">{{ number_format($Total, 2) }}</th>
			</tr>
		</tfoot>
	</table>


	<div class="clearfix">&nbsp;</div>

	<h2 style="text-align: center;">Expenses</h2>

	<div class="clearfix">&nbsp;</div>
	<table width="100%" border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; display: table;">
		<thead>
			<tr>
				<td>Sr. No.</td>
				<td>Date</td>
				<td>Description</td>
				<td>Amount</td>
			</tr>
		</thead>
		<tbody>
			@php
			$ExpnTotal = 0;
			@endphp

			@foreach($GetAllExpenses as $SRN => $GAE)
			@php
			$ExpnTotal += $GAE->expenses_amont;
			@endphp
			<tr>
				<td>{{ $SRN + 1}}</td>
				<td>{{ date("d F, Y", strtotime($GAE->expenses_date)) }}</td>
				<td>{{ $GAE->expenses_desp }}</td>
				<td style="text-align: right;">{{ number_format($GAE->expenses_amont, 2) }}</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th style="text-align: right;" colspan="3">Total</th>
				<th style="text-align: right;">{{ number_format($ExpnTotal, 2) }}</th>
			</tr>
		</tfoot>
	</table>

	<div style="text-align: right;"><h3>Grand Total : {{ number_format($Total + $ExpnTotal, 2) }}</h3> </div>
</body>
</html>