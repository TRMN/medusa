<div class="ribbons">
@if((!empty($user->unitPatchPath) && file_exists(public_path($user->unitPatchPath))) || $user->getRibbons('LS'))
<div>
@foreach($user->getRibbons('LS') as $ribbon)
<img src="{!!asset('images/' . $ribbon['code'] . '.svg')!!}" alt="{!!$ribbon['name']!!}" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}"><br />
@endforeach
@if(!empty($user->unitPatchPath) && file_exists(public_path($user->unitPatchPath)))
<img src="{!!asset($user->unitPatchPath)!!}" class="patch{!!$user->getRibbons('LS')?' patch-with-unc' : ''!!}"><br />
@endif
</div>
@endif
@foreach($user->getRibbons('TL') as $ribbon)
@if($ribbon['code'] == 'HS')
@for ($i = 0; $i < $ribbon['count']; $i++)
<img src="{!!asset('awards/badges/' . $ribbon['code'] . '-1.svg')!!}" alt="{!!$ribbon['name']!!}" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}">
@endfor
@else
<img src="{!!asset('awards/badges/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}" alt="{!!$ribbon['name']!!}" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}">
@endif
<br />
@endforeach
@foreach($user->getRibbons('L') as $index => $ribbon)
<img src="{!!asset('ribbons/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}" alt="{!!$ribbon['name']!!}" title="{!!$ribbon['name']!!}" class="ribbon">@if($user->leftRibbonCount % 3 === $index)
<br />
@endif
@endforeach

@if($user->hasAwards())
<br /><br />
<div class="name-badge-wrapper"><div class="name-badge-spacer">&nbsp;</div>
@if($user->branch === 'RMN')
<div class="name-badge-RMN">{{$user->last_name}}, {{substr($user->first_name, 0 , 1)}}</div><div class="name-badge-spacer">&nbsp;</div></div>
@elseif($user->branch === 'GSN')
<div class="name-badge-GSN">{{$user->last_name}}</div><div class="name-badge-spacer">&nbsp;</div></div>
@endif
@endif

@foreach($user->getRibbons('R') as $index => $ribbon)
<img src="{!!asset('ribbons/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}" alt="{!!$ribbon['name']!!}" title="{!!$ribbon['name']!!}" class="citation">
@endforeach

@if($user->getRibbons('RS') && in_array($user->branch, ['RMN', 'RMMC', 'RMA']))
<div class="stripes">
@if(file_exists(public_path('patches/' . $user->branch . '.svg')))
<img src="{!!asset('patches/' . $user->branch . '.svg')!!}" alt="{!!$user->branch!!}" title="{!!$user->branch!!}" class="branch">
@endif
@foreach($user->getRibbons('RS') as $ribbon)
<img src="{!!asset('awards/stripes/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}" alt="{!!$ribbon['name']!!}" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}">
@endforeach
</div>
@endif
</div>
