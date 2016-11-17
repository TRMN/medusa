<div class="ribbons">
@foreach($user->getRibbons('LS') as $ribbon)
<img src="{{asset('images/' . $ribbon['code'] . '.svg')}}" alt="{{$ribbon['name']}}" title="{{$ribbon['name']}}" class="{{$ribbon['code']}}">
@endforeach
@if(file_exists(public_path($user->getShoulderPatchPath())))
<img src="{{asset($user->getShoulderPatchPath())}}" alt="{{$user->getAssignmentName('primary')}}" title="{{$user->getAssignmentName('primary')}}" class="patch{{$user->getRibbons('LS')?' patch-with-unc' : ''}}"><br />
@endif
@foreach($user->getRibbons('TL') as $ribbon)
@if($ribbon['code'] == 'HS')
@for ($i = 0; $i < $ribbon['count']; $i++)
<img src="{{asset('awards/badges/' . $ribbon['code'] . '-1.svg')}}" alt="{{$ribbon['name']}}" title="{{$ribbon['name']}}" class="{{$ribbon['code']}}">
@endfor
@else
<img src="{{asset('awards/badges/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')}}" alt="{{$ribbon['name']}}" title="{{$ribbon['name']}}" class="{{$ribbon['code']}}">
@endif
<br />
@endforeach
@foreach($user->getRibbons('L') as $index => $ribbon)
<img src="{{asset('ribbons/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')}}" alt="{{$ribbon['name']}}" title="{{$ribbon['name']}}">@if($user->leftRibbonCount % 3 === $index)
<br />
@endif
@endforeach
</div>
@if($user->getRibbons('RS'))
<div class="stripes">
@if(file_exists(public_path('patches/' . $user->branch . '.svg')))
<img src="{{asset('patches/' . $user->branch . '.svg')}}" alt="{{$user->branch}}" title="{{$user->branch}}" class="branch">
@endif
@foreach($user->getRibbons('RS') as $ribbon)
<img src="{{asset('awards/stripes/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')}}" alt="{{$ribbon['name']}}" title="{{$ribbon['name']}}" class="{{$ribbon['code']}}">
@endforeach
</div>
@endif

