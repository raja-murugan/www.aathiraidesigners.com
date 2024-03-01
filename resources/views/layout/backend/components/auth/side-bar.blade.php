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
                <li class="{{ Route::is('home', 'home.datefilter') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><i class="fe fe-home"></i><span>Dashboard</span></a>
                </li>
            </ul>

            <ul>
                <li class="menu-title"><span>Human Resources</span></li>

                @if(Auth::user()->role == 'Super-Admin')

                <li class="{{ Route::is('department.index') ? 'active' : '' }}">
                    <a href="{{ route('department.index') }}"><i class="fe fe-grid"></i> <span>Department</span></a>
                </li>

                <li class="{{ Route::is('employee.index') ? 'active' : '' }}">
                    <a href="{{ route('employee.index') }}"><i class="fe fe-user"></i> <span>Employee</span></a>
                </li>

                <li class="{{ Route::is('attendance.index', 'attendance.datefilter', 'attendance.departmentwisefilter') ? 'active' : '' }}">
                    <a href="{{ route('attendance.index') }}"><i class="fe fe-user-check"></i> <span>Attendance</span></a>
                </li>

                <li class="{{ Route::is('payoff.index', 'payoff.datefilter', 'payoff.create') ? 'active' : '' }}">
                    <a href="{{ route('payoff.index') }}"><i class="fe fe-package"></i> <span>Payoff</span></a>
                </li>
                @endif

                @if(Auth::user()->role == 'Admin')
                <li class="{{ Route::is('admin_attendance.admin_index', 'admin_attendance.admin_departmentwisefilter') ? 'active' : '' }}">
                    <a href="{{ route('admin_attendance.admin_index') }}"><i class="fe fe-book-open"></i> <span>Attendance</span></a>
                </li>
                @endif

            </ul>
            @if(Auth::user()->role == 'Super-Admin')
            <ul>
                <li class="menu-title"><span>Billing</span></li>

               <li class="{{ Route::is('product.index') ? 'active' : '' }}">
                   <a href="{{ route('product.index') }}"><i class="fe fe-briefcase"></i> <span>Product</span></a>
               </li>

               <li class="{{ Route::is('customer.index', 'customer.create') ? 'active' : '' }}">
                    <a href="{{ route('customer.index') }}"><i class="fe fe-users"></i> <span>Customer</span></a>
                </li>

                <li class="{{ Route::is('billing.index', 'billing.datefilter', 'billing.create') ? 'active' : '' }}">
                    <a href="{{ route('billing.index') }}"><i class="fe fe-clipboard"></i> <span>Billing</span></a>
                </li>


            </ul>

            <ul>
                <li class="menu-title"><span>Income / Expense</span></li>

               <li class="{{ Route::is('income.index') ? 'active' : '' }}">
                   <a href="{{ route('income.index') }}"><i class="fe fe-briefcase"></i> <span>Income</span></a>
               </li>

               <li class="{{ Route::is('expense.index') ? 'active' : '' }}">
                   <a href="{{ route('expense.index') }}"><i class="fe fe-briefcase"></i> <span>Expense</span></a>
               </li>
            </ul>
            @endif




        </div>
    </div>
</div>
