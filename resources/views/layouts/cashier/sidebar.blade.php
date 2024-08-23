<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-primary px-3 d-flex align-items-center gap-2">
                <iconify-icon icon="weui:back-filled"></iconify-icon> Back Dashboard
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap ">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Category Product</span>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('transaction.index') }}"
                        class="sidebar-link {{ Request::is('cashier/index') && !Request::is('cashier/index*') ? 'active' : '' }}"
                        href="{{ route('category.index') }}" aria-expanded="false">
                        <iconify-icon icon="bx:food-menu"></iconify-icon>
                        <span class="hide-menu">All Product</span>
                    </a>
                </li>
                @foreach ($categories as $category)
                    <li class="sidebar-item">
                        <form action="{{ route('transaction.index') }}" method="GET">
                            <input type="hidden" name="category_id" value="{{ $category->uuid }}">
                            <button type="submit"
                                class="sidebar-link btn btn-block {{ request('category_id') == $category->uuid ? 'active bg-primary text-white w-100' : '' }}">
                                <iconify-icon icon="bx:food-menu"
                                    class="{{ request('category_id') == $category->uuid ? 'text-white' : '' }}"></iconify-icon>
                                <span class="hide-menu">{{ $category->name }}</span>
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
