<table class="trmnTableWithActions compact row-border">
    <thead>
    <tr>
        <th><span class="fa fa-star red" data-toggle="tooltip" title="New Exams Posted">&nbsp;</span></th>
        <th>Rank</th>
        <th class="text-center">Time in Grade</th>
        <th>Name</th>
        <th>Member ID</th>
        <th>Email</th>
        <th>Unit</th>
        <th class="center">Registration<br/>Date</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($users[$branch]))
        @foreach( $users[$branch] as $user )
            <tr class="zebra-odd">
                <td>@if($user->hasNewExams()) <span class="fa fa-star red" data-toggle="tooltip" title="New Exams Posted">&nbsp;</span> @endif
                </td>
                <td>{!!$user->rank['grade']!!}</td>
                <td>{!!is_null($tig = $user->getTimeInGrade(true))?'N/A':$tig!!}</td>
                <td>{!! $user->last_name !!}
                    , {!! $user->first_name !!}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
                </td>
                <td>{!! $user->member_id !!}</td>
                <td>{!! $user->email_address !!}</td>
                <td>
                    @if($user->getPrimaryAssignmentName() !== false)
                        <a href="/chapter/{!! $user->getPrimaryAssignmentId() !!}">{!! $user->getPrimaryAssignmentName() !!}</a>
                    @else
                        No assignment
                    @endif
                </td>
                <td>{!! $user->registration_date !!}</td>
                <td>
                    <a class="fa fa-user my size-24" href="{!! route('user.show' , [$user->_id]) !!}"
                       data-toggle="tooltip" title="View User"></a>
                    @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                        <a class="tiny fa fa-pencil green size-24"
                           href="{!! route('user.edit', [ $user->_id ]) !!}" data-toggle="tooltip" title="Edit User"></a>
                    @endif
                    @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                        <a class="fa fa-close red size-24" href="{!! route('user.confirmdelete', [ $user->_id]) !!}"
                           data-toggle="tooltip" title="Delete User"></a>
                    @endif
                    @if($permsObj->hasPermissions(['ID_CARD']) === true)
                        <a class="fa fa-credit-card green size-24" href="/id/card/{!!$user->id!!}"
                           data-toggle="tooltip" title="ID Card"></a>
                        <a class="fa fa-check green size-24" href="/id/mark/{!!$user->id!!}"
                           data-toggle="tooltip" title="Mark ID Card as printed"
                           onclick="return confirm('Mark ID card as printed for this memberr?')"></a>
                    @endif
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <th><span class="fa fa-star red" data-toggle="tooltip" title="New Exams Posted">&nbsp;</span></th>
        <th>Rank</th>
        <th class="text-center">Time in Grade</th>
        <th>Name</th>
        <th>Member ID</th>
        <th>Email</th>
        <th>Unit</th>
        <th class="center">Registration<br/>Date</th>
        <th>Actions</th>
    </tr>
    </tfoot>
</table>

