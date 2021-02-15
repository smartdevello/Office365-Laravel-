
	@include("header")
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"/>
    <div class="container">
		<div class="clearfix">&nbsp;</div>
		<div class="float-left"><h1>Account Managers</h1></div>
		<div class="float-right">
			<a href="{{ URL('AccountManager/Add') }}"><button class="btn btn-info">Add New</button></a>
		</div>
		<div class="clearfix">&nbsp;</div>
		
		@if(Session::has('Success'))
  <div class="alert alert-success" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text">{!!Session::get('Success')!!}</div>
  </div>
  @endif
		
		@if(Session::has('Danger'))
  <div class="alert alert-danger" role="alert">
    <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
    <div class="alert-text">{!!Session::get('Danger')!!}</div>
  </div>
  @endif
		
		<div class="clearfix">&nbsp;</div>
	<table id="example" class="table table-bordered table-stripped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>User Name</th>
				<th>Privilege</th>
				<th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
			@foreach($GetManager as $GM)
            <tr>
                <td>{{ $GM->name }}</td>
                <td>{{ $GM->user }}</td>
				<td>
					@php
					$EmpPrm = explode(",", $GM->permissions);
					@endphp
					
					@foreach($EmpPrm as $PM)
						{{ $PM }}<br>
					@endforeach
					
				</td>
				<td>{{ $GM->role }}</td>
                <td>
					<a href="{{ URL('AccountManager/Edit') }}/{{ $GM->id }}">Edit</a> |
					<a onClick="return ConfrmDelete()" href="{{ URL('AccountManager/Delete') }}/{{ $GM->id }}">Delete</a>
				</td>
            </tr>
			@endforeach
		</tbody>
		</table>
	</div>
	
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function() {
		$('#example').DataTable();
	} );
		
		function ConfrmDelete(){
			if(confirm('Are You Sure to Delete this Record')){
				return true
			}
			return false
		}
	</script>
</body>
</html>