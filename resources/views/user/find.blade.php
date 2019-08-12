@extends('layout')

@section('pageTitle')
    Find Member
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1>Find A Member</h1>

    <div class="row">
        <div class=" col-sm-6 ninety Incised901Light ">
            {!!Form::text('query', '', ['id' => 'query', 'placeholder' => 'Start typing member number or name', 'class' => 'form-control'])!!}
        </div>
    </div>

    @if(!empty($user->first_name))
        @include('partials.greeting', ['user' => $user])
        @include('partials.assignments', ['user' => $user, 'showPrimary' => true])
        @include('partials.coursework', ['user' => $user])
        @if($permsObj->hasPermissions(['EDIT_GRADE'], true))
            <br/>
            <div>
                {!! $user->getGreeting() !!} {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}
                @if(in_array('ALL_PERMS', $user->permissions))
                    is a <span class="alert">super user</span> and has permission to do everything.
                @else
                    @if(in_array('ADD_GRADE', $user->permissions))
                        has permission to add grades. <a href="{!!route('user.perm.del', [$user->id, 'ADD_GRADE'])!!}"><span class="fa fa-trash red" data-toggle="tooltip" title="Remove Permission">&nbsp;</span></a>
                    @else
                        does not have permission to add grades. <a href="{!!route('user.perm.add', [$user->id, 'ADD_GRADE'])!!}"><span class="fa fa-plus green" data-toggle="tooltip" title="Add Permission">&nbsp;</span></a>
                    @endif
                @endif
            </div>
        @endif
    @endif
@stop
@section('scriptFooter')
    @include('partials.usersearch')
@stop