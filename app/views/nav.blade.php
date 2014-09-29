<nav class="top-bar" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name">
            <h1><a href="{{ $serverUrl }}/">TRMN Database</a></h1>
        <li>
    </ul>
    <section class="top-bar-section">
        @if (Auth::check())
            <ul class="left">
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="{{ route('user.index') }}">Users</a></li>
                <li><a href="{{ route('ship.index') }}">Ships</a></li>
            </ul>
            <ul class="right">
                <li>Signed in as <a href="{{ route('user.edit', $authUser->id) }}">{{{ $authUser->first_name }}} {{{ $authUser->last_name }}}</a>. <a href="/signout">logout</a></li>
            </ul>
        @else
            <ul class="right">
                <li class="has-form">
                    <div class="row collapse">
                        <div class="large-4 columns">
                            <input id="email" name="email" placeholder="email" type="email">
                        </div>
                        <div class="large-4 columns">
                            <input id="password" name="password" type="password" placeholder="password">
                        </div>
                        <div class="large-4 columns">
                            <a href="#" id="signin-btn" class="button expand">Sign in</a>
                        </div>
                    </div>
                </li>
            </ul>
        @endif
    </section>
</nav>