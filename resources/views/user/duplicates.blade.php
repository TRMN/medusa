@extends('layout')

@section('pageTitle')
    {!! $title !!}
@stop

@section('content')
    <div><h3 class="trmn">{!! $title !!}</h3></div>

    <div id="duplicate">
        <table id="duplicates" class="compact row-border">
            <thead>
            <tr>
                <th>Name</th>
                <th>Member ID</th>
                <th>Primary Unit</th>
                <th>Secondary Unit</th>
                <th>Additional Unit</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $users as $user )
                <tr>
                    <td>{!! $user->last_name !!}, {!! $user->first_name !!}
                        {!! isset($user->middle_name) ? ' ' . $user->middle_name : '' !!}
                    </td>
                    <td>{!! $user->member_id !!}</td>
                    <td>{!! $user->getAssignmentName('primary') !!} <br /> <em>{!!$user->getBillet('primary')!!}</em></td>
                    <td>
                        @if(empty($user->getAssignmentName('secondary')) === false)
                            {!! $user->getAssignmentName('secondary') !!}  <br /> <em>{!!$user->getBillet('secondary')!!}</em>
                        @else
                            No assignment
                        @endif
                    </td>
                    <td>
                        @if(empty($user->getAssignmentName('additional')) === false)
                            {!! $user->getAssignmentName('additional') !!}  <br /> <em>{!!$user->getBillet('additional')!!}</em>
                        @else
                            No assignment
                        @endif
                    </td>
                    <td>
                        @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                            <a class="fi-torso my size-24" href="{!! route('user.show' , [$user->_id]) !!}"
                               title="View User"></a>
                            <a class="tiny fi-pencil green size-24" href="{!! route('user.edit', [ $user->_id ]) !!}"
                               title="Edit User"></a>
                        @endif
                    </td>
                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th>Name</th>
                <th>Member ID</th>
                <th>Primary Unit</th>
                <th>Secondary Unit</th>
                <th>Additional Unit</th>
                <th>Actions</th>
            </tr>
            </tfoot>
        </table>
    </div>


    </div>
@stop