<div id="user-profile" class="row">
    <div class=" col-sm-12">
        <div class="float-left">
            <div class="Incised901Light filePhoto">
                <a href="/id/qrcode/{{$user->id}}">{{$user->member_id}}</a>
                <div class="filePhotoBox">

                    @if(file_exists(public_path() . $user->filePhoto) && isset($user->filePhoto) === true)
                        <img src="{{$user->filePhoto}}?{{time()}}" alt="Official File Photo">
                    @else
                        <div class="ofpt-rel">
                            Official<br/>File<br/>Photo
                        </div>
                    @endif


                </div>
                <div class="clear-both">
                    {{$user->getPrimaryBillet()}}<br/>

                    <div class="Incised901Light seventy-five">
                        Assigned: {{$user->getPrimaryDateAssigned()}}
                    </div>
                    @if(($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id) || $permsObj->hasPermissions(['EDIT_MEMBER']) || $permsObj->isInChainOfCommand($user))
                        <div class="Incised901Light">
                            Path: {{
                            Form::select(
                                    'path',
                                    [
                                        'service' => 'Service',
                                        'staff' => 'Staff',
                                        'line' => 'Line',
                                    ],
                                    $user->path,
                                    [
                                        'id' => 'path',
                                        'data-id' => $user->id,
                                        'title' => 'Click to change path',
                                        'data-paygrade' => $user->getPayGrade(),
                                        'data-member-id' => $user->member_id,
                                        'data-old-path' => $user->path,
                                    ]
                                )
                            }}
                            <span class="fa fa-info-circle info" title="Click your path to change it"></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @include('partials.greeting', ['user' => $user])
        @include('partials.assignments', ['user' => $user])
        @if($user->registration_status != "Pending")
            <div class="Incised901Black ninety">
                Time In
                Grade: {{is_null($tig = $user->getTimeInGrade())?'No Time In Grade information available at this time':$tig}}
            </div>
            <div class="Incised901Black ninety">
                Time In Service: {{$user->getTimeInService()}}
            </div>
            <div class="Incised901Black ninety">
                Highest Main Line Exam for Branch: <span
                        class="Incised901Light">{{$user->getHighestMainLineExamForBranch() ?  $user->getHighestMainLineExamForBranch() : "None"}}</span>
            </div>


            @if($permsObj->hasPermissions(['VIEW_NOTE']))
                <div class="sbAccordian mouse-pointer">

                    <?php

                    $currentNote = "";
                    $options = ["readonly" => true, "id" => "note_text"];

                    ?>
                    @if (!empty($user->note))

                        <?php
                        $currentNote = $user->note;
                        $title = '** VIEW';

                        if ($permsObj->hasPermissions(['EDIT_NOTE'])) {
                            $title .= '/EDIT';
                        }

                        $title .= ' NOTE **';
                        $options = ["id" => "note_text"];
                        ?>
                        <h5 id="note_container">{{$title}}</h5>
                    @elseif ($permsObj->hasPermissions(['EDIT_NOTE']))
                        <h5 id="note_container">Add Note</h5>
                        <?php
                        $options = ["id" => "note_text"];
                        ?>
                    @endif

                    @if (!empty($user->note) OR $permsObj->hasPermissions(['EDIT_NOTE']))
                        <div class='content'>
                            {{ Form::open(['route' => ['addOrEditNote', $user->id], 'method' => 'post', 'id'=>'note_form']) }}
                            <div class="row">
                                <div class=" col-sm-10 Incised901Light ">
                                    {{ Form::textarea('note_text', $currentNote, $options) }}
                                </div>
                            </div>
                            @if ($permsObj->hasPermissions(['EDIT_NOTE']))
                                <div class="row">
                                    <div class=" col-sm-10 Incised901Light ">
                                        <button class="btn btn-danger" id="note_clear">Delete</button>
                                        <button class="btn btn-warning" id="note_cancel">Cancel</button>
                                        {{Form::submit('Save', ['id' => 'save_note', 'class' => 'btn btn-success'])}}
                                    </div>
                                </div>
                            @endif
                            {{ Form::close() }}
                        </div>
                    @endif
                </div>
            @endif
            <div class="clear-both">
                <br/>

                @if(!empty($user->getPeerages()))
                    <h5 class="Incised901Black ninety">
                        @if(!empty($user->getPeerages()))
                            Peerages
                        @else
                            Peerage
                        @endif
                    </h5>
                    @foreach($user->getPeerages() as $peerage)
                        <div class="row">
                            <div class="col-sm-2 medium-2 large-2  text-left">
                                <?php
                                $path = '';

                                if ($peerage['code'] != 'K' && $peerage['title'] != 'Knight' && $peerage['title'] != 'Dame') {
                                    $path = null;
                                    if (empty($peerage['filename']) === false) {
                                        $path = '/arms/peerage/' . $peerage['filename'];
                                    }
                                    $fullTitle =
                                        $peerage['generation'] . ' ' . $peerage['title'] . ' of ' . $peerage['lands'];
                                    $toolTip = 'Arms for ' . $fullTitle;
                                } else {
                                    $orderInfo =
                                        \App\Korders::where('classes.postnominal', '=', $peerage['postnominal'])
                                            ->first();
                                    $path = '/awards/orders/medals/' . $orderInfo->filename;
                                    $fullTitle =
                                        $orderInfo->getClassName($peerage['postnominal']) . ', ' . $orderInfo->order;
                                    $toolTip = $orderInfo->order;
                                }
                                ?>
                                @if(file_exists(public_path() . $path) === true && empty($path) === false)
                                    <img class='crest' src="{{asset($path)}}"
                                         alt="{{$fullTitle}}"
                                         width="50px" data-toggle="tooltip" title="{{$toolTip}}">
                                @else
                                    &nbsp;
                                @endif
                            </div>
                            <div class="col-sm-8 medium-8 large-8  Incised901Light ninety text-left vertical-center-50px">
                                @if(empty($peerage['courtesy']) === false)
                                    <em>
                                        @endif
                                        {{$fullTitle}}
                                        @if(empty($peerage['courtesy']) === false)
                                    </em>
                                @endif
                            </div>

                            <div class="col-sm-2 medium-2 large-2  text-left vertical-center-50px">
                                @if($permsObj->hasPermissions(['EDIT_PEERAGE', 'DEL_PEERAGE']))
                                    @if($permsObj->hasPermissions(['EDIT_PEERAGE']))
                                        <a href="#" data-peerage-id="{{$peerage['peerage_id']}}"
                                           data-peerage-title="{{$peerage['title']}}"
                                           data-peerage-generation="{{$peerage['generation'] ?? ''}}"
                                           data-peerage-lands="{{$peerage['lands'] ?? ''}}"
                                           data-peerage-order="{{$orderInfo->id ?? ''}}"
                                           data-peerage-class="{{$peerage['postnominal'] ?? ''}}"
                                           data-peerage-courtesy="{{$peerage['courtesy'] ?? "0"}}"
                                           data-peerage-filename="{{$peerage['filename'] ?? ''}}"
                                           class="edit_peerage fa fa-pencil green">&nbsp;</a>
                                    @endif
                                    @if($permsObj->hasPermissions(['DEL_PEERAGE']))
                                        <a href="#" data-peerage-text="{{$fullTitle}}" data-user-id="{{$user->id}}"
                                           data-peerage-id="{{$peerage['peerage_id']}}"
                                           class="delete_peerage fa fa-trash red">
                                            &nbsp;</a>
                                    @endif
                                @else
                                    &nbsp;
                                @endif
                            </div>

                        </div>
                    @endforeach
                @endif
                @if($permsObj->hasPermissions(['ADD_PEERAGE']))
                    <div class="sbAccordian mouse-pointer">
                        <h5 id="peerage-container">Add Peerage</h5>
                        <div>
                            {{ Form::open(['route' => ['addOrEditPeerage', $user->id], 'method' => 'post', 'files' => true, 'id'=>'peerage_form']) }}
                            <div class="row">
                                <div class="col-sm-2 Incised901Light text-left">
                                    {{Form::select('ptitle', $ptitles, '', ['id' => 'ptitle', 'class' => 'white-border'])}}
                                    <br/>
                                    {{Form::checkbox('courtesy', 1, null, ['id' => 'courtesy'])}}
                                    <label for="courtesy" id="courtesy_label">Courtesy Title</label>
                                </div>
                                <div class="col-sm-2  Incised901Light text-left">
                                    {{Form::select('generation',
                                    ['' => 'Peerage Generation', 'First' => 'First', 'Second' => 'Second', 'Third' => 'Third', 'Fourth' => 'Fourth', 'Fifth'=> 'Fifth'], '',
                                    ['id' => 'generation', 'class' => 'white-border'])}}
                                    {{Form::select('order', $korders, '',['id' => 'order', 'class' => 'white-border'])}}
                                </div>
                                <div class="col-sm-6 Incised901Light text-left padding-left-5em">
                                    {{Form::text('lands', null, ['placeholder' => 'Peerage Lands', 'id' => 'lands'])}}
                                    {{Form::select('class', ['' => 'Select Class'], null, ['id' => 'class', 'class' => 'white-border'])}}
                                </div>
                            </div>
                            <div class="row padding-top-10">
                                <div class="col-sm-4 incised901light text-left">
                                    {{Form::label('arms','Upload Peerage Arms', ['id'=>'arms-label'])}}
                                    <input type="file" id="arms" name="arms">
                                </div>
                                <div class="col-sm-8  Incised901Light text-left ">
                                    <button class="btn btn-danger" id="cancel">Cancel</button>
                                    <button class="btn btn-success" type="submit">Save Peerage <span
                                                class="fa fa-save"></span></button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                @endif
                @endif
                <br/>
                <div class="Incised901Light ninety">Join
                    Date: {{ date('d M Y', strtotime($user->registration_date)) }}</div>
                @if($permsObj->hasPermissions(['DOB']) || ($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id))
                    <div class="Incised901Light ninety">Date of Birth: {{date('d M Y', strtotime($user->dob))}}</div>
                    <br/>
                @endif

                <div class="Incised901Black ninety">
                    Contact:
                    <div class="row">
                        <div class="col-sm-1  Incised901Light ninety">&nbsp;</div>
                        <div class="col-sm-10  Incised901Light ninety textLeft ">
                            {{ $user->address1 }}<br/>
                            @if(!empty($user->address2))
                                {{ $user->address2 }}<br/>
                            @endif
                            {{ $user->city }}, {{ $user->state_province }} {{ $user->postal_code }}<br/>
                            {{ $user->email_address }}<br/>
                            {!! isset($user->phone_number) ? $user->phone_number . '<br />' : '' !!}
                        </div>
                    </div>

                    @if($permsObj->hasPermissions(['ASSIGN_PERMS'])  && !empty($user->permissions))
                        <br/>
                        <div class="row Incised901Light">
                            <div class=" col-sm-2">Permissions:</div>
                            <div class=" col-sm-10">
                                @for ($i = 0; $i < count($user->permissions); $i += 2 )
                                    <div class="row">
                                        <div class="col-sm-6 ninety">
                                            {{isset($user->permissions[$i]) ? $user->permissions[$i] : ''}}
                                        </div>
                                        <div class="col-sm-6 ninety">
                                            {{isset($user->permissions[$i+1]) ? $user->permissions[$i+1] : ''}}
                                        </div>
                                    </div>
                                @endfor
                            </div>

                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-1  Incised901Light ninety">&nbsp;</div>
                        <div class="col-sm-10  Incised901Light ninety textLeft ">
                            <br/>
                            @if($user->registration_status != "Pending" && (($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id) || ($permsObj->hasPermissions(['EDIT_MEMBER']))))
                                <a href="{{route('user.edit', [$user->_id])}}"
                                   class="btn btn-success"><span class="fa fa-edit"></span> EDIT</a>
                            @elseif($permsObj->hasPermissions(['PROC_APPLICATIONS']))
                                <a href="{{route('user.approve', [$user->_id])}}"
                                   class="btn btn-success"><span class="fa fa-check"></span> Approve</a>
                                <a href="{{route('user.deny', [$user->_id])}}" class="btn btn-warning"><span
                                            class="fa fa-times"></span> DENY</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>