@include("header")

<!--include dataTable css/js-->
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<!--include font-awesome-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>

</style>


<div class="container">

    {{Form::open(array('url' => 'email/ignored_email/create', 'method' => 'post'))}}

    <div class="form-group">
        {{Form::label('email', 'Email',  array('class' => 'control-label mb-1'))}}
        {{Form::text('email', null, ['class' => 'form-control', 'id' => 'email'])}}
    </div>
    <div>
        <button type="submit" class="btn btn-lg btn-info btn-block">
            <i class="fa fa-lock fa-lg"></i>&nbsp;
            <span>Add New</span>
        </button>
    </div>
    {{Form::close()}}

    <br><br><hr><br>
    <div class="table-responsive">
        <table id="ignored_emails" class="table table-bordered hover">
            <thead>
            <tr>
                <td>ID</td>
                <td>Email</td>
                <td>Option</td>
            </tr>
            </thead>
            <tbody>
            @foreach($ignored_emails as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td>
                    {{ Form::model($row, ['route' => ['ignored_email_update', $row->id], 'method' => 'put']) }}

                    <div class="form-group">
                        {{Form::text('email', null, ['class' => 'form-control', 'id' => 'email'])}}
                    </div>
                    <div>
                        <button type="submit" class="btn btn-lg btn-info btn-block">
                            <span>Update</span>
                        </button>
                    </div>
                    {{Form::close()}}
                </td>
                <td>
                    {{Form::open(['method' => 'DELETE', 'url' => ['/email/ignored_email/delete/' . $row->id], 'style' => 'display:inline']) }}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                    {{Form::close()}}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>





<script>

    $(document).ready( function () {
        table = $('#ignored_emails').DataTable();

    });
</script>
</body>
</html>