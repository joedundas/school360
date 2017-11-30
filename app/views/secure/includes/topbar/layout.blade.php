<div class="nav_menu">
    <nav>
        @include('secure.includes.topbar.toggle')

        <ul class="nav navbar-nav navbar-right">
            @include('secure.includes.topbar.user')
            @if($PAGE->featureFlipEnabled(array('communication')))
            @include('secure.includes.topbar.messages')
                @endif
        </ul>
    </nav>
</div>