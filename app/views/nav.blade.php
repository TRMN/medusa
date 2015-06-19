<div id="left-nav">
    @if(Auth::check())
        <div class="nav-header lnav">MEMBER</div>
        <div class="rnav">

            <a href="/home">Service Record</a><br />
            <a href="/signout">logout</a>

        </div>

        <div class="nav-header lnav">BuPers (5SL)</div>
        <div class="rnav">
            <a href="{{ route('user.index') }}">Users</a><br/>
            <a href="{{ route('user.create') }}">Add User</a>
        </div>

        <div class="nav-header lnav">CHAPTERS</div>
        <div class="rnav">
            <a href="{{ route('chapter.index') }}">Chapter List</a>
        </div>

        <div class="nav-header lnav">ADMIRALTY</div>
        <div class="rnav">
            <a href="{{ route('announcement.index') }}">Announcements</a>
        </div>
    @endif
</div>
