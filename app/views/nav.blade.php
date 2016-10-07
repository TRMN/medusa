<div id="left-nav">
    @if(Auth::check())
        <h3 class="nav-header lnav">MEMBER</h3>
        <div class="rnav">

            <a href="/home">Service Record</a><br/>
            <a href="/id/card/{{Auth::user()->id}}">ID Card</a><br/>
            <a href="{{route('user.change.request', [Auth::user()->id])}}">Branch/Chapter Change</a><br/>
            <a href="{{ route('chapter.index') }}">Ship/Unit List</a><br/>
            <a href="{{route('user.getReset', [Auth::user()->id])}}">Change Password</a>
        </div>
        <h3 class="nav-header lnav">Events</h3>
        <div class="rnav">
            <a href="{{route('events.create')}}">Schedule an Event</a>
            @if (count(Events::where('requestor', '=', Auth::user()->id)->get()))
                <br /><a href="{{route('events.index')}}">View Scheduled Events</a>
            @endif
        </div>
        @if($permsObj->hasPermissions(['DUTY_ROSTER',]) === TRUE)
            <h3 class="nav-header lnav">CO Tools</h3>
            <div class="rnav">
                @if($permsObj->hasPermissions(['CHAPTER_REPORT',]) === TRUE)
                    <a href="{{route('report.index')}}">Chapter Reports</a><br/>
                @endif
            </div>
        @endif
        @if($permsObj->hasPermissions(['CREATE_ECHELON',
            'EDIT_ECHELON',
            'DEL_ECHELON',
            'ASSIGN_SHIP',
            'CHANGE_ASSIGNMENT','TRIAD_REPORT']) === TRUE)
            <h3 class="nav-header lnav">First Space Lord</h3>
            <div class="rnav">

                @if($permsObj->hasPermissions(['CREATE_ECHELON']) === TRUE)
                    <a href="{{ route('echelon.create') }}">Activate Echelon</a><br/>
                @endif
                @if($permsObj->hasPermissions(['TRIAD_REPORT']) == TRUE)
                    <a href="{{route('chapter.triadreport')}}">Command Triad Report</a><br/>
                @endif

            </div>
        @endif
        @if($permsObj->hasPermissions(['COMMISSION_SHIP', 'DECOMISSION_SHIP', 'EDIT_SHIP', 'VIEW_DSHIPS']) === TRUE)
            <h3 class="nav-header lnav">BuShips (3SL)</h3>
            <div class="rnav">

                @if($permsObj->hasPermissions(['COMMISSION_SHIP', 'DECOMISSION_SHIP']) === TRUE)<a
                        href="{{ route('chapter.create') }}">Commission Ship</a>@endif
            </div>
        @endif
        @if($permsObj->hasPermissions(['ADD_MEMBER','DEL_MEMBER','EDIT_MEMBER','VIEW_MEMBERS','PROC_APPLICATIONS','PROC_XFERS','ADD_BILLET','DEL_BILLET','EDIT_BILLET',]) === TRUE)
            <h3 class="nav-header lnav">BuPers (5SL)</h3>
            <div class="rnav">
                @if($permsObj->hasPermissions(['VIEW_MEMBERS']) === TRUE)<a href="{{ route('user.index') }}">List
                    Members</a><br/>
                <a href="{{route('user.find')}}">Find a Member</a><br/>
                <a href="{{route('user.dups', 'CO')}}">Show COs</a><br/>
                <a href="{{route('user.dups', 'XO')}}">Show XOs</a><br/>
                <a href="{{route('user.dups', 'BOSUN')}}">Show Bosuns</a><br/>
                @endif
                @if($permsObj->hasPermissions(['PROC_APPLICATIONS']) === TRUE)<a href="{{ route('user.review') }}">Approve
                    Applications</a><br/>@endif
                @if($permsObj->hasPermissions(['ADD_MEMBER']) === TRUE)<a href="{{ route('user.create') }}">Add
                    Member</a><br/>@endif
                @if($permsObj->hasPermissions(['PROC_XFERS']) === TRUE)<a href="{{ route('user.change.review') }}">Review
                    Change Requests</a><br/>@endif
                @if($permsObj->hasPermissions(['ADD_BILLET']) === TRUE) <a href="{{ route('billet.create') }}">Add
                    Billet</a><br/> @endif
                @if($permsObj->hasPermissions(['DEL_BILLET','EDIT_BILLET']) === TRUE) <a
                        href="{{ route('billet.index') }}">Billet List</a><br/> @endif
            </div>
        @endif

        @if($permsObj->hasPermissions(['UPLOAD_EXAMS','ADD_GRADE', 'EDIT_GRADE']) === TRUE)
            <h3 class="nav-header lnav">BuTrain (6SL)</h3>
            <div class="rnav">
                @if($permsObj->hasPermissions(['UPLOAD_EXAMS']) === TRUE)
                    <a href="{{route('exam.index')}}">Upload Exams</a><br/>
                @endif
                @if($permsObj->hasPermissions(['EDIT_GRADE']) === TRUE)
                    <a href="{{route('exam.list')}}">Master Exam List</a><br/>
                    <a href="{{route('exam.create')}}">Add Exam</a><br/>
                    <a href="{{route('user.find')}}">Find a Member</a><br/>
                @endif
                @if($permsObj->hasPermissions(['ADD_GRADE', 'EDIT_GRADE']) === TRUE)
                    <a href="{{route('exam.find')}}">Manage/Enter Grades</a>
                @endif
            </div>
        @endif

        @if($permsObj->hasPermissions(['ADD_MARDET','EDIT_MARDET','DELETE_MARDET', 'VIEW_RMMC']) === TRUE)
            <h3 class="nav-header lnav">RMMC</h3>
            <div class="rnav">
                @if($permsObj->hasPermissions(['ADD_MARDET']) === TRUE)
                    <a href="{{ route('mardet.create') }}">Stand-up MARDET</a><br/>
                @endif
                @if($permsObj->hasPermissions(['VIEW_RMMC']) === TRUE)
                    <a href="{{route('showBranch', ['branch' => 'RMMC'])}}">Show RMMC members</a><br/>
                @endif
            </div>
        @endif


        @if($permsObj->hasPermissions(['ADD_UNIT','EDIT_UNIT','DELETE_UNIT', 'VIEW_RMA']) === TRUE)
            <h3 class="nav-header lnav">RMA</h3>
            <div class="rnav">
                @if($permsObj->hasPermissions(['ADD_UNIT']) === TRUE)<a
                        href="{{ route('unit.create') }}">Stand-up Command/Unit</a><br/>
                @endif
                @if($permsObj->hasPermissions(['VIEW_RMA']) === TRUE)
                    <a href="{{route('showBranch', ['branch' => 'RMA'])}}">Show RMA members</a><br/>
                @endif
            </div>
        @endif

        @if($permsObj->hasPermissions(['VIEW_GSN']) === TRUE)
            <h3 class="nav-header lnav">GSN</h3>
            <div class="rnav">
                @if($permsObj->hasPermissions(['VIEW_GSN']) === TRUE)
                    <a href="{{route('showBranch', ['branch' => 'GSN'])}}">Show GSN members</a><br/>
                @endif
            </div>
        @endif

        @if($permsObj->hasPermissions(['VIEW_RHN']) === TRUE)
            <h3 class="nav-header lnav">RHN</h3>
            <div class="rnav">
                @if($permsObj->hasPermissions(['VIEW_RHN']) === TRUE)
                    <a href="{{route('showBranch', ['branch' => 'RHN'])}}">Show RHN members</a><br/>
                @endif
            </div>
        @endif

        @if($permsObj->hasPermissions(['VIEW_IAN']) === TRUE)
            <h3 class="nav-header lnav">IAN</h3>
            <div class="rnav">
                @if($permsObj->hasPermissions(['VIEW_IAN']) === TRUE)
                    <a href="{{route('showBranch', ['branch' => 'IAN'])}}">Show IAN members</a><br/>
                @endif
            </div>
        @endif


        @if($permsObj->hasPermissions(['ALL_PERMS']) === TRUE)
            <h3 class="nav-header lnav">System</h3>
            <div class="rnav">
                <a href="{{ route('anyunit.create') }}">Create Unit/Echelon</a><br/>
                <a href="{{ route('type.index') }}">List Chapter Types</a><br/>
                <a href="{{ route('type.create') }}">Add Chapter Type</a><br/>
                <a href="{{ route('oauthclient.index') }}">List OAuth Clients</a><br/>
                <a href="{{ route('oauthclient.create') }}">Add OAuth Client</a>
            </div>
        @endif
    @endif
</div>

<a href="/signout"><h3 class="lnav nav-header whitesmoke">Logout</h3></a>

