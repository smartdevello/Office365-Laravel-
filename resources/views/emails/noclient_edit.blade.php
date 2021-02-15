<div class="container">
    {{ Form::model($noclient, ['route' => ['noclient_update', $noclient->id], 'method' => 'put']) }}

    <div class="form-group">
        {{Form::label('client_id', 'Client ID',  array('class' => 'control-label mb-1'))}}
        {{Form::text('client_id', null, ['class' => 'form-control', 'id' => 'client_id'])}}
    </div>
    <div>
        <button type="submit" class="btn btn-lg btn-info btn-block">
            <i class="fa fa-lock fa-lg"></i>&nbsp;
            <span>Update</span>
        </button>
    </div>
    {{Form::close()}}
</div>