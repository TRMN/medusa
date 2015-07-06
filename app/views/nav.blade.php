<div id="left-nav">
    @if(Auth::check())
        <div class="nav-header lnav">MEMBER</div>
        <div class="rnav">

            <a href="/home">Service Record</a><br />
            <a href="/signout">logout</a>

        </div>

        <div class="nav-header lnav">BuShips (3SL)</div>
        <div class="rnav">
            <a href="{{ route('chapter.index') }}">Ship/Unit List</a><br/>
            <a href="{{{route('chapter.create')}}}">Add Ship/Unit</a>
        </div>

        <div class="nav-header lnav">BuPers (5SL)</div>
        <div class="rnav">
            <a href="{{ route('user.index') }}">List Members</a><br/>
            <a href="{{ route('user.create') }}">Add Member</a>
        </div>

        <div class="nav-header lnav">ADMIRALTY</div>
        <div class="rnav">
            <a href="{{ route('announcement.index') }}">Announcements</a>
        </div>
    @endif
</div>
