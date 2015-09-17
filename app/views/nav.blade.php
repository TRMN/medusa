<div id="left-nav">
    @if(Auth::check())
        <div class="nav-header lnav">MEMBER</div>
        <div class="rnav">

            <a href="/home">Service Record</a><br/>
            <a href="{{route('user.change.request', [Auth::user()->id])}}">Branch/Chapter Change</a><br/>
            <a href="{{ route('chapter.index') }}">Ship/Unit List</a><br/>
            <a href="{{route('user.getReset', [Auth::user()->id])}}">Change Password</a><br><br>
            <a href="/signout">Logout</a>

        </div>
        @if($permsObj->hasPermissions(['CREATE_ECHELON',
            'EDIT_ECHELON',
            'DEL_ECHELON',
            'ASSIGN_SHIP',
            'CHANGE_ASSIGNMENT',]) === true)
            <div class="nav-header lnav">First Space Lord</div>
            <div class="rnav">

                @if($permsObj->hasPermissions(['CREATE_ECHELON']) === true)<a
                        href="{{ route('echelon.create') }}">Activate Echelon</a>
                @endif
            </div>
        @endif
        @if($permsObj->hasPermissions(['COMMISSION_SHIP', 'DECOMISSION_SHIP', 'EDIT_SHIP', 'VIEW_DSHIPS']) === true)
            <div class="nav-header lnav">BuShips (3SL)</div>
            <div class="rnav">

                @if($permsObj->hasPermissions(['COMMISSION_SHIP', 'DECOMISSION_SHIP']) === true)<a
                        href="{{ route('chapter.create') }}">Commission Ship</a>@endif
            </div>
        @endif
        @if($permsObj->hasPermissions(['ADD_MEMBER','DEL_MEMBER','EDIT_MEMBER','VIEW_MEMBERS','PROC_APPLICATIONS','PROC_XFERS','ADD_BILLET','DEL_BILLET','EDIT_BILLET',]) === true)
            <div class="nav-header lnav">BuPers (5SL)</div>
            <div class="rnav">
                @if($permsObj->hasPermissions(['VIEW_MEMBERS']) === true)<a href="{{ route('user.index') }}">List
                    Members</a><br/>@endif
                @if($permsObj->hasPermissions(['PROC_APPLICATIONS']) === true)<a href="{{ route('user.review') }}">Approve
                    Applications</a><br/>@endif
                @if($permsObj->hasPermissions(['ADD_MEMBER']) === true)<a href="{{ route('user.create') }}">Add
                    Member</a><br/>@endif
                @if($permsObj->hasPermissions(['PROC_XFERS']) === true)<a href="{{ route('user.change.review') }}">Review
                    Change Requests</a>@endif
            </div>
        @endif
        @if($permsObj->hasPermissions(['ADD_UNIT','EDIT_UNIT','DELETE_UNIT']) === true)
            <div class="nav-header lnav">RMA</div>
            <div class="rnav">
                @if($permsObj->hasPermissions(['ADD_UNIT']) === true)<a
                        href="{{ route('unit.create') }}">Stand-up Command/Unit</a>
                @endif
            </div>
        @endif
    @endif
</div>