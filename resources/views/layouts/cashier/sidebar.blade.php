<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-primary px-3 d-flex align-items-center gap-2">
                <iconify-icon icon="weui:back-filled"></iconify-icon> Back Dashboard
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap ">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Category Product</span>
                </li>
                @foreach ($categories as $category)
                    <li class="sidebar-item">
                        <a class="sidebar-link category-link" href="#" data-category-id="{{ $category->uuid }}"
                            aria-expanded="false">
                            <iconify-icon icon="bx:food-menu"></iconify-icon>
                            <span class="hide-menu">{{ $category->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
