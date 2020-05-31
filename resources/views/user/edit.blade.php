@extends('layout')

@section('pageTitle')
    Editing User {!! $user->getGreeting() !!} {!! $user->first_name !!}{{ isset( $user->middle_name ) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ isset( $user->suffix ) ? ' ' . $user->suffix : '' }}
@stop

@section('dochead')

@stop

@section('bodyclasses')
    userform
@stop

@section('content')
    <div class="row">
        <div class=" col-sm-9">

            <h4 class="my NordItalic ninety">
                Editing {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
                {!! $user->last_name !!}{{ isset($user->suffix) ? ' ' . $user->suffix : '' }}</h4>


            {!! Form::model( $user, [ 'route' => [ 'user.update', $user->id ], 'method' => 'put', 'id' => 'user' ] ) !!}
            {!! Form::hidden('member_id', $user->member_id, ['id' => 'member_id']) !!}
            {!! Form::hidden('reload_form', 'no', ['id' => 'reload-form']) !!}
            {!! Form::hidden('showUnjoinable', 'true', ['id' => 'showUnjoinable']) !!}
            {!! Form::hidden('redirectTo', URL::previous()) !!}
            <fieldset>
                <legend>Member Information</legend>
                <div class="row">
                    <div class="col-sm-8  ninety Incised901Light form-group">
                        {!! Form::label('email_address', 'E-Mail Address (This is your Username)', ['class' => 'my required']) !!}
                        {!! Form::email('email_address', $user->email_address, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3  ninety Incised901Light form-group">
                        {!! Form::label('first_name', 'First Name', ['class' => 'my required']) !!} {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2  ninety Incised901Light form-group">
                        {!! Form::label('middle_name', 'Middle Name', ['class' => 'my']) !!} {!! Form::text('middle_name', $user->middle_name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-3  ninety Incised901Light form-group">
                        {!! Form::label('last_name', 'Last Name', ['class' => 'my required']) !!} {!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2  ninety Incised901Light form-group ">
                        {!! Form::label('suffix', 'Suffix', ['class' => 'my']) !!} {!! Form::select('suffix', ['' => 'None', 'Jr' => 'Jr', 'Sr' => 'Sr', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', 'V' => 'V'], $user->suffix, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8  ninety Incised901Light form-group ">
                        {!! Form::label('address1', 'Street Address', ['class' => 'my required']) !!} {!! Form::text('address1', $user->address1, ['class' => 'form-control']) !!}
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-8  ninety Incised901Light form-group ">
                        {!! Form::label('address2', 'Address Line 2', ['class' => 'my']) !!} {!! Form::text('address2', $user->address2, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3  ninety Incised901Light form-group">
                        {!! Form::label('city', 'City', ['class' => 'my required']) !!} {!! Form::text('city', $user->city, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2  ninety Incised901Light form-group">
                        {!! Form::label('state_province', 'State/Province', ['class' => 'my required']) !!} {!! Form::text('state_province', $user->state_province, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2  ninety Incised901Light form-group">
                        {!! Form::label('postal_code', 'Postal Code', ['class' => 'my required']) !!} {!! Form::text('postal_code', $user->postal_code, ['class' => 'form-control']) !!}
                    </div>
                    <div class=" col-sm-3  ninety Incised901Light form-group">
                        {!! Form::label('country', 'Country', ['class' => 'my required']) !!} {!! Form::select('country', $countries, $user->country, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4  ninety Incised901Light form-group">
                        {!! Form::label('phone_number', "Phone Number", ['class' => 'my']) !!} {!! Form::text('phone_number', $user->phone_number, ['class' => 'form-control']) !!}
                    </div>
                    <div class=" col-sm-4  ninety Incised901Light form-group">
                        {!! Form::label('dob', 'Date of Birth', ['class' => 'my required']) !!} {!!Form::date('dob', $user->dob, ['class' => 'form-control'])!!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4  ninety Incised901Light form-group">
                        {!! Form::label('password', 'Password', ['class' => 'my']) !!} {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <div class=" col-sm-4  ninety Incised901Light form-group">
                        {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'my']) !!} {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class=" col-sm-6  ninety Incised901Light form-group">
                        {!! Form::label('branch', "Branch", ['class' => 'my required']) !!} @if($permsObj->hasPermissions(['EDIT_USER']) === true){!! Form::select('branch', $branches, $user->branch, ['class' => 'form-control']) !!}
                        @else
                            {!!Form::hidden('branch', $user->branch)!!} {!!$branches[$user->branch]!!}
                        @endif
                    </div>
                </div>

                @if($permsObj->hasPermissions(['EDIT_USER']) === true)
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!!Form::label('registration_status', 'Registration Status', ['class' => 'my required'])!!} {!!Form::select('registration_status', App\RegStatus::getRegStatuses(), $user->registration_status, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-sm-4  ninety Incised901Light form-group">
                            {!! Form::label('application_date', 'Application Date', ['class' => 'my required']) !!} {!!Form::date('application_date', $user->application_date, ['class' => 'form-control'])!!}
                        </div>
                        <div class=" col-sm-4  ninety Incised901Light form-group">
                            {!! Form::label('registration_date', 'Registration Date', ['class' => 'my required']) !!} {!!Form::date('registration_date', $user->registration_date, ['class' => 'form-control'])!!}
                        </div>
                    </div>
                @else
                    {!!Form::hidden('registration_status', $user->registration_status)!!}
                    {{ Form::hidden('application_date', $user->application_date) }}
                    {{ Form::hidden('registration_date', $user->registration_date) }}
                @endif


            </fieldset>

            <fieldset>
                <legend>Primary Assignment Information @if($permsObj->hasPermissions(['EDIT_MEMBER']))<a
                            class="del_assignment" data-position="primary">(Clear)</a> @endif </legend>

                <div class="row">
                    <div class=" col-sm-6  ninety Incised901Light form-group">
                        {!! Form::label('primary_assignment', "Chapter", ['class' => 'my required']) !!}  @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('primary_assignment', $chapters, $user->primary_assignment, ['class' => 'selectize']) !!}
                        {!! Form::hidden('passignment', $user->primary_assignment, ['id' => 'passignment']) !!}
                        @else
                            {!!Form::hidden('primary_assignment', $user->primary_assignment)!!} {!!$chapters[$user->primary_assignment]!!}
                            <br/>
                            <br/>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class=" col-sm-6  ninety Incised901Light form-group">
                        {!! Form::label('primary_billet', 'Billet', ['class' => 'my required']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('primary_billet', $billets, $user->primary_billet, ['class' => 'billet']) !!}
                        @else
                            {!!Form::hidden('primary_billet', $user->primary_billet)!!} {!!$user->primary_billet!!}<br/>
                            <br/>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class=" col-sm-6  ninety Incised901Light form-group">
                        {!! Form::label('primary_date_assigned', "Date Assigned", ['class' => 'my required']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::date('primary_date_assigned', $user->primary_date_assigned, ['class' => 'form-control']) !!}
                        @else
                            {!!Form::hidden('primary_date_assigned', $user->primary_date_assigned)!!} {!!$user->primary_date_assigned!!}
                            <br/><br/>
                        @endif
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Secondary Assignment Information @if($permsObj->hasPermissions(['EDIT_MEMBER']))<a
                            class="del_assignment" data-position="secondary">(Clear)</a> @endif </legend>

                @if(empty($user->secondary_assignment) === false || $permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('secondary_assignment', "Chapter", ['class' => 'my']) !!}  @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('secondary_assignment', $chapters, $user->secondary_assignment, ['class' => 'selectize']) !!}
                            {!! Form::hidden('sassignment', $user->secondary_assignment, ['id' => 'sassignment']) !!}
                            @else
                                {!!Form::hidden('secondary_assignment', $user->secondary_assignment)!!} {!!$chapters[$user->secondary_assignment]!!}
                                <br/><br/>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('secondary_billet', 'Billet', ['class' => 'my']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('secondary_billet', $billets, $user->secondary_billet, ['class' => 'billet']) !!}
                            @else
                                {!!Form::hidden('secondary_billet', $user->secondary_billet)!!} {!!$user->secondary_billet!!}
                                <br/>
                                <br/>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('secondary_date_assigned', "Date Assigned", ['class' => 'my']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::date('secondary_date_assigned', $user->secondary_date_assigned, ['class' => 'form-control']) !!}
                            @else
                                {!!Form::hidden('secondary_date_assigned', $user->secondary_date_assigned)!!} {!!$user->secondary_date_assigned!!}
                                <br/><br/>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">None</div>
                    </div>
                @endif
            </fieldset>

            <fieldset>
                <legend>Additional Assignment Information @if($permsObj->hasPermissions(['EDIT_MEMBER']))<a
                            class="del_assignment" data-position="additional">(Clear)</a> @endif </legend>

                @if(empty($user->additional_assignment) === false || $permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('additional_assignment', "Chapter", ['class' => 'my']) !!}  @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('additional_assignment', $chapters, $user->additional_assignment, ['class' => 'selectize']) !!}
                            {!! Form::hidden('aassignment', $user->additional_assignment, ['id' => 'aassignment']) !!}
                            @else
                                {!!Form::hidden('additional_assignment', $user->additional_assignment)!!} {!!$chapters[$user->additional_assignment]!!}
                                <br/><br/>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('additional_billet', 'Billet', ['class' => 'my']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('additional_billet', $billets, $user->additional_billet, ['class' => 'billet']) !!}
                            @else
                                {!!Form::hidden('additional_billet', $user->additional_billet)!!} {!!$user->additional_billet!!}
                                <br/>
                                <br/>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('additional_date_assigned', "Date Assigned", ['class' => 'my']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::date('additional_date_assigned', $user->additional_date_assigned, ['class' => 'form-control']) !!}
                            @else
                                {!!Form::hidden('additional_date_assigned', $user->additional_date_assigned)!!} {!!$user->additional_date_assigned!!}
                                <br/><br/>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">None</div>
                    </div>
                @endif
            </fieldset>

            <fieldset>
                <legend>Supplemental Assignment Information @if($permsObj->hasPermissions(['EDIT_MEMBER']))<a
                            class="del_assignment" data-position="extra">(Clear)</a> @endif </legend>

                @if(empty($user->extra_assignment) === false || $permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('extra_assignment', "Chapter", ['class' => 'my']) !!}  @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('extra_assignment', $chapters, $user->extra_assignment, ['class' => 'selectize']) !!}
                            {!! Form::hidden('eassignment', $user->extra_assignment, ['id' => 'eassignment']) !!}
                            @else
                                {!!Form::hidden('extra_assignment', $user->extra_assignment)!!} {!!$chapters[$user->extra_assignment]!!}
                                <br/><br/>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('extra_billet', 'Billet', ['class' => 'my']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('extra_billet', $billets, $user->extra_billet, ['class' => 'billet']) !!}
                            @else
                                {!!Form::hidden('extra_billet', $user->extra_billet)!!} {!!$user->extra_billet!!}<br/>
                                <br/>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">
                            {!! Form::label('extra_date_assigned', "Date Assigned", ['class' => 'my']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::date('extra_date_assigned', $user->extra_date_assigned, ['class' => 'form-control']) !!}
                            @else
                                {!!Form::hidden('extra_date_assigned', $user->extra_date_assigned)!!} {!!$user->extra_date_assigned!!}
                                <br/><br/>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class=" col-sm-6  ninety Incised901Light form-group">None</div>
                    </div>
                @endif
            </fieldset>

            <fieldset>
                <legend>Rank and <span
                            class="ratingDisplay">{{$user->branch == 'RMMM' || $user->branch == 'CIVIL' ? ($user->branch == 'RMMM' ? 'Division' : 'Speciality') : 'Rating'}}</span>
                </legend>

                <div class="row">
                    <div class=" col-sm-4  ninety Incised901Light form-group">
                        {!! Form::label('display_rank', "Rank", ['class' => 'my']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('display_rank', $grades, $user->display_rank, ['class' => 'form-control', 'id' => 'rank']) !!} {{Form::hidden('current_rank', $user->display_rank, ['id' => 'current_rank'])}}
                        @else
                            {!!Form::hidden('display_rank', $user->display_rank)!!} {{$user->getGreeting()}}
                            ({{$user->display_rank}})
                            <br/><br/>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class=" col-sm-4  ninety Incised901Light form-group">
                        {!! Form::label('dor', "Date of Rank", ['class' => 'my']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::date('dor', $user->dor, ['class' => 'form-control']) !!}
                        @else
                            {!!Form::hidden('dor', $user->dor)!!} @if(empty($user->dor) === true)
                                Unknown<br/><br/> @else {!!$user->dor!!} @endif
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class=" col-sm-4  ninety Incised901Light form-group">
                        {!! Form::label('rating', $user->branch == 'RMMM' || $user->branch == 'CIVIL' ? ($user->branch == 'RMMM' ? 'Division' : 'Speciality') : 'Rating', ['class' => 'my ratingDisplay']) !!} @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true){!! Form::select('rating', $ratings, $user->rating, ['class' => 'form-control']) !!}
                        @else
                            {!!Form::hidden('rating', empty($user->rating['rate']) ? $user->rating : $user->rating['rate'])!!} @if(empty($user->rating)===true)
                                None @else {!!$user->rating['description']!!} @endif
                        @endif
                    </div>
                </div>
                @if($permsObj->hasPermissions(['EDIT_MEMBER']))
                    <div>
                        <label>
                            <input type="checkbox" checked name="tigCheck" id="tigCheck" value="1"> Check Time in Grade
                        </label>
                    </div>

                    <div>
                        <label>
                            <input type="checkbox" checked name="ppCheck" id="ppCheck" value="1"> Check Promotion Points
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="checkbox" name="ep" id="ep" value="1"> Early Promotion
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="checkbox" name="oqe" id="oqe" value="1"> OQE Promotion
                        </label>
                    </div>
                @endif

            </fieldset>
            @if($permsObj->hasPermissions(['ASSIGN_PERMS']) === true)
                <fieldset>
                    <legend>Database Permissions</legend>
                    <div class="row">
                        <div class=" col-sm-12 text-center">
                            Common Permission Sets<br/>

                            <button class="btn btn-xs btn-default" id="coPerms">Command Triad</button>
                            <button class="btn btn-xs btn-default" id="slPerms">Space Lord</button>
                            <button class="btn btn-xs btn-default" id="rmaPerms">RMA</button>
                            <button class="btn btn-xs btn-default" id="rmmcPerms">RMMC</button>
                            <button class="btn btn-xs btn-default" id="defaultPerms">Default</button>

                        </div>
                    </div>
                    <ul class="block-grid-sm-3 ninety">
                        @foreach(DB::table('permissions')->orderBy('name', 'asc')->get() as $permission)
                            @if(!in_array($permission['name'], config('permissions.restricted')) || $permsObj->checkRestrictedAccess($permission['name']))
                                <li>{!! Form::checkbox('permissions[]', $permission['name'], in_array($permission['name'], $user->permissions), ['id' => $permission['name'], 'class' => 'permissions']) !!}
                                    <span data-toggle="tooltip"
                                          title="{!!$permission['description']!!}">{!!$permission['name']!!}</span></li>
                            @elseif(in_array($permission['name'], config('permissions.restricted')) && !$permsObj->checkRestrictedAccess($permission['name']))
                                {!! Form::checkbox('permissions[]', $permission['name'], in_array($permission['name'], $user->permissions), ['id' => $permission['name'], 'class' => 'permissions', 'style' => 'display: none !important']) !!}
                            @endif
                        @endforeach
                    </ul>
                </fieldset>
            @else
                {!!Form::hidden('permissions', serialize($user->permissions))!!}
            @endif
            {!!Form::hidden('duty_roster', $user->duty_roster, ['id' => 'dutyroster'])!!}

            <div id="chooseShip" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-title">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="text-center">Select the Chapter(s) the DUTY_ROSTER permission is for</h4>
                        </div>
                        <div class="modal-body">
                            {!!Form::select('chapters[]', [], null, ['id' => 'chapters'])!!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="button"
                                    onclick="$('#dutyroster').val(''); var $select=$('#chapters').selectize(); $.each($select[0].selectize.getValue(), function(i, val) {$('#dutyroster').val($('#dutyroster').val() + ',' + val);}); $('#chooseShip').modal('hide');">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <a class="btn btn-danger" href="{!! route('user.show', ['user' => $user->id]) !!}"><span
                        class="fa fa-times"></span> Cancel </a>
            <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save</button>

            {!! Form::close() !!}
        </div>
        <div class=" col-sm-3">
            <div class="Incised901Light filePhoto">

                {!!$user->member_id!!}
                <div class="filePhotoBox">

                    @if(file_exists(public_path() . $user->filePhoto) && isset($user->filePhoto) === true)
                        <img src="{!!$user->filePhoto!!}?ts={{time()}}" alt="Official File Photo">
                    @else
                        <img/>
                    @endif
                    <div class="ofpt">
                        <form action='/api/photo' class='dropzone' id='trmnDropzone' method='post'
                              data-toggle="tooltip"
                              title="Drag and drop image files here or click.  Only .png, .gif and .jpg files will be accepted.  All images uploaded will be scaled to 150 pixels wide by 200 pixels tall.  After the image has been dropped, the form will be submitted and processed.">
                            {!! Form::hidden('member_id', $user->member_id) !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scriptFooter')
    <script type="text/javascript">
        $('#chapters').selectize({
            plugins: ['remove_button'],
            valueField: 'data',
            labelField: 'value',
            searchField: 'value',
            maxItems: null,
            create: false,
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '{!!route('chapter.find.api')!!}/' + encodeURIComponent(query),
                    type: 'GET',
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res.suggestions);
                    }
                });
            }@if(!empty($user->duty_roster)),
            onInitialize: function () {
                var self = this;
                @foreach(explode(',', $user->duty_roster) as $roster)
                self.addOption({
                    data: '{!!$roster!!}',
                    value: '{!!\App\Chapter::find($roster)->chapter_name!!}'
                });
                self.addItem('{!!$roster!!}');
                @endforeach
            }
            @endif
        });

        $('.billet').selectize({
            sortField: 'text'
        });

        $('#rating').on('change', function () {
            var rating = $('#rating').val();
            var branch = $('#branch').val();

            $.getJSON('/api/branch/' + rating + '/' + branch, function (result) {
                var grade = $('#rank').val();
                var options = '';

                $('#rank').empty();
                options = '<option value="">Select a Rank</option>';
                $.each(result, function (key, value) {
                    options += '<optgroup label="' + key + '">';

                    $.each(value, function (key, value) {
                        var option = '';
                        option = '<option value="' + key + '"';
                        if (grade == key) {
                            option += ' selected';
                        }
                        options += option + '>' + value + '</option>';
                    });

                    options += '</optgroup>';
                });
                $('#rank').append(options);
            });
        });

        $('#oqe').on('click', function () {
            if ($('#oqe').prop('checked')) {
                $('#tigCheck').prop('checked', false);
                $('#ppCheck').prop('checked', false);
                $('#ep').prop('checked', false);
            }
        });

        $('#tigCheck, #ppCheck, #ep').on('click', function () {
            if ($(this).prop('checked')) {
                $('#oqe').prop('checked', false);
            }
        });

        $('#rank').on('change', function () {
            if ($('#oqe').prop('checked')) {
                return;
            }
            let payload = {
                "member_id": $('#member_id').val(),
                "tigCheck": $('#tigCheck').prop('checked') ? true : false,
                "ppCheck": $('#ppCheck').prop('checked') ? true : false,
                "ep": $('#ep').prop('checked') ? true : false,
                "payGrade": $('#rank').val()
            };

            $.ajax({
                method: "POST",
                url: "/api/rankcheck",
                data: JSON.stringify(payload),
                contentType: 'application/json',
                dataType: 'json'
            })
                .done(function (data) {
                    if (data.valid === false) {
                        let msg = 'INVALID RANK' + "\n";

                        if (data.msg) {
                            $.each(data.msg, function (index, value) {
                                msg += "\n* " + value;
                            });
                        }

                        alert(msg);

                        $('#rank').val($('#current_rank').val());

                    }
                });
        });

        $('#tigCheck').on('change', function () {
            if ($('#tigCheck').prop('checked')) {
                $('#ep').prop('checked', false);
            }
        });

        $('#ep').on('change', function () {
            if ($('#ep').prop('checked')) {
                $('#tigCheck').prop('checked', false);
            }
        });

        $('.del_assignment').on('click', function () {
            let position = $(this).data('position');
            $("#" + position + "_date_assigned").val('');

            $.each(['_assignment', '_billet'], function (index, value) {
                let $select = $('#' + position + value).selectize();
                let $control = $select[0].selectize;
                $control.clear();
            });
        });
    </script>
@stop