@include("header")

<!--include dataTable css/js-->
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>


<!--include font-awesome-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>

</style>


<div class="container">
    <div class="table-responsive">
        <table id="noclient_emails" class="table table-bordered hover">
            <thead>
            <tr>
                <td>Client ID</td>
                <td>Folder</td>
                <td>Saved At</td>
                <td>Email</td>
            </tr>
            </thead>
            <tbody>
            @foreach($noclients as $row)
                <tr>
                    <td>
                        {{ Form::model($row, ['route' => ['noclient_update', $row->id], 'method' => 'put']) }}

                        <div class="form-group">
                            {{Form::label('client_id', 'Client ID',  array('class' => 'control-label mb-1'))}}
                            {{Form::text('client_id', null, ['class' => 'form-control', 'id' => 'client_id'])}}
                        </div>
                        <div>
                            <button type="submit" class="btn btn-lg btn-info btn-block">
                                <span>Update</span>
                            </button>
                        </div>
                        {{Form::close()}}
                    </td>
                    <td>{{$row->folder}}</td>
                    <td>{{$row->saved_at}}</td>
                    <td>
                        @php
                            echo $row->notes;
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>





<script>

    $(document).ready( function () {
        table = $('#noclient_emails').DataTable();

    });
</script>
</body>
</html>