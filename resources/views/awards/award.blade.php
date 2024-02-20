<li id="{{$award->code}}" class="list-group-item text-center nobackground" draggable="true"
    data-display_order="{{$award->display_order}}" data-code="{{$award->code}}">
    @if(file_exists(public_path('ribbons/' . $award->code . '-1.svg')))
        <img src="{!!asset('ribbons/' . $award->code . '-1.svg')!!}" alt="{!!$award->name!!}"
             class="ribbon padding-bottom-10"><br/>
    @endif
    {{$award->name}}<br/>
    <div class="padding-top-10 btn-group-xs">
        <button id="editBtn" class="btn btn-xs btn-primary" data-toggle="modal"
                data-target="#awardForm"
                data-code="{{$award->code}}" data-name="{{$award->name}}"
                data-postnom="{{$award->post_nominal}}" data-location="{{$award->location}}"
                data-replaces="{{$award->replaces}}" data-multiple="{{$award->multiple}}"
                data-points="{{$award->points}}" data-nation="{{$award->star_nation}}"
                data-display-order="{{$award->display_order}}"><span
                    class="fa fa-edit"></span> Edit
        </button>
        <button id="addBtn" class="btn btn-xs btn-success" data-toggle="modal" data-target="#awardForm"
                data-prev-id="{{$award->code}}"> Insert award below <span
                    class="fa fa-arrow-down"></span></button>
    </div>
</li>