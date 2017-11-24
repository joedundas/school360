<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    @include('secure.includes.sidebar.general-menu')

    @if($SESSION['user']['meta']['userType'] == 'staff')
        @include('secure.includes.sidebar.menus.staff-menu')
    @endif

    @if($SESSION['user']['meta']['userType'] == 'teacher')
        @include('secure.includes.sidebar.menus.teacher-menu')
    @endif

    @if($SESSION['user']['meta']['userType'] == 'student')
        @include('secure.includes.sidebar.menus.student-menu')
    @endif

    @if($SESSION['user']['meta']['userType'] == 'parent')
        @include('secure.includes.sidebar.menus.parent-menu')
    @endif



    @include('secure.includes.sidebar.footer-menu')
</div>