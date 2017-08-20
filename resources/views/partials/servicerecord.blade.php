<div id="user-profile" class="row">
    <div class=" col-sm-8">
        <ul class="tabs" data-tab>
            <li class="tab-title active"><a href="#">Service Record</a></li>
            <li class="tab-title"><a href="#">Promotion Points</a></li>
        </ul>
        <h4 class="trmn my">
            @if($user->registration_status != "Pending")
                Service Record
            @else
                Member Application
            @endif
        </h4>

        <h5 class="Incised901Light ninety">Last
            Login: {!!date('d M Y @ g:i A T', strtotime($user->getLastLogin()))!!}</h5>


        @include('partials.greeting', ['user' => $user])
        @include('partials.assignments', ['user' => $user])
        @if($user->registration_status != "Pending")
            <div class="Incised901Black ninety">
                Time In
                Grade: {!!is_null($tig = $user->getTimeInGrade())?'No Time In Grade information available at this time':$tig!!}
            </div>
            <div class="Incised901Black ninety">
                Time In Service: {!!$user->getTimeInService()!!}
            </div>

            <br/>

            @if($permsObj->hasPermissions(['VIEW_NOTE']))
                <div class="sbAccordian">

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
                        <h5 id="note_container">{!!$title!!}</h5>
                    @elseif ($permsObj->hasPermissions(['EDIT_NOTE']))
                        <h5 id="note_container">Add Note</h5>
                        <?php
                        $options = ["id" => "note_text"];
                        ?>
                    @endif

                    @if (!empty($user->note) OR $permsObj->hasPermissions(['EDIT_NOTE']))
                        <div class='content'>
                            {!! Form::open(['route' => ['addOrEditNote', $user->id], 'method' => 'post', 'id'=>'note_form']) !!}
                            <div class="row">
                                <div class=" col-sm-10 Incised901Light ">
                                    {!! Form::textarea('note_text', $currentNote, $options) !!}
                                </div>
                            </div>
                            @if ($permsObj->hasPermissions(['EDIT_NOTE']))
                                <div class="row">
                                    <div class=" col-sm-10 Incised901Light ">
                                        <button class="btn btn-danger" id="note_clear">Delete</button>
                                        <button class="btn btn-warning" id="note_cancel">Cancel</button>
                                        {!!Form::submit('Save', ['id' => 'save_note', 'class' => 'btn btn-success'])!!}
                                    </div>
                                </div>
                            @endif
                            {!! Form::close() !!}
                        </div>
                    @endif
                </div>
            @endif

            <br/>

            @if(count($user->getPeerages()))
                <h5 class="Incised901Black ninety">
                    @if(count($user->getPeerages())>1)
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
                                <img class='crest' src="{!!asset($path)!!}"
                                     alt="{!!$fullTitle!!}"
                                     width="50px" data-toggle="tooltip" title="{!!$toolTip!!}">
                            @else
                                &nbsp;
                            @endif
                        </div>
                        <div class="col-sm-8 medium-8 large-8  Incised901Light ninety text-left vertical-center-50px">
                            @if(empty($peerage['courtesy']) === false)
                                <em>
                                    @endif
                                    {!!$fullTitle!!}
                                    @if(empty($peerage['courtesy']) === false)
                                </em>
                            @endif
                        </div>

                        <div class="col-sm-2 medium-2 large-2  text-left vertical-center-50px">
                            @if($permsObj->hasPermissions(['EDIT_PEERAGE', 'DEL_PEERAGE']))
                                @if($permsObj->hasPermissions(['EDIT_PEERAGE']))
                                    <a href="#" data-peerage-id="{!!$peerage['peerage_id']!!}"
                                       data-peerage-title="{!!$peerage['title']!!}"
                                       data-peerage-generation="{!!$peerage['generation'] or ''!!}"
                                       data-peerage-lands="{!!$peerage['lands'] or ''!!}"
                                       data-peerage-order="{!!$orderInfo->id or ''!!}"
                                       data-peerage-class="{!!$peerage['postnominal'] or ''!!}"
                                       data-peerage-courtesy="{!!$peerage['courtesy'] or "0"!!}"
                                       data-peerage-filename="{!!$peerage['filename'] or ''!!}"
                                       class="edit_peerage fa fa-pencil green">&nbsp;</a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_PEERAGE']))
                                    <a href="#" data-peerage-text="{!!$fullTitle!!}" data-user-id="{!!$user->id!!}"
                                       data-peerage-id="{!!$peerage['peerage_id']!!}"
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
                <div class="sbAccordian">
                    <h5 id="peerage-container">Add Peerage</h5>
                    <div>
                        {!! Form::open(['route' => ['addOrEditPeerage', $user->id], 'method' => 'post', 'files' => true, 'id'=>'peerage_form']) !!}
                        <div class="row">
                            <div class="col-sm-2 Incised901Light ninety text-left">
                                {!!Form::select('ptitle', $ptitles, '', ['id' => 'ptitle'])!!}
                            </div>
                            <div class="col-sm-2 Incised901Light ninety text-left">
                                {{Form::checkbox('courtesy', 1, null, ['id' => 'courtesy'])}}
                                <label for="courtesy" id="courtesy_label">Courtesy Title</label>
                            </div>
                            <div class="col-sm-2  Incised901Light ninety text-left">
                                {!!Form::select('generation',
                                ['' => 'Peerage Generation', 'First' => 'First', 'Second' => 'Second', 'Third' => 'Third', 'Fourth' => 'Fourth', 'Fifth'=> 'Fifth'], '',
                                ['id' => 'generation'])!!}
                                {!!Form::select('order', $korders, '',['id' => 'order'])!!}
                            </div>
                            <div class="col-sm-6 Incised901Light ninety text-left">
                                {!!Form::text('lands', null, ['placeholder' => 'Peerage Lands', 'id' => 'lands'])!!}
                                {!!Form::select('class', ['' => 'Select Class'], null, ['id' => 'class'])!!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 incised901light ninety text-left">
                                {!!Form::label('arms','Upload Peerage Arms', ['id'=>'arms-label'])!!}
                                <input type="file" id="arms" name="arms">
                            </div>
                            <div class="col-sm-8  Incised901Light ninety text-left ">
                                <button class="btn btn-danger" id="cancel">Cancel</button>
                                <button class="btn btn-success" type="submit">Save Peerage <span class="fa fa-save"></span></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endif
            @include('partials.coursework', ['user' => $user])
        @endif
        <br/>
        <div class="Incised901Light ninety">Join Date: {{ date('d M Y', strtotime($user->registration_date)) }}</div>
        @if($permsObj->hasPermissions(['DOB']) || ($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id))
            <div class="Incised901Light ninety">Date of Birth: {!!date('d M Y', strtotime($user->dob))!!}</div>
            <br/>
        @endif

        <div class="Incised901Black ninety">
            Contact:
            <div class="row">
                <div class="col-sm-1  Incised901Light ninety">&nbsp;</div>
                <div class="col-sm-10  Incised901Light ninety textLeft ">
                    {!! $user->address1 !!}<br/>
                    @if(!empty($user->address2))
                        {!! $user->address2 !!}<br/>
                    @endif
                    {!! $user->city !!}, {!! $user->state_province !!} {!! $user->postal_code !!}<br/>
                    {!! $user->email_address !!}<br/>
                    {!! isset($user->phone_number) ? $user->phone_number . '<br />' : '' !!}
                </div>
            </div>

            @if($permsObj->hasPermissions(['ASSIGN_PERMS'])  && !empty($user->permissions))
                <br/>
                <div class="row Incised901Light">
                    <div class=" col-sm-2">Permissions:</div>
                    <div class=" col-sm-10">
                        <ul class="ninety two-col-grid">
                            @foreach($user->permissions as $permmission)
                                <li>{!!$permmission!!}</li>
                            @endforeach
                        </ul>
                        @for ($i = 0; $i < count($user->permissions); $i += 2 )

                        @endfor
                    </div>

                </div>
            @endif

            <div class="row">
                <div class="col-sm-1  Incised901Light ninety">&nbsp;</div>
                <div class="col-sm-10  Incised901Light ninety textLeft ">
                    <br/>
                    @if($user->registration_status != "Pending" && (($permsObj->hasPermissions(['EDIT_SELF']) && Auth::user()->id == $user->id) || ($permsObj->hasPermissions(['EDIT_MEMBER']))))
                        <a href="{!!route('user.edit', [$user->_id])!!}"
                           class="editButton Incised901Black margin-5">EDIT</a>
                    @elseif($permsObj->hasPermissions(['PROC_APPLICATIONS']))
                        <a href="{!!route('user.approve', [$user->_id])!!}" class="editButton Incised901Black margin-5">Approve</a>
                        <a href="{!!route('user.deny', [$user->_id])!!}" class="editButton
                        Incised901Black margin-5">DENY</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class=" col-sm-4">
        <div class="Incised901Light filePhoto">
            <a href="/id/qrcode/{!!$user->id!!}">{!!$user->member_id!!}</a>
            <div class="filePhotoBox">

                @if(file_exists(public_path() . $user->filePhoto) && isset($user->filePhoto) === true)
                    <img src="{!!$user->filePhoto!!}?{{time()}}" alt="Official File Photo">
                @else
                    @if($user->hasAwards())
                        <div class="ofpt-rel">
                            @else
                                <div class="ofpt">
                                    @endif
                                    Official<br/>File<br/>Photo
                                </div>
                            @endif

                        </div>
                        {!!$user->getPrimaryBillet()!!}<br/>

                        <div class="Incised901Light seventy-five">
                            Assigned: {!!$user->getPrimaryDateAssigned()!!}</div>
                        @include('partials.leftribbons', ['user' => $user])

                        @if($user->leftRibbonCount)
                            <div id="embeding">
                                <a style="white-space: nowrap;" class="btn btn-danger btn-sm" role="button" data-trigger="click" data-container="#embeding" data-toggle="popover" data-placement="left" data-content="To embed your ribbon rack in other websites, use the following code:

                                &lt;iframe src=&quot;{!!url('api/ribbonrack/' . $user->member_id)!!}&quot;&gt;&lt;/iframe&gt;

Click again to close" title="How to embed your ribbon rack"><span class="fa fa-external-link"></span> Embeding Instructions</a>
                            </div>


                        @endif
            </div>
        </div>
    </div>
</div>