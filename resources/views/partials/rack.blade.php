@include('partials.leftribbons', ['user' => $user])

@if($user->leftRibbonCount)
    <div id="embeding" class="text-center">
        <a style="white-space: nowrap;" class="btn btn-danger btn-sm" role="button"
           data-trigger="click" data-container="#embeding" data-toggle="popover"
           data-placement="left" data-content="To embed your ribbon rack in other websites, use the following code:

                                &lt;iframe src=&quot;{!!url('api/ribbonrack/' . $user->member_id)!!}&quot;&gt;&lt;/iframe&gt;

Click again to close" title="How to embed your ribbon rack"><span class="fa fa-external-link"></span> Embeding
            Instructions</a>
    </div>


@endif