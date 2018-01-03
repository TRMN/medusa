<table class="crewlist compact row-border" id="{{ $tableId }}">
    <thead>
    <tr>
        @if($showSelect)
            <th class="fiftypixels">{{ Form::checkbox('all[]', 1, false, ['class' => 'selectAll', 'data-target' => $tableId]) }}
                All
            </th>
        @else
            <th class="fiftypixels">&nbsp;</th>
        @endif
        <th>Name</th>
        <th>Primary Chapter</th>
        <th class="pixels-100">Eligible for</th>
    </tr>
    </thead>
    <tbody>
    @foreach($members as $member)
        <tr>
            @if($showSelect)
                <td class="fiftypixels text-center">{{ Form::checkbox($tableId . '[]', $member->id, false, ['data-grade' => $member->next_grade, 'class' => $tableId . '-selected']) }}</td>
            @else
                <td class="fiftypixels">&nbsp;</td>
            @endif
            <td>{{ $member->fullName }}</td>
            <td>{{ $member->primaryChapter }}</td>
            <td class="pixels-100 text-center">{{ $member->next_grade }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        @if($showSelect)
            <th class="fiftypixels"></th>
        @else
            <th class="fiftypixels">&nbsp;</th>
        @endif
        <th>Name</th>
        <th>Primary Chapter</th>
        <th class="pixels-100">Eligible for</th>
    </tr>
    </tfoot>

</table>