<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">TRMN Database</a>
        </div>
        @if ($authUser)
            <ul class="nav navbar-nav">
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="{{ route('user.index') }}">Users</a></li>
            </ul>
            <div id="user-info">
                <p class="navbar-text navbar-right">Signed in as <a href="{{ route('user.edit', $authUser->id) }}">{{{ $authUser->first_name }}} {{{ $authUser->last_name }}}</a>. <a href="/signout">logout</a></p>
            </div>
        @endif
        @unless(Auth::check())
            <div id="signin-form">
                @include('loginForm')
            </div>
        @endunless
    </div>
</nav>