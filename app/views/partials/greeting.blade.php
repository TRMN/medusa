<div class="Incised901Bold">
    {{ $user->getGreeting() }}
    {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}{{$user->getPostnominals()}}
    , {{$user->branch}} @if($permsObj->hasPermissions(['ID_CARD']) === true && empty($detail->idcards_printed))
        <a class="fi-credit-card green size-24" href="/id/card/{{$user->id}}"
           title="ID Card"></a>
        <a class="fi-check green size-24" href="/id/mark/{{$user->id}}"
           title="Mark ID Card as printed"
           onclick="return confirm('Mark ID card as printed for this memberr?')"></a>
    @elseif($permsObj->hasPermissions(['ID_CARD']) === true && !empty($detail->idcards_printed))
        <span class="fi-print size-24" title="ID Cards printed"></span>
    @endif
</div>