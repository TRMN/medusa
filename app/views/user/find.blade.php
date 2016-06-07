@extends('layout')

@section('pageTitle')
    Find Member
@stop

@section('bodyclasses')
@stop

@section('content')
    <h1>Find A Member</h1>

    <div class="row">
        <div class="columns small-6 ninety Incised901Light end">
            {{Form::text('query', '', ['id' => 'query', 'placeholder' => 'Start typing member number or name'])}}
        </div>
    </div>
    @if(!is_null($user))
        @include('partials.greeting', ['user' => $user])
        @include('partials.assignments', ['user' => $user, 'showPrimary' => true])
        @include('partials.coursework', ['user' => $user])
        @if($permsObj->hasPermissions(['EDIT_GRADE'], true))
            <br/>
            <div>
                {{ $user->getGreeting() }} {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}
                @if(in_array('ALL_PERMS', $user->permissions))
                    is a <span class="alert">super user</span> and has permission to do everything.
                @else
                    @if(in_array('ADD_GRADE', $user->permissions))
                        has permission to add grades. <a href="{{route('user.perm.del', [$user->id, 'ADD_GRADE'])}}"><span class="fi-trash red" title="Remove Permission">&nbsp;</span></a>
                    @else
                        does not have permission to add grades. <a href="{{route('user.perm.add', [$user->id, 'ADD_GRADE'])}}"><span class="fi-plus green" title="Add Permission">&nbsp;</span></a>
                    @endif
                @endif
            </div>
        @endif
    @endif
@stop
@section('scriptFooter')
    <script type="text/javascript">
        $('#query').devbridgeAutocomplete({
            serviceUrl: '/api/find',
            onSelect: function (suggestion) {
                @if($permsObj->hasPermissions(['EDIT_GRADE'], true))
                        window.location = '/user/find/' + suggestion.data;
                @else
                        window.location = '/user/' + suggestion.data;
                @endif
            },
            width: 600
        });
    </script>
@stop