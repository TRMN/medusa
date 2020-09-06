<div class="Incised901Bold">
    {!! $user->getGreeting() !!}
    {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {!! $user->last_name !!}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}{!!$user->getPostnominals()!!}
    , {!!$user->branch!!} @if($user->branch == 'CIVIL') ({{ $user->getRate() }}) @endif

    @if($permsObj->hasPermissions(['ID_CARD']) === true && empty($user->idcard_printed))
        <a class="fa fa-credit-card green size-24" href="/id/card/{!!$user->id!!}"
           data-toggle="tooltip" title="ID Card"></a>
        <a class="fa fa-check green size-24" href="/id/mark/{!!$user->id!!}"
           data-toggle="tooltip" title="Mark ID Card as printed"
           onclick="return confirm('Mark ID card as printed for this memberr?')"></a>
    @elseif($permsObj->hasPermissions(['ID_CARD']) === true && !empty($user->idcard_printed))
        <a class="fa fa-print size-24" href="/id/card/{!!$user->id!!}"
           data-toggle="tooltip" title="ID Card printed, click to reprint"></a>
    @endif
    @if($permsObj->hasPermissions(['USER_MASQ'], true) && $user->id != Auth::id())
        <a class="fa fa-user-secret size-24" href="{{route('switch.start', [$user->id])}}" data-toggle="tooltip"
           title="Login as this user"></a>
    @endif
    @if($permsObj->hasPermissions(['EDIT_RR'], true) && $user->id != Auth::id())
        <a class="fa fa-bars size-24" href="{{route('ribbonRack', [$user->id])}}" data-toggle="tooltip"
           title="Edit members ribbon rack"></a>
    @endif
    <br/>
    <span class="Incised901Light"><em>Date of Rank: {{ date('d M Y', strtotime($user->getDateOfRank())) }}</em></span>
</div>