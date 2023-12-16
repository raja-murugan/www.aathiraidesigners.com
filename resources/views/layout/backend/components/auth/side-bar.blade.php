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
                <li class="menu-title"><span>Project</span></li>
                <li class="{{ Route::is('customer.index', 'customer.create', 'customer.store', 'customer.edit' ) ? 'active' : '' }}">
                    <a href="{{ route('customer.index') }}"><i class="fe fe-users"></i> <span>Customer</span></a>
                </li>
                @if(Auth::user()->role == 'Super-Admin')
                <li class="{{ Route::is('employee.index', 'employee.store') ? 'active' : '' }}">
                    <a href="{{ route('employee.index') }}"><i class="fe fe-user"></i> <span>Staff</span></a>
                </li>
                <li class="{{ Route::is('product.index', 'product.store') ? 'active' : '' }}">
                    <a href="{{ route('product.index') }}"><i class="fe fe-package"></i> <span>Product</span></a>
                </li>
                @endif
                <li class="{{ Route::is('billing.index', 'billing.store') ? 'active' : '' }}">
                    <a href="{{ route('billing.index') }}"><i class="fe fe-shopping-cart"></i> <span>Billing</span></a>
                </li>
                <li class="{{ Route::is('followup.index', 'followup.store') ? 'active' : '' }}">
                    <a href="{{ route('followup.index') }}"><i class="fe fe-book-open"></i> <span>Day by Day</span></a>
                </li>
                <li class="{{ Route::is('lead.index', 'lead.store') ? 'active' : '' }}">
                    <a href="{{ route('lead.index') }}"><i class="fe fe-book-open"></i> <span>Leads</span></a>
                </li>
            </ul>





        </div>
    </div>
</div>
