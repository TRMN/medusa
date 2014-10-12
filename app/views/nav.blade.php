<nav class="top-bar" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name">
            <h1><a href="{{ $serverUrl }}/">TRMN Database</a></h1>
        <li>
    </ul>
    <section class="top-bar-section">
        @if(Auth::check())
        <ul class="left">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="{{ route('user.index') }}">Users</a></li>
            <li><a href="{{ route('chapter.index') }}">Chapters</a></li>
        </ul>
        <ul class="right">
            <li><a href="/signout">logout</a></li>
        </ul>
        @endif
    </section>
</nav>