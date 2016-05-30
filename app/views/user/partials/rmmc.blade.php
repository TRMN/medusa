            <table class="trmnTableWithActions compact row-border">
                <thead>
                <tr>
                    <th width="30%">Name</th>
                    <th width="10%">Member ID</th>
                    <th width="15%">Email</th>
                    <th width="10%">Unit</th>
                    <th width="10%" class="center">Registration<br/>Date</th>
                    <th width="9%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($users['RMMC']))
                    @foreach( $users['RMMC'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}
                                , {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
                            </td>
                            <td width="10%">{{ $user->member_id }}</td>
                            <td width="15%">{{ $user->email_address }}</td>
                            <td width="10%">
                                @if($user->getPrimaryAssignmentName() !== false)
                                    <a href="/chapter/{{ $user->getPrimaryAssignmentId() }}">{{ $user->getPrimaryAssignmentName() }}</a>
                                @else
                                    No assignment
                                @endif
                            </td>
                            <td width="10%">{{ $user->registration_date }}</td>
                            <td width="9%">
                                <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}"
                                   title="View User"></a>
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="tiny fi-pencil green size-24"
                                       href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}"
                                       title="Delete User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['ID_CARD']) === true)
                                    <a class="fi-credit-card green size-24" href="/id/card/{{$user->id}}"
                                       title="ID Card"></a>
                                    <a class="fi-check green size-24" href="/id/mark/{{$user->id}}"
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
                    <th width="30%">Name</th>
                    <th width="10%">Member ID</th>
                    <th width="15%">Email</th>
                    <th width="10%">Unit</th>
                    <th width="10%" class="center">Registration<br/>Date</th>
                    <th width="9%">Actions</th>
                </tr>
                </tfoot>
            </table>

