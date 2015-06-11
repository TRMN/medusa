<nav>
    @if(Auth::check())
    <ul class="left">
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="{{ route('user.index') }}">Users</a></li>
        <li><a href="{{ route('chapter.index') }}">Chapters</a></li>
        <li><a href="{{ route('announcement.index') }}">Announcements</a></li>
    </ul>
    <ul class="right">
        <li><a href="/signout">logout</a></li>
    </ul>
    @endif
</nav>
