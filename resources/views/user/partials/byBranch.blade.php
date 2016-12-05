<table class="trmnTableWithActions compact row-border">
    <thead>
    <tr>
        <th><span class="fi-star red" title="New Exams Posted">&nbsp;</span></th>
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
                <td>@if($user->hasNewExams()) <span class="fi-star red" title="New Exams Posted">&nbsp;</span> @endif
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
                    <a class="fi-torso my size-24" href="{!! route('user.show' , [$user->_id]) !!}"
                       title="View User"></a>
                    @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                        <a class="tiny fi-pencil green size-24"
                           href="{!! route('user.edit', [ $user->_id ]) !!}" title="Edit User"></a>
                    @endif
                    @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                        <a class="fi-x red size-24" href="{!! route('user.confirmdelete', [ $user->_id]) !!}"
                           title="Delete User"></a>
                    @endif
                    @if($permsObj->hasPermissions(['ID_CARD']) === true)
                        <a class="fi-credit-card green size-24" href="/id/card/{!!$user->id!!}"
                           title="ID Card"></a>
                        <a class="fi-check green size-24" href="/id/mark/{!!$user->id!!}"
                           title="Mark ID Card as printed"
                           onclick="return confirm('Mark ID card as printed for this memberr?')"></a>
                    @endif
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <th><span class="fi-star red" title="New Exams Posted">&nbsp;</span></th>
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

