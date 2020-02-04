<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container-fuild">
            <div class="navbar-header">
                <a href="/" class="navbar-brand"><b>T</b>-Coffee</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    @can('view-category')
                        <li>
                            <a href="{{ route('category') }}">
                                <i class="fa fa-newspaper-o"></i>
                                Danh mục
                            </a>
                        </li>
                    @endcan
                    @can('view-product')
                        <li>
                            <a href="{{ route('product') }}">
                                <i class="fa fa-cubes"></i>
                                Sản phẩm
                            </a>
                        </li>
                    @endcan
                    @can('view-table')
                        <li>
                            <a href="{{ route('table') }}">
                                <i class="fa fa-table"></i>
                                Bàn
                            </a>
                        </li>
                    @endcan
                    @can('view-order')
                        <li>
                            <a href="{{ route('order') }}">
                                <i class="fa fa-bookmark-o"></i>
                                Order
                            </a>
                        </li>
                    @endcan
                    @can('view-bill')
                        <li>
                            <a href="{{ route('bill') }}">
                                <i class="fa fa-money"></i>
                                Hóa đơn
                            </a>
                        </li>
                    @endcan
                    @can('view-user')
                        <li>
                            <a href="{{ route('user') }}">
                                <i class="fa fa-users"></i>
                                User
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
            <!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="upload/images/users/{{ Auth::user()->avatar}}" class="user-image"
                                 alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->full_name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="upload/images/users/{{ Auth::user()->avatar}}" class="img-circle"
                                     alt="User Image">

                                <p>
                                    {{ Auth::user()->full_name }}
                                    <small>{{ Auth::user()->role->name }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-custom-menu -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
