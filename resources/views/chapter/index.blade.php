@extends('layout')

@section('pageTitle')
    Chapters
@stop

@section('content')
    <h1>Chapter List</h1>
    <table id="chapterList" class="table compact row-border">
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
                case 'small_craft':
                    $type = str_replace('_', ' ', $chapter->chapter_type);
                    break;
                case 'exp_force':
                    $type = 'Expeditionary Force';
                    break;
                case 'lac':
                    $type = 'LAC';
                    break;
                default:
                    $type = $chapter->chapter_type;
            }
            ?>
            @if(empty($chapter->decommission_date) === false && $permsObj->hasPermissions(['VIEW_DSHIPS']) === false)
            @elseif($chapter->chapter_type == 'SU' && $permsObj->hasPermissions(['VIEW_SU']) === false)
            @else
                <tr class="zebra-odd">
                    <td><a href="{!!route('chapter.show', [$chapter->id])!!}">{!! $chapter->chapter_name !!}
                            @if(in_array($chapter->chapter_type, ['task_force', 'task_group', 'squadron', 'division', 'ship', 'station']) === true)
                                {!! isset($chapter->hull_number) ? ' (' . $chapter->hull_number . ')' : '' !!}
                            @endif
                        </a>
                        @if(file_exists(public_path('patches/' . $chapter->chapter_type . '/' . (empty($chapter->branch) || $chapter->chapter_type == 'bureau' ? '' : $chapter->branch . '/') . trim($chapter->hull_number) . '.svg')))
                            &nbsp;<img style="height:40px;" src="{{asset('patches/' . $chapter->chapter_type . '/' . (empty($chapter->branch) || $chapter->chapter_type == 'bureau' ? '' : $chapter->branch . '/') . trim($chapter->hull_number) . '.svg')}}">
                        @endif
                        @if(empty($chapter->decommission_date) === false)
                            <i class='fa fa-anchor' title='Reserve Fleet / Decomissioned'
                               alt="Reserve Fleet / Decommissioned" title="Reserve Fleet / Decommissioned"></i>
                        @endif
                        @if(in_array($chapter->chapter_type, ['ship', 'station', 'small_craft', 'lac']) === true && empty($chapter->idcards_printed) && empty($chapter->decommission_date) && $permsObj->hasPermissions(['ID_CARD']))
                            <a class="fa fa-credit-card green size-24" href="/id/bulk/{!!$chapter->id!!}"
                               title="Print ID Cards"></a>
                            <a class="fa fa-check green size-24" href="/id/markbulk/{!!$chapter->id!!}"
                               title="Mark ID Cards as printed"
                               onclick="return confirm('Mark ID cards as printed for this chapter?')"></a>
                        @elseif(in_array($chapter->chapter_type, ['ship', 'station', 'small_craft', 'lac']) === true && !empty($chapter->idcards_printed) && empty($chapter->decommission_date) && $permsObj->hasPermissions(['ID_CARD']))
                            <span class="fa fa-print size-24" title="ID Cards printed"></span> @endif
                    </td>
                    <td>{!! ucwords($type) !!}</td>
                    <td width="12%">
                        @if(in_array($chapter->chapter_type, ['ship', 'station', 'small_craft', 'lac']) === true)
                            @if($permsObj->hasPermissions(['EDIT_SHIP']) === true)
                                <a href="{!!route('chapter.edit', [$chapter->id])!!}" class="fa fa-pencil green"
                                   title="Edit Ship"></a>
                            @endif
                            @if($permsObj->hasPermissions(['DECOMMISSION_SHIP']) === true)
                                <a href="{!!route('chapter.decommission', [$chapter->id])!!}"
                                   class="fa fa-x red delete-chapter"
                                   title="Decommission Ship"></a>
                            @endif


                        @elseif(in_array($chapter->chapter_type, ['district', 'fleet', 'task_force', 'task_group', 'squadron', 'division']) === true)
                            @if($permsObj->hasPermissions(['EDIT_ECHELON']) === true)
                                <a href="{!!route('echelon.edit', [$chapter->id])!!}" class="fa fa-pencil green"
                                   title="Edit Echelon"></a>
                            @endif
                            @if($permsObj->hasPermissions(['DEL_ECHELON']) === true)
                                <a href="{!!route('echelon.deactivate', [$chapter->id])!!}"
                                   class="fa fa-x red delete-chapter"
                                   title="Deactivate Echelon"></a>
                            @endif

                        @elseif(in_array($chapter->chapter_type, ['shuttle', 'section', 'squad', 'platoon', 'company', 'battalion', 'corps', 'exp_force', 'regiment']) === true)
                            @if($permsObj->hasPermissions(['EDIT_MARDET']) === true)
                                <a href="{!!route('mardet.edit', [$chapter->id])!!}" class="fa fa-pencil green"
                                   title="Edit MARDET"></a>
                            @endif
                            @if($permsObj->hasPermissions(['DELETE_MARDET']) === true)
                                <a href="{!!route('mardet.deactivate', [$chapter->id])!!}"
                                   class="fa fa-x red delete-chapter"
                                   title="Deactivate MARDET"></a>
                            @endif

                        @elseif(in_array($chapter->chapter_type, ['bivouac', 'barracks', 'outpost', 'fort', 'planetary', 'theater']) === true)
                            @if($permsObj->hasPermissions(['EDIT_UNIT']) === true)
                                <a href="{!!route('unit.edit', [$chapter->id])!!}" class="fa fa-pencil green"
                                   title="Edit Command/Unit"></a>
                            @endif
                            @if($permsObj->hasPermissions(['DELETE_UNIT']) === true)
                                <a href="{!!route('unit.deactivate', [$chapter->id])!!}"
                                   class="fa fa-x red delete-chapter"
                                   title="Stand-down Command/Unit"></a>
                            @endif
                        @else
                            @if($permsObj->hasPermissions(['ALL_PERMS']) === true)
                                <a href="{!!route('anyunit.edit', [$chapter->id])!!}" class="fa fa-pencil green"
                                   title="Edit Command/Unit"></a>
                            @endif
                            @if($permsObj->hasPermissions(['ALL_PERMS']) === true)
                                <a href="{!!route('anyunit.deactivate', [$chapter->id])!!}"
                                   class="fa fa-x red delete-chapter"
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
        <a href="{!! route('chapter.create') !!}" class="btn btn-primary btn-lg">Commission Ship</a>
    @endif
@stop
