@extends('layout')

@section('pageTitle')
    Editing User {{ $user->getGreeting() }} {{ $user->first_name }}{{ isset( $user->middle_name ) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ isset( $user->suffix ) ? ' ' . $user->suffix : '' }}
@stop

@section('bodyclasses')
    userform
@stop

@section('content')
        <h4 class="my NordItalic ninety">
        Editing {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
        {{ $user->last_name }}{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}</h4>

    <div class="Incised901Light filePhoto">

        {{$user->member_id}}
        <div class="filePhotoBox">

            @if(file_exists(public_path() . $user->filePhoto) && isset($user->filePhoto) === true)
                <img src="{{$user->filePhoto}}" alt="Official File Photo">
            @endif
            <div class="ofpt">
                <form action='/api/photo' class='dropzone' id='trmnDropzone' method='post'
                      title="Drag and drop image files here or click.  Only .png, .gif and .jpg files will be accepted.  All images uploaded will be scaled to 150 pixels wide by 200 pixels tall.  After the image has been dropped, the form will be submitted and processed.">
                    {{ Form::hidden('member_id', $user->member_id) }}
                </form>
            </div>
        </div>
    </div>

    {{ Form::model( $user, [ 'route' => [ 'user.update', $user->id ], 'method' => 'put', 'id' => 'user' ] ) }}
    {{ Form::hidden('member_id', $user->member_id) }}
    {{ Form::hidden('reload_form', 'no', ['id' => 'reload_form']) }}
    {{ Form::hidden('showUnjoinable', 'true', ['id' => 'showUnjoinable']) }}
    {{ Form::hidden('redirectTo', URL::previous()) }}
    <fieldset>
        <legend>Member Information</legend>
        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {{ Form::label('email_address', 'E-Mail Address (This is your Username)', ['class' => 'my']) }}
                {{ Form::email('email_address') }}
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns ninety Incised901Light">
                {{ Form::label('first_name', 'First Name', ['class' => 'my']) }} {{ Form::text('first_name') }}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {{ Form::label('middle_name', 'Middle Name', ['class' => 'my']) }} {{ Form::text('middle_name') }}
            </div>
            <div class="small-3 columns ninety Incised901Light">
                {{ Form::label('last_name', 'Last Name', ['class' => 'my']) }} {{ Form::text('last_name') }}
            </div>
            <div class="small-1 columns ninety Incised901Light end">
                {{ Form::label('suffix', 'Suffix', ['class' => 'my']) }} {{ Form::text('suffix') }}
            </div>
        </div>

        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {{ Form::label('address1', 'Street Address', ['class' => 'my']) }} {{ Form::text('address1') }}
            </div>

        </div>
        <div class="row">
            <div class="small-8 columns ninety Incised901Light end">
                {{ Form::label('address2', 'Address Line 2', ['class' => 'my']) }} {{ Form::text('address2') }}
            </div>
        </div>

        <div class="row">
            <div class="small-3 columns ninety Incised901Light">
                {{ Form::label('city', 'City', ['class' => 'my']) }} {{ Form::text('city') }}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {{ Form::label('state_province', 'State/Province', ['class' => 'my']) }} {{ Form::text('state_province') }}
            </div>
            <div class="small-2 columns ninety Incised901Light">
                {{ Form::label('postal_code', 'Postal Code', ['class' => 'my']) }} {{ Form::text('postal_code') }}
            </div>
            <div class="end small-3 columns ninety Incised901Light">
                {{ Form::label('country', 'Country', ['class' => 'my']) }} {{ Form::select('country', $countries, $user->country) }}
            </div>
        </div>

        <div class="row">
            <div class="small-4 columns ninety Incised901Light">
                {{ Form::label('phone_number', "Phone Number", ['class' => 'my']) }} {{ Form::text('phone_number') }}
            </div>
            <div class="end small-4 columns ninety Incised901Light">
                {{ Form::label('dob', 'Date of Birth', ['class' => 'my']) }} {{Form::date('dob', $user->dob)}}
            </div>
        </div>

        <div class="row">
            <div class="small-4 columns ninety Incised901Light">
                {{ Form::label('password', 'Password', ['class' => 'my']) }} {{ Form::password('password') }}
            </div>
            <div class="end small-4 columns ninety Incised901Light">
                {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'my']) }} {{ Form::password('password_confirmation') }}
            </div>
        </div>

        <div class="row">
            <div class="end small-6 columns ninety Incised901Light">
                {{ Form::label('branch', "Branch", ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_USER']) === true){{ Form::select('branch', $branches, $user->branch) }}
                @else
                    {{Form::hidden('branch', $user->branch)}} {{$branches[$user->branch]}}
                @endif
            </div>
        </div>

        @if($permsObj->hasPermissions(['EDIT_USER']) === true)
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{Form::label('registration_status', 'Registration Status', ['class' => 'my'])}} {{Form::select('registration_status', RegStatus::getRegStatuses(), $user->registration_status) }}
                </div>
            </div>
        @else
            {{Form::hidden('registration_status', $user->registration_status)}}
        @endif



    </fieldset>

    <fieldset>
        <legend>Primary Assignment Information</legend>
        @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label( 'plocation', 'Filter Chapter list by Location', ['class' => 'my']) }} {{ Form::select('plocation', $locations) }}
                </div>
            </div>
        @endif

        <div class="row">
            <div class="end small-6 columns ninety Incised901Light">
                {{ Form::label('primary_assignment', "Chapter", ['class' => 'my']) }}  @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::select('primary_assignment', $chapters) }}
                {{ Form::hidden('passignment', $user->primary_assignment, ['id' => 'passignment']) }}
                @else
                    {{Form::hidden('primary_assignment', $user->primary_assignment)}} {{$chapters[$user->primary_assignment]}}
                    <br/>
                    <br/>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="end small-6 columns ninety Incised901Light">
                {{ Form::label('primary_billet', 'Billet', ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::select('primary_billet', $billets) }}
                @else
                    {{Form::hidden('primary_billet', $user->primary_billet)}} {{$user->primary_billet}}<br/><br/>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="end small-6 columns ninety Incised901Light">
                {{ Form::label('primary_date_assigned', "Date Assigned", ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::date('primary_date_assigned', $user->primary_date_assigned) }}
                @else
                    {{Form::hidden('primary_date_assigned', $user->primary_date_assigned)}} {{$user->primary_date_assigned}}
                    <br/><br/>
                @endif
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Secondary Assignment Information</legend>
        @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label( 'slocation', 'Filter Chapter List by Location', ['class' => 'my']) }} {{ Form::select('slocation', $locations) }}
                </div>
            </div>
        @endif
        @if(empty($user->secondary_assignment) === false || $permsObj->hasPermissions(['EDIT_MEMBER']) === true)
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label('secondary_assignment', "Chapter", ['class' => 'my']) }}  @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::select('secondary_assignment', $chapters) }}
                    {{ Form::hidden('sassignment', $user->secondary_assignment, ['id' => 'sassignment']) }}
                    @else
                        {{Form::hidden('secondary_assignment', $user->secondary_assignment)}} {{$chapters[$user->secondary_assignment]}}
                        <br/><br/>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label('secondary_billet', 'Billet', ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::select('secondary_billet', $billets) }}
                    @else
                        {{Form::hidden('secondary_billet', $user->secondary_billet)}} {{$user->secondary_billet}}<br/>
                        <br/>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label('secondary_date_assigned', "Date Assigned", ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::date('secondary_date_assigned', $user->secondary_date_assigned) }}
                    @else
                        {{Form::hidden('secondary_date_assigned', $user->secondary_date_assigned)}} {{$user->secondary_date_assigned}}
                        <br/><br/>
                    @endif
                </div>
            </div>
        @else
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">None</div>
            </div>
        @endif
    </fieldset>

    <fieldset>
        <legend>Additional Assignment Information</legend>
        @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label( 'alocation', 'Filter Chapter List by Location', ['class' => 'my']) }} {{ Form::select('alocation', $locations) }}
                </div>
            </div>
        @endif
        @if(empty($user->additional_assignment) === false || $permsObj->hasPermissions(['EDIT_MEMBER']) === true)
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label('additional_assignment', "Chapter", ['class' => 'my']) }}  @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::select('additional_assignment', $chapters) }}
                    {{ Form::hidden('aassignment', $user->additional_assignment, ['id' => 'sassignment']) }}
                    @else
                        {{Form::hidden('additional_assignment', $user->additional_assignment)}} {{$chapters[$user->additional_assignment]}}
                        <br/><br/>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label('additional_billet', 'Billet', ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::select('additional_billet', $billets) }}
                    @else
                        {{Form::hidden('additional_billet', $user->additional_billet)}} {{$user->additional_billet}}<br/>
                        <br/>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">
                    {{ Form::label('additional_date_assigned', "Date Assigned", ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::date('additional_date_assigned', $user->additional_date_assigned) }}
                    @else
                        {{Form::hidden('additional_date_assigned', $user->additional_date_assigned)}} {{$user->additional_date_assigned}}
                        <br/><br/>
                    @endif
                </div>
            </div>
        @else
            <div class="row">
                <div class="end small-6 columns ninety Incised901Light">None</div>
            </div>
        @endif
    </fieldset>

    <fieldset>
        <legend>Rank and Rating</legend>

        <div class="row">
            <div class="end small-4 columns ninety Incised901Light">
                {{ Form::label('display_rank', "Rank", ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::select('display_rank', $grades) }}
                @else
                    {{Form::hidden('display_rank', $user->display_rank)}} {{$grades[$user->display_rank]}}<br/><br/>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="end small-4 columns ninety Incised901Light">
                {{ Form::label('dor', "Date of Rank", ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::date('dor') }}
                @else
                    {{Form::hidden('dor', $user->dor)}} @if(empty($user->dor) === true)
                        Unknown<br/><br/> @else {{$user->dor}} @endif
                @endif
            </div>
        </div>
        <div class="row">
            <div class="end small-4 columns ninety Incised901Light">
                {{ Form::label('rating', "Rating (if any)", ['class' => 'my']) }} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){{ Form::select('rating', $ratings) }}
                @else
                    {{Form::hidden('rating', $user->rating)}} @if(empty($user->rating)===true)
                        None @else {{$user->rating['description']}} @endif
                @endif
            </div>
        </div>
    </fieldset>
    @if($permsObj->hasPermissions(['ASSIGN_PERMS']) === true)
        <fieldset>
            <legend>Database Permissions</legend>
            <div class="row">
                <div class="columns small-12 text-center">
                    Common Permission Sets<br />

                        <button class="tiny secondary" id="coPerms">Commanding Officer</button>
                        <button class="tiny secondary" id="slPerms">Space Lord</button>
                        <button class="tiny secondary" id="rmaPerms">RMA</button>
                        <button class="tiny secondary" id="rmmcPerms">RMMC</button>
                        <button class="tiny secondary" id="defaultPerms">Default</button>

                </div>
            </div>
            <ul class="small-block-grid-3">
                @foreach(DB::table('permissions')->orderBy('name', 'asc')->get() as $permission)
                    <li>{{ Form::checkbox('permissions[]', $permission['name'], in_array($permission['name'], $user->permissions), ['id' => $permission['name'], 'class' => 'permissions']) }}
                        <span title="{{$permission['description']}}">{{$permission['name']}}</span></li>
                @endforeach
            </ul>
        </fieldset>
    @else
        {{Form::hidden('permissions', serialize($user->permissions))}}
    @endif
    {{Form::hidden('duty_roster', $user->duty_roster, ['id' => 'dutyroster'])}}

    <div id="chooseShip" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <div class="row">
            Which Chapter does the DUTY_ROSTER permission apply to?<br /><br />
        </div>
        <div class="row" id="selectDR">

        </div>
        <div class="row">
            <button class="button" onclick="$('#dutyroster').val($('.dr:checked').val());$('#chooseShip').foundation('reveal', 'close');">OK</button>
        </div>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

    <a class="button"
       href="{{ URL::previous() }}">Cancel</a> {{ Form::submit('Save', [ 'class' => 'button' ] ) }}

    {{ Form::close() }}

    <div id="photoModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <div class="row">
            <div class="small-2 columns trmn-width" id="pm1">
                <img src="{{$serverUrl}}/images/trmn-seal.png" alt="TRMN Seal">
            </div>
            <div class="small-10 columns Incised901Light" id="pm2">
                <p></p>
            </div>
        </div>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
@stop
