<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="javascript::void(o);">
                <img src="{{ asset('assets/backend/img/logo.png') }}" class="img-fluid logo" alt="">
            </a>
            <a href="javascript::void(o);">
                <img src="{{ asset('assets/backend/img/logo-small.png') }}" class="img-fluid logo-small" alt="">
            </a>
        </div>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul>
                <li class="menu-title"><span>Main</span></li>
                <li class="{{ Route::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><i class="fe fe-home"></i><span>Dashboard</span></a>
                </li>
            </ul>

            <ul>
                <li class="menu-title"><span>Side Menu</span></li>
                <li class="{{ Route::is('employee.index') ? 'active' : '' }}">
                    <a href="{{ route('employee.index') }}"><i class="fe fe-users"></i> <span>Employee</span></a>
                </li>
                @if(Auth::user()->role == 'Super-Admin')
                <li class="{{ Route::is('attendance.index') ? 'active' : '' }}">
                    <a href="{{ route('attendance.index') }}"><i class="fe fe-book-open"></i> <span>Attendance</span></a>
                </li>
                @endif

                @if(Auth::user()->role == 'Admin')
                <li class="{{ Route::is('admin_attendance.admin_index') ? 'active' : '' }}">
                    <a href="{{ route('admin_attendance.admin_index') }}"><i class="fe fe-book-open"></i> <span>Attendance</span></a>
                </li>
                @endif

            </ul>





        </div>
    </div>
</div>
