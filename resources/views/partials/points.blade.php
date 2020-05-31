{{ Form::open(['route' => ['user.points', $user->id]]) }}
{{ Form::hidden('id', $user->id) }}
<div class="container-fluid zebra" id="service">
    <div class="row bottom-border-double margin-bottom-10 padding-top-10 padding-bottom-10">
        <div class="col-sm-4 text-left">Service</div>
        <div class="col-sm-4 text-right">Total Months</div>
        <div class="col-sm-4 text-right">Points Earned</div>
    </div>
    <div class="row pp-row margin-bottom-10">
        <div class="col-sm-4">Every 3 months time in service
        </div>
        <div class="col-sm-4 text-right margin-bottom-10"><input type="number" class="text-right" data-target="tis"
                                                                 data-points="1"
                                                                 value="{{$user->getTimeInService(['format' => 'M'])}}"
                                                                 disabled="true"></div>
        <div class="col-sm-4 text-right"><span class="pp">{{$user->getPointsFromTimeInService()}}</span></div>
    </div>

    @foreach(App\MedusaConfig::get('pp.form-config', [], 'service') as $item)
        <div class="row pp-row margin-bottom-10">
            <div class="col-sm-4">{!! str_replace('/br/', '<br />', $item['title']) !!}</div>
            <div class="col-sm-4 text-right{{!strpos('/br/', $item['title']) ? ' margin-bottom-10': ''}}">
                {{Form::number("points[{$item['target']}]", empty($user->points[$item['target']]) ? 0 : $user->points[$item['target']], ['class' => $item['class'] . ' text-right', 'data-target' => $item['target'], 'data-points' => $item['points'], 'disabled' => !$permsObj->promotionPointsEditAccess($user), 'min' => 0])}}
            </div>
            <div class="col-sm-4 text-right"><span class="pp" id="{{$item['target']}}"></span></div>
        </div>
    @endforeach
</div>
<div class="container-fluid zebra">
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-12 text-right">
            Service Promotion Points Earned: <span id="service-pp"></span>
        </div>
    </div>
</div>
<br/>

<div class="container-fluid zebra" id="events">
    <div class="row bottom-border-double margin-bottom-10 padding-top-10 padding-bottom-10">
        <div class="col-sm-4 text-left">Events</div>
        <div class="col-sm-4 text-right">Number of Occurrences</div>
        <div class="col-sm-4 text-right">Points Earned</div>
    </div>

    @foreach(App\MedusaConfig::get('pp.form-config', [], 'events') as $item)
        <div class="row pp-row margin-bottom-10">
            <div class="col-sm-4">{!! str_replace('/br/', '<br />', $item['title']) !!}</div>
            <div class="col-sm-4 text-right{{!strpos('/br/', $item['title']) ? ' margin-bottom-10': ''}}">
                {{Form::number("points[{$item['target']}]", empty($user->points[$item['target']]) ? 0 : $user->points[$item['target']], ['class' => $item['class'] . ' text-right', 'data-target' => $item['target'], 'data-points' => $item['points'], 'disabled' => !$permsObj->promotionPointsEditAccess($user), 'min' => 0])}}
            </div>
            <div class="col-sm-4 text-right"><span class="pp" id="{{$item['target']}}"></span></div>
        </div>
    @endforeach
</div>
<div class="container-fluid zebra">
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-12 text-right">
            Event Promotion Points Earned: <span id="events-pp"></span>
        </div>
    </div>
</div>
<br/>

<div class="container-fluid zebra" id="parliament">
    <div class="row bottom-border-double margin-bottom-10 padding-top-10 padding-bottom-10">
        <div class="col-sm-4 text-left">Service in Parliament</div>
        <div class="col-sm-4 text-right">Number of Years</div>
        <div class="col-sm-4 text-right">Points Earned</div>
    </div>

    @foreach(App\MedusaConfig::get('pp.form-config', [], 'parliament') as $item)
        <div class="row pp-row margin-bottom-10">
            <div class="col-sm-4">{!! str_replace('/br/', '<br />', $item['title']) !!}</div>
            <div class="col-sm-4 text-right{{!strpos('/br/', $item['title']) ? ' margin-bottom-10': ''}}">
                {{Form::number("points[{$item['target']}]", empty($user->points[$item['target']]) ? 0 : $user->points[$item['target']], ['class' => $item['class'] . ' text-right', 'data-target' => $item['target'], 'data-points' => $item['points'], 'disabled' => !$permsObj->hasPermissions(['EDIT_MEMBER']), 'min' => 0])}}
            </div>
            <div class="col-sm-4 text-right"><span class="pp" id="{{$item['target']}}"></span></div>
        </div>
    @endforeach
