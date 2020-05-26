<li class="tree">
    <a href="{{route('chapter.show', [$element['chapter']->id])}}">
        {{ $element['chapter']->chapter_name }}
        @if((in_array($element['chapter']->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true) &&
        isset($element['chapter']->hull_number) === true) ({{$element['chapter']->hull_number}}) @endif
    </a>
    @if($collapse && $element['children'])
        <strong>(Expand)</strong>
    @endif
    @if($element['children'])
        <ul>
            @foreach($element['children'] as $children)
                @include('chapter.child', ['element' => $children, 'collapse' => false])
            @endforeach
        </ul>
    @endif

</li>
