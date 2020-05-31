@extends('layout')

@section('pageTitle')
    @if ($action == "add")
        Add a Configuration Value
    @else
        Edit a Configuration Value
    @endif
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-12 Incised901Light">
            <h1>{!!$action == "add"? "Add": "Edit"!!} a Configuration Value</h1>
        </div>
    </div>

    @if ($action == "add")
        {!! Form::model( $config, [ 'route' => [ 'config.store' ], 'method' => 'post', 'id' => 'config_form' ] ) !!}
    @else
        {!! Form::model( $config, [ 'route' => [ 'config.update', $config->_id ], 'method' => 'put', 'id' => 'config_form' ] ) !!}
    @endif

    <div class="row">
        <div class="col-sm-8 form-group" Incised901Light
        ">
        <label for="key" class="my Incised901Light">Key</label>
        {!!Form::text('key', empty($config->key)?null:$config->key, ['id' => 'key', 'placeholder' => 'Configuration Key', 'class' => 'form-control'])!!}
    </div>
    </div>

    <div class="row">
        <div class="col-sm-8 form-group" Incised901Light
        ">
        <label for="value" class="my Incised901Light">Value</label>

        {!!Form::textarea('value', empty($config->value)?null:is_array($config->value)?json_encode($config->value):$config->value, ['id' => 'value', 'class' => 'form-control'])!!}
    </div>
    </div>
    <div class="row">
        <div class="col-sm-8  text-center">
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> <strong>Save</strong>
            </button>
        </div>
    </div>
@stop

@section('scriptFooter')
    @if(is_array($config->value))
        <script type="text/javascript">
            $('#value').val(JSON.stringify(JSON.parse($('#value').val()), undefined, 4));
        </script>
    @endif
@stop