</div>
<div class="container-fluid zebra">
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-12 text-right">
            Parliament Promotion Points Earned: <span id="parliament-pp"></span>
        </div>
    </div>
</div>

<br/>
<div class="container-fluid zebra" id="peerages">
    <div class="row bottom-border-double margin-bottom-10 padding-top-10 padding-bottom-10">
        <div class="col-sm-4 text-left">Peerages</div>
        <div class="col-sm-4 text-right">&nbsp;</div>
        <div class="col-sm-4 text-right">Points Earned</div>
    </div>
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-4">Investiture as a</div>
        <div class="col-sm-4 text-right">
            {{Form::select('points[peerage]', ['B' => 'Baron/Baroness', 'E' => 'Earl/Countess', 'S' => 'Steadholder', 'D' => 'Duke/Duchess', 'L' => 'Senator for Life', 'G' => 'Grand Duke/Grand Duchess'], empty($user->points['peerage']) ? null : $user->points['peerage'], ['placeholder' => 'Select Peerage', 'class' => 'pp-calc-select', 'data-target' => 'peerage', 'disabled' => !$permsObj->hasPermissions(['EDIT_MEMBER'])])}}
            @if(!$permsObj->hasPermissions(['EDIT_MEMBER']))
                {{Form::hidden('points[peerage]', empty($user->points['peerage']) ? null : $user->points['peerage'])}}
            @endif
        </div>
        <div class="col-sm-4 text-right"><span class="pp" id="peerage"></span></div>
    </div>
</div>
<div class="container-fluid zebra">
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-12 text-right">
            Peerage Promotion Points Earned: <span id="peerages-pp"></span>
        </div>
    </div>
</div>

<br/>
<div class="container-fluid zebra" id="awards">
    <div class="row bottom-border-double margin-bottom-10 padding-top-10 padding-bottom-10">
        <div class="col-sm-4 text-left">Awards & Coursework</div>
        <div class="col-sm-4 text-right">&nbsp;</div>
        <div class="col-sm-4 text-right">Points Earned</div>
    </div>
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-4">Promotion Points from Awards</div>
        <div class="col-sm-4 text-right"><input type="number" class="pp-calc text-right"
                                                value="{{$user->getPointsFromAwards()}}" disabled="true"></div>
        <div class="col-sm-4 text-right"><span class="pp">{{$user->getPointsFromAwards()}}</span></div>
    </div>
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-4">Promotion Points from Coursework</div>
        <div class="col-sm-4 text-right"><input type="number" class="pp-calc text-right"
                                                value="{{$user->getPointsFromExams()}}" disabled="true"></div>
        <div class="col-sm-4 text-right"><span class="pp">{{$user->getPointsFromExams()}}</span></div>
    </div>
</div>

<div class="container-fluid" id="early">
    <div class="row bottom-border-double margin-bottom-10 padding-top-10 padding-bottom-10">
        <div class="col-sm-4 text-left">Early Promotion</div>
        <div class="col-sm-4 text-right">&nbsp;</div>
        <div class="col-sm-4 text-right">Points Used</div>
    </div>
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-4">Promotion Points used for early promotion</div>
        <div class="col-sm-4 text-right"></div>
        <div class="col-sm-4 text-right"><span class="pp">{{empty($user->points['ep'])? 0 : $user->points['ep']}}</span>
        </div>
    </div>
</div>

<div class="container-fluid zebra">
    <div class="row pp-row margin-bottom-10 padding-bottom-10">
        <div class="col-sm-12 text-right">
            Total Promotion Points: <span id="total-pp"></span>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row margin-bottom-10 padding-bottom-10 padding-top-10 text-center">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-success">Update Promotion Points</button>
        </div>
    </div>
</div>
{{ Form::close() }}