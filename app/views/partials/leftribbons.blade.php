<div class="text-center ribbons">
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