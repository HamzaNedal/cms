   @php
       $current_page = Route::currentRouteName();
   @endphp
   <!-- Sidebar -->
     <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        {{-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a> --}}

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        @foreach ($admin_side_menu as $menu)
            @if(count($menu->appeardChildren) == 0)
            <li class="nav-item {{ $menu->id == getParentShowOf($current_page) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.'.$menu->as) }}">
                    <i class="{{ $menu->icon != null ? $menu->icon : 'fa fa-home' }}"></i>
                    <span>{{ $menu->display_name }}</span></a>
            </li>
            <hr class="sidebar-divider my-0">
            @else
            <li class="nav-item {{ in_array($menu->parent_show,[getParentShowOf($current_page),getParentOf($current_page)]) ? 'active' : '' }}">
                <a class="nav-link {{ in_array($menu->parent_show,[getParentShowOf($current_page),getParentOf($current_page)]) ? 'collapsed' : '' }}" 
                    href="#" 
                    data-toggle="collapse" 
                    data-target="#collapse_{{ $menu->route }}"
                    aria-expanded="{{ $menu->parent_show == getParentOf($current_page) && getParentOf($current_page) != null ? 'false' : 'true' }}" 
                    aria-controls="collapse_{{ $menu->route }}">
                    <i class="{{ $menu->icon != null ? $menu->icon : 'fa fa-home' }}"></i>
                    <span>{{ $menu->display_name }}</span>
                </a>
               
                @if (isset($menu->appeardChildren) && count($menu->appeardChildren) > 0)
                <div id="collapse_{{ $menu->route }}" class="collapse {{  in_array($menu->parent_show,[getParentShowOf($current_page),getParentOf($current_page)]) ? 'show' : ''  }}" 
                    aria-labelledby="heading_{{ $menu->route }}" 
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                       @foreach ( $menu->appeardChildren as $sub_menu)
                          <a class="collapse-item {{ (int) (getParentOf($current_page))+1 ? 'active' : '' }}" href="{{ route('admin.'.$sub_menu->as) }}">{{ $sub_menu->display_name }}</a>
                       @endforeach
                    </div>
                </div>
                @endif
               
            </li>
            @endif
        @endforeach
      

        {{-- <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Interface
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Components</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="buttons.html">Buttons</a>
                    <a class="collapse-item" href="cards.html">Cards</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Utilities</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Utilities:</h6>
                    <a class="collapse-item" href="utilities-color.html">Colors</a>
                    <a class="collapse-item" href="utilities-border.html">Borders</a>
                    <a class="collapse-item" href="utilities-animation.html">Animations</a>
                    <a class="collapse-item" href="utilities-other.html">Other</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.html">Login</a>
                    <a class="collapse-item" href="register.html">Register</a>
                    <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Other Pages:</h6>
                    <a class="collapse-item" href="404.html">404 Page</a>
                    <a class="collapse-item" href="blank.html">Blank Page</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div> --}}

        <!-- Sidebar Message -->
        {{-- <div class="sidebar-card">
            <img class="sidebar-card-illustration mb-2" src="{{ asset('backend') }}/img/undraw_rocket.svg" alt="">
            <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
            <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
        </div> --}}

    </ul>
    <!-- End of Sidebar -->