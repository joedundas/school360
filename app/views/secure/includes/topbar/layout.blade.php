<div class="nav_menu">
    <nav>
        @include('secure.includes.topbar.toggle')

        <ul class="nav navbar-nav navbar-right">
            @include('secure.includes.topbar.user')
            @include('secure.includes.topbar.messages')
        </ul>
    </nav>
</div>