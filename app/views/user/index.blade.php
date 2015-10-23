@extends('layout')

@section('pageTitle')
    {{ $title }}
@stop

@section('content')
    <div><h3 class="trmn">{{ $title }}</h3></div>
    <div id="members">
        <ul>
            <li><a href="#members-1">RMN</a></li>
            <li><a href="#members-2">RMMC</a></li>
            <li><a href="#members-3">RMA</a></li>
            <li><a href="#members-4">GSN</a></li>
            <li><a href="#members-5">RHN</a></li>
            <li><a href="#members-6">IAN</a></li>
            <li><a href="#members-7">SFS</a></li>
            <li><a href="#members-8">Civilian</a></li>
            <li><a href="#members-9">Intelligence</a></li>
            <li><a href="#inactive">Inactive</a></li>
            @if($permsObj->hasPermissions('ALL_PERMS') === true)
                <li><a href="#suspended">Suspended</a></li>
                <li><a href="#expelled">Expelled</a></li>
            @endif
        </ul>

        <div id="members-1">
            <table id="memberList-1" class="compact row-border">
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
                @if(isset($users['RMN']))
                    @foreach( $users['RMN'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}
                                {{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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
        </div>

        <div id="inactive">
            <table id="inactiveList" class="compact row-border">
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
                @if(isset($otherThanActive['Inactive']))
                    @foreach( $otherThanActive['Inactive'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}
                                {{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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
        </div>

        @if($permsObj->hasPermissions('ALL_PERMS') === true)
            <div id="suspended">
                <table id="suspendedList" class="compact row-border">
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
                    @if(isset($otherThanActive['Suspended']))
                        @foreach( $otherThanActive['Suspended'] as $user )
                            <tr>
                                <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}
                                    {{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                                <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                                <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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
            </div>

            <div id="expelled">
                <table id="expelledList" class="compact row-border">
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
                    @if(isset($otherThanActive['Expelled']))
                        @foreach( $otherThanActive['Expelled'] as $user )
                            <tr>
                                <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}
                                    {{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                                <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                                <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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
            </div>
        @endif

        <div id="members-9">

            <table id="memberList-9" class="compact row-border">
                <thead>
                <tr>
                    <th width="30%">Name</th>
                    <th width="10%">Member ID</th>
                    <th width="15%">Email</th>
                    <th width="10%">Unit</th>
                    <th width="10%" class="center">Registration<br />Date</th>
                    <th width="9%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($users['INTEL']))
                    @foreach( $users['INTEL'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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

        </div>
        <div id="members-8">

            <table id="memberList-8" class="compact row-border">
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
                @if(isset($users['CIVIL']))
                    @foreach( $users['CIVIL'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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

        </div>
        <div id="members-7">
            <table id="memberList-7" class="compact row-border">
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
                @if(isset($users['SFS']))
                    @foreach( $users['SFS'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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

        </div>
        <div id="members-6">
            <table id="memberList-6" class="compact row-border">
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
                @if(isset($users['IAN']))
                    @foreach( $users['IAN'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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

        </div>
        <div id="members-5">
            <table id="memberList-5" class="compact row-border">
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
                @if(isset($users['RHN']))
                    @foreach( $users['RHN'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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

        </div>
        <div id="members-4">
            <table id="memberList-4" class="compact row-border">
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
                @if(isset($users['GSN']))
                    @foreach( $users['GSN'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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

        </div>
        <div id="members-3">
            <table id="memberList-3" class="compact row-border">
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
                @if(isset($users['RMA']))
                    @foreach( $users['RMA'] as $user )
                        <tr>
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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

        </div>
        <div id="members-2">
            <table id="memberList-2" class="compact row-border">
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
                            <td width="30%">{{ $user->last_name }}, {{ $user->first_name }}{{ isset($user->middle_name) ? ' ' . $user->middle_name : '' }}
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
                            <td width="10%">{{ date('Y-m-d', strtotime($user->registration_date)) }}</td>
                            <td width="9%">
                                @if($permsObj->hasPermissions(['EDIT_MEMBER']) === true)
                                    <a class="fi-torso my size-24" href="{{ route('user.show' , [$user->_id]) }}" title="View User"></a>
                                    <a class="tiny fi-pencil green size-24" href="{{ route('user.edit', [ $user->_id ]) }}" title="Edit User"></a>
                                @endif
                                @if($permsObj->hasPermissions(['DEL_MEMBER']) === true)
                                    <a class="fi-x red size-24" href="{{ route('user.confirmdelete', [ $user->_id]) }}" title="Delete User"></a>
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

        </div>

    </div>
@stop
