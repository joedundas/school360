<li class="">
    <a href="javascript" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <img src="images/img.jpg" alt="">
        {{$PAGE->user->name()->format('%F %L')}}
        <span class=" fa fa-angle-down"></span>
    </a>
    <ul class="dropdown-menu dropdown-usermenu pull-right">
        <li><a href="javascript:"> Profile</a></li>
        <li>
            <a href="javascript">
                <span class="badge bg-red pull-right">50%</span>
                <span>Settings</span>
            </a>
        </li>
        <li><a href="javascript">Help</a></li>
        @if($PAGE->user->roles()->count() > 1)
            <li>
                <a onclick="controller.page.modal.create({'view':'modal/roles-list'})">
                    <span class="badge bg-red pull-right">{{ $PAGE->user->roles()->count() }}</span>
                    <span>Switch Account/Role</span>
                </a>
            </li>
            @endif
        <li>
            <a onclick="controller.session.refresh()">
                <span class="badge bg-red pull-right">50%</span>
                <span>Refresh/Reload Cache</span>
            </a>
        </li>
        <li><a href="doLogout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
    </ul>
</li>