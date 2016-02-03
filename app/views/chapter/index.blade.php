@extends('layout')

@section('pageTitle')
    Chapters
@stop

@section('content')
    <h1>Chapter List</h1>
    <table id="chapterList" class="compact row-border" width="75%">
        <thead>
        <tr>
            <th>Chapter Name</th>
            <th>Chapter Type</th>
            <th width="12%">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $chapters as $chapter )
            <?php
            switch ($chapter->chapter_type) {
                case 'task_force':
                case 'task_group':
                    $type = str_replace('_', ' ', $chapter->chapter_type);
                    break;
                case 'exp_force':
                    $type = 'Expeditionary Force';
                    break;
                default:
                    $type = $chapter->chapter_type;
            }
            ?>
            @if(empty($chapter->decommission_date) === false && $permsObj->hasPermissions(['VIEW_DSHIPS']) === false)
            @elseif($chapter->chapter_type == 'SU' && $permsObj->hasPermissions(['VIEW_SU']) === false)
            @else
                <tr>
                    <td><a href="{{route('chapter.show', [$chapter->id])}}">{{ $chapter->chapter_name }}
                            @if(in_array($chapter->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true)
                                {{ isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' }}
                            @endif
                        </a> @if(empty($chapter->decommission_date) === false)
                                <i class='fi-anchor' title='Reserve Fleet / Decomissioned'
                               alt="Reserve Fleet / Decommissioned" title="Reserve Fleet / Decommissioned"></i>
                        @endif</td>
                    <td>{{ ucwords($type) }}</td>
                    <td width="12%">
                        @if(in_array($chapter->chapter_type, ['ship', 'station']) === true)
                            @if($permsObj->hasPermissions(['EDIT_SHIP']) === true)
                                <a href="{{route('chapter.edit', [$chapter->id])}}" class="fi-pencil green"
                                   title="Edit Ship"></a>
                            @endif
                            @if($permsObj->hasPermissions(['DECOMMISSION_SHIP']) === true)
                                <a href="{{route('chapter.decommission', [$chapter->id])}}"
                                   class="fi-x red delete-chapter"
                                   title="Decommission Ship"></a>
                            @endif


                        @elseif(in_array($chapter->chapter_type, ['district', 'fleet', 'task_force', 'task_group', 'squadron', 'division']) === true)
                            @if($permsObj->hasPermissions(['EDIT_ECHELON']) === true)
                                <a href="{{route('echelon.edit', [$chapter->id])}}" class="fi-pencil green"
                                   title="Edit Echelon"></a>
                            @endif
                            @if($permsObj->hasPermissions(['DEL_ECHELON']) === true)
                                <a href="{{route('echelon.deactivate', [$chapter->id])}}"
                                   class="fi-x red delete-chapter"
                                   title="Deactivate Echelon"></a>
                            @endif

                        @elseif(in_array($chapter->chapter_type, ['shuttle', 'section', 'squad', 'platoon', 'company', 'battalion', 'corps', 'exp_force', 'regiment']) === true)
                            @if($permsObj->hasPermissions(['EDIT_MARDET']) === true)
                                <a href="{{route('mardet.edit', [$chapter->id])}}" class="fi-pencil green"
                                   title="Edit MARDET"></a>
                            @endif
                            @if($permsObj->hasPermissions(['DELETE_MARDET']) === true)
                                <a href="{{route('mardet.deactivate', [$chapter->id])}}"
                                   class="fi-x red delete-chapter"
                                   title="Deactivate MARDET"></a>
                            @endif

                        @elseif(in_array($chapter->chapter_type, ['bivouac', 'barracks', 'outpost', 'fort', 'planetary', 'theater']) === true)
                            @if($permsObj->hasPermissions(['EDIT_UNIT']) === true)
                                <a href="{{route('unit.edit', [$chapter->id])}}" class="fi-pencil green"
                                   title="Edit Command/Unit"></a>
                            @endif
                            @if($permsObj->hasPermissions(['DELETE_UNIT']) === true)
                                <a href="{{route('unit.deactivate', [$chapter->id])}}"
                                   class="fi-x red delete-chapter"
                                   title="Stand-down Command/Unit"></a>
                            @endif
                        @else
                            @if($permsObj->hasPermissions(['ALL_PERMS']) === true)
                                <a href="{{route('anyunit.edit', [$chapter->id])}}" class="fi-pencil green"
                                   title="Edit Command/Unit"></a>
                            @endif
                            @if($permsObj->hasPermissions(['ALL_PERMS']) === true)
                                <a href="{{route('anyunit.deactivate', [$chapter->id])}}"
                                   class="fi-x red delete-chapter"
                                   title="Deactivate Command/Unit"></a>
                            @endif
                            @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Chapter Name</th>
            <th>Chapter Type</th>
            <th width="12%">Actions</th>
        </tr>
        </tfoot>
    </table>
    @if($permsObj->hasPermissions(['COMMISSION_SHIP']) === true)
        <a href="{{ route('chapter.create') }}" class="button">Commission Ship</a>
    @endif
@stop
