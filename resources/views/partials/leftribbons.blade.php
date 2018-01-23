<div class="ribbons">
@if((!empty($user->unitPatchPath) && file_exists(public_path($user->unitPatchPath))) || $user->getRibbons('LS'))
<div>
@foreach($user->getRibbons('LS') as $ribbon)
<img src="{!!asset('images/' . $ribbon['code'] . '.svg')!!}" alt="{!!$ribbon['name']!!}"
data-toggle="tooltip" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}"><br/>
@endforeach
@if(!empty($user->unitPatchPath) && file_exists(public_path($user->unitPatchPath)))
<img src="{!!asset($user->unitPatchPath)!!}"
class="patch{!!$user->getRibbons('LS')?' patch-with-unc' : ''!!}"><br/>
@endif
</div>
@endif
@foreach($user->getRibbons('TL') as $ribbon)
@if($ribbon['code'] == 'HS')
@for ($i = 0; $i < $ribbon['count']; $i++)
<img src="{!!asset('awards/badges/' . $ribbon['code'] . '-1.svg')!!}" alt="{!!$ribbon['name']!!}"
data-toggle="tooltip" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}">
@endfor
@else
<img src="{!!asset('awards/badges/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}"
alt="{!!$ribbon['name']!!}" data-toggle="tooltip" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}">
@endif
<br/>
@endforeach

@foreach($user->leftRibbons as $index => $ribbon)
@set('ribbonPath', 'ribbons/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')
@if(!file_exists(public_path($ribbonPath)) && $ribbon['count'] > 5)
@set('ribbonPath', 'ribbons/' . $ribbon['code'] . '-5.svg')
@elseif(!file_exists(public_path($ribbonPath)))
@set('ribbonPath', 'ribbons/' . $ribbon['code'] . '-1.svg')
@endif
<img src="{{asset($ribbonPath)}}" alt="{!!$ribbon['name']!!}" data-toggle="tooltip" title="{!!$ribbon['name']!!}" class="ribbon">@if($user->leftRibbonCount % $user->numAcross == $index % $user->numAcross) <br /> @endif
@endforeach

@if($user->hasAwards())
<br/><br/>
<div class="name-badge-wrapper">
<div class="name-badge-spacer">&nbsp;</div>
@if(in_array($user->branch, ['RMN', 'RMMC', 'RMA']))
@if($user->usePeerageLands)
<div class="name-badge-RMN">{{$user->extraPadding?'&nbsp;':''}}{{$user->getNameofLands()}}{{$user->extraPadding?'&nbsp;':''}}</div>
@else
<div class="name-badge-RMN">{{$user->extraPadding?'&nbsp;':''}}{{$user->last_name}}, {{substr($user->first_name, 0 , 1)}}{{$user->extraPadding?'&nbsp;':''}}</div>
@endif
<div class="name-badge-spacer">&nbsp;</div>
@elseif($user->branch === 'GSN')
<div class="name-badge-GSN">{{$user->extraPadding?'&nbsp;':''}}{{$user->last_name}}{{$user->extraPadding?'&nbsp;':''}}</div>
<div class="name-badge-spacer">&nbsp;</div>
@endif
</div>
@endif

@foreach($user->getRibbons('R') as $index => $ribbon)
<img src="{!!asset('ribbons/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}"
alt="{!!$ribbon['name']!!}"
data-toggle="tooltip" title="{!!$ribbon['name']!!}" class="citation">
@endforeach

@if($user->getRibbons('RS') && in_array($user->branch, ['RMN', 'RMMC', 'RMA']))
<div class="stripes">
@if(file_exists(public_path('patches/' . $user->branch . '.svg')))
<img src="{!!asset('patches/' . $user->branch . '.svg')!!}" alt="{!!$user->branch!!}"
data-toggle="tooltip" title="{!!$user->branch!!}" class="branch"><br />
@endif
@foreach($user->getRibbons('RS') as $ribbon)
<img src="{!!asset('awards/stripes/' . $ribbon['code'] . '-' . $ribbon['count'] . '.svg')!!}"
alt="{!!$ribbon['name']!!}" data-toggle="tooltip" title="{!!$ribbon['name']!!}" class="{!!$ribbon['code']!!}"><br />
@endforeach
</div>
@endif
</div>
