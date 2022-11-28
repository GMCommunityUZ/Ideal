{{--Left sidebar--}}
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        @canany([
          'teacher.show'
       ])
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (Request::is('group*')||Request::is('teacher*'))? 'active':''}}">
                    <i class="fas fa-home"></i>
                    <p>
                        Tizim
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (Request::is('group*') ||  Request::is('teacher*')) ? 'block':'none'}};">
                    @can('teacher.show')
                        <li class="nav-item">
                            <a href="{{ route('teacherIndex') }}" class="nav-link {{ Request::is('teacher*') ? "active":'' }}">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>O'qituvchilar</p>
                            </a>
                        </li>
                    @endcan
                    @can('teacher.show')
                        <li class="nav-item">
                            <a href="{{ route('groupIndex') }}" class="nav-link {{ Request::is('group*') ? "active":'' }}">
                                <i class="fas fa-object-group"></i>
                                <p>Guruhlar</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
    </ul>
    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        @canany([
          'teacher.show'
       ])
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (Request::is('amount*'))? 'active':''}}">
                    <i class="fas fa-sort-amount-up"></i>
                    <p>
                        To'lov tizimi
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (Request::is('amount*')) ? 'block':'none'}};">
                    @can('teacher.show')
                        <li class="nav-item">
                            <a href="{{ route('amountIndex') }}" class="nav-link {{ Request::is('amount*') ? "active":'' }}">
                                <i class="fas fa-money-bill-alt"></i>
                                <p>Narxlar</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
    </ul>
    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        @canany([
          'teacher.show',
          'attendance.show'
       ])
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (Request::is('attendance'))? 'active':''}}">
                    <i class="fas fa-calendar-alt"></i>
                    <p>
                        Davomat
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (Request::is('attendance*')) ? 'block':'none'}};">
                    @can('attendance.show')
                        <li class="nav-item">
                            <a href="{{ route('attendanceIndex') }}" class="nav-link {{ Request::is('attendance*') ? "active":'' }}">
                                <i class="fas fa-users"></i>
                                <p>Bor yo'qlama</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
    </ul>
    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        @canany([
          'permission.show',
          'roles.show',
          'user.show'
       ])
            @if(auth()->user()->hasRole('Super Admin'))
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'active':''}}">
                    <i class="fas fa-users-cog"></i>
                    <p>
                        Foydalanuvchi boshqaruvi
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: {{ (Request::is('permission*') || Request::is('role*') || Request::is('user*')) ? 'block':'none'}};">
                    @can('permission.show')
                        <li class="nav-item">
                            <a href="{{ route('permissionIndex') }}" class="nav-link {{ Request::is('permission*') ? "active":'' }}">
                                <i class="fas fa-key"></i>
                                <p> Ruxsatlar</p>
                            </a>
                        </li>
                    @endcan

                    @can('roles.show')
                        <li class="nav-item">
                            <a href="{{ route('roleIndex') }}" class="nav-link {{ Request::is('role*') ? "active":'' }}">
                                <i class="fas fa-user-lock"></i>
                                <p> Rollar</p>
                            </a>
                        </li>
                    @endcan

                    @can('user.show')
                        <li class="nav-item">
                            <a href="{{ route('userIndex') }}" class="nav-link {{ Request::is('user*') ? "active":'' }}">
                                <i class="fas fa-user-friends"></i>
                                <p> Foydalanuvchilar</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endif
        @endcanany
    </ul>

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
            <a href="" class="nav-link">
            <i class="fas fa-palette"></i>
            <p>
                Mavzu
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
            <ul class="nav nav-treeview" style="display: none">
                <li class="nav-item">
                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'default']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-info"></i>
                        <p class="text">Default {{ auth()->user()->theme == 'default' ? '✅':'' }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'light']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-white"></i>
                        <p>Light {{ auth()->user()->theme == 'light' ? '✅':'' }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('userSetTheme',[auth()->id(),'theme' => 'dark']) }}" class="nav-link">
                        <i class="nav-icon fas fa-circle text-gray"></i>
                        <p>Dark {{ auth()->user()->theme == 'dark' ? '✅':'' }}</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
{{--    @can('card.main')--}}

{{--    @endcan--}}
</nav>
