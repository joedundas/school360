<div class="menu_section">
    {{--<h3>Live On</h3>--}}
    <ul class="nav side-menu">
        <li><a href="dashboard"><i class="fa fa-home"></i>Dashboard
                {{--<span class="fa fa-chevron-down"></span>--}}
            </a>
            <ul class="nav child_menu">
            </ul>
        </li>
        <li><a><i class="fa fa-group"></i>Teachers & Staff<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="customer/list">Directory</a></li>
                <li><a href="customer/list">Add New</a></li>
                <li><a href="customer/list">Uplaod CSV</a></li>
                {{--<li><a href="contacts.html">Contacts</a></li>--}}
                {{--<li><a href="profile.html">Profile</a></li>--}}
            </ul>
        </li>
        <li><a><i class="fa fa-group"></i>Students<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="customer/list">Directory</a></li>
                <li><a href="customer/list">Add New</a></li>
                <li><a href="customer/list">Uplaod CSV</a></li>
                {{--<li><a href="contacts.html">Contacts</a></li>--}}
                {{--<li><a href="profile.html">Profile</a></li>--}}
            </ul>
        </li>
        <li><a><i class="fa fa-calendar"></i>Calendar<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="calendar">General Calendar</a></li>
                <?php
                    if($PAGE->featureFlips->isEnabled('schedule:menu') === 'on') {
                echo "<li><a href='page_404.html'>Menus</a></li>";
                        }
                ?>
                {{--<li><a href="page_500.html">500 Error</a></li>--}}
                {{--<li><a href="plain_page.html">Plain Page</a></li>--}}
                {{--<li><a href="login.html">Login Page</a></li>--}}
                {{--<li><a href="pricing_tables.html">Pricing Tables</a></li>--}}
            </ul>
        </li>
        <li><a><i class="fa fa-bar-chart"></i> Reports <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                {{--<li><a href="tables.html">Tables</a></li>--}}
                {{--<li><a href="tables_dynamic.html">Table Dynamic</a></li>--}}
            </ul>
        </li>
        <li><a><i class="fa fa-briefcase"></i> Administration<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                {{--<li><a href="admin/user/add/parent">Add Parent</a></li>--}}
                {{--<li><a href="admin/user/add/student">Add Students</a></li>--}}
                {{--<li><a href="admin/user/add/teacher">Add Teacher</a></li>--}}
                {{--<li><a href="admin/user/add/staff">Add Staff</a></li>--}}
            </ul>
        </li>

        <li><a><i class="fa fa-comments"></i>Communication<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                {{--<li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>--}}
                {{--<li><a href="fixed_footer.html">Fixed Footer</a></li>--}}
            </ul>
        </li>
        {{--<li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>--}}
            {{--<ul class="nav child_menu">--}}
                {{--<li><a href="#level1_1">Level One</a>--}}
                {{--<li><a>Level One<span class="fa fa-chevron-down"></span></a>--}}
                    {{--<ul class="nav child_menu">--}}
                        {{--<li class="sub_menu"><a href="level2.html">Level Two</a>--}}
                        {{--</li>--}}
                        {{--<li><a href="#level2_1">Level Two</a>--}}
                        {{--</li>--}}
                        {{--<li><a href="#level2_2">Level Two</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li><a href="#level1_2">Level One</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        {{--<li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>--}}

    </ul>
</div>