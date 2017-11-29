<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    @include('secure.includes.sidebar.general-menu')
    <div class="menu_section">

        <ul class="nav side-menu">

        {{--@include('secure.includes.sidebar.menus.dashboard')--}}

            {{--@include('secure.includes.sidebar.menus.students')--}}


        </ul>
    </div>
    @include('secure.includes.sidebar.menus.staff-menu')
    {{--@if($SESSION)--}}

        {{--@endif--}}

    {{--@if($SESSION['user']['meta']['userType'] == 'teacher')--}}
        {{--@include('secure.includes.sidebar.menus.teacher-menu')--}}
    {{--@endif--}}

    {{--@if($SESSION['user']['meta']['userType'] == 'student')--}}
        {{--@include('secure.includes.sidebar.menus.student-menu')--}}
    {{--@endif--}}

    {{--@if($SESSION['user']['meta']['userType'] == 'parent')--}}
        {{--@include('secure.includes.sidebar.menus.parent-menu')--}}
    {{--@endif--}}



    {{--@include('secure.includes.sidebar.footer-menu')--}}
</div>