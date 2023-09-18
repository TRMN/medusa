<div class="col-sm-6">
    <ul class="list-group list-group-sortable-handles sortable">
        @foreach(App\Award::where('display_order', '<', 1000)->where('location', '!=', 'AWQ')->orderBy('display_order')->get() as $award)
            @include('awards.award')
        @endforeach
    </ul>
</div>