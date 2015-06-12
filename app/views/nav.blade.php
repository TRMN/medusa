<div id="left-nav">
    @if(Auth::check())
        <div class="button lnav">MEMBER</div>
        <div class="rnav">

            <a href="/dashboard">Dashboard</a><br />
            <a href="/signout">logout</a>

        </div>

        <div class="button lnav">BuPers (5SL)</div>
        <div class="rnav">
            <a href="{{ route('user.index') }}">Users</a>
        </div>

        <div class="button lnav">CHAPTERS</div>
        <div class="rnav">
            <a href="{{ route('chapter.index') }}">Chapter List</a>
        </div>

        <div class="button lnav">ADMIRALTY</div>
        <div class="rnav">
            <a href="{{ route('announcement.index') }}">Announcements</a>
        </div>
    @endif
</div>
