<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="h3 fw-bold text-nowrap logo-img">
                <iconify-icon icon="weui:shop-filled"></iconify-icon> Point Of Sales
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}"
                        aria-expanded="false">
                        <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">User Management</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('role/***') ? 'active' : '' }}"
                        href="{{ route('role.index') }}" aria-expanded="false">
                        <iconify-icon icon="oui:app-users-roles"></iconify-icon>
                        <span class="hide-menu">Roles</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('permission/***') ? 'active' : '' }}"
                        href="{{ route('permission.index') }}" aria-expanded="false">
                        <iconify-icon icon="fluent-mdl2:permissions"></iconify-icon>
                        <span class="hide-menu">Permission</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('user/***') ? 'active' : '' }}"
                        href="{{ route('user.index') }}" aria-expanded="false">
                        <iconify-icon icon="fa6-solid:user-gear"></iconify-icon>
                        <span class="hide-menu">All Users</span>
                    </a>
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Master Data</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('category/***') ? 'active' : '' }}"
                        href="{{ route('category.index') }}" aria-expanded="false">
                        <iconify-icon icon="carbon:collapse-categories"></iconify-icon>
                        <span class="hide-menu">All Category</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('product*') && !Request::is('product/stock*') ? 'active' : '' }}"
                        href="{{ route('product.index') }}" aria-expanded="false">
                        <iconify-icon icon="fluent-mdl2:product-list"></iconify-icon>
                        <span class="hide-menu">All Product</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('product/stock*') ? 'active' : '' }}"
                        href="{{ route('product.stock') }}" aria-expanded="false">
                        <iconify-icon icon="hugeicons:package-out-of-stock"></iconify-icon>
                        <span class="hide-menu">Stock Information</span>
                    </a>
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Cashier</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('cashier/***') ? 'active' : '' }}"
                        href="{{ route('transaction.index') }}" aria-expanded="false">
                        <iconify-icon icon="material-symbols:point-of-sale"></iconify-icon>
                        <span class="hide-menu">Transactions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                        <iconify-icon icon="fa6-solid:rupiah-sign"></iconify-icon>
                        <span class="hide-menu">All Transactions</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
