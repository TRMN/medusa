    <div class="Incised901Bold">
        {{ $user->getGreeting() }}({{$user->branch}})
        {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }} {{ $user->last_name }}{{ !empty($user->suffix) ? ' ' . $user->suffix : '' }}{{$user->getPostnominals()}}
    </div>