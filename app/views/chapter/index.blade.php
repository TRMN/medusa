@extends('layout')

@section('pageTitle')
Chapters
@stop

@section('content')
    <h1>Chapter List</h1>
    <table id="chapterList" class="compact row-border stripe" width="75%">
        <thead>
            <tr>
                <th>Chapter Name</th>
                <th>Chapter Type</th>
                <th width="12%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $chapters as $chapter )
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
                               alt="Reserve Fleet / Decomissioned"></i>
                        @endif</td>
                    <td>{{ ucfirst($chapter->chapter_type) }}</td>
                    <td width="12%">
                        @if($permsObj->hasPermissions(['EDIT_SHIP']) === true)
                            <a href="{{route('chapter.edit', [$chapter->id])}}" class="fi-list green" title="Edit Chapter"></a>
                        @endif
                        @if($permsObj->hasPermissions(['DECOMMISSION_SHIP']) === true)
                            <a href="#" data-mongoid="{{$chapter->_id}}" class="fi-x red delete-chapter" title="Delete Chapter"></a>
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
        <a href="{{ route('chapter.create') }}" class="button">Create New Chapter</a>
    @endif
@stop
