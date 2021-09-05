<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('user.dashboard') }}" class="brand-link">
        <img src="{{ asset('default/fashol.png') }}" alt="fashol.com" class="brand-image" style="">
        <span class="brand-text font-weight-light text-light"
            style="font-size: 15px ; line-height: 15px ; font-weight: 700 !important; ">
            LTD. </span>
    </a>

    <!-- Sidebar -->
    <div class=" sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ auth()->user()->image === 'default.png' || auth()->user()->image === null ? asset('dist/img/user2-160x160.jpg') : asset('storage/images/' . auth()->user()->image) }}"
                    class="img-circle elevation-2" alt="{{ auth()->user()->name . '_' . auth()->user()->image }}">
            </div>
            <div class="info">
                <a href="{{ route('user.show', auth()->user()->id) }}" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="{{ route('user.dashboard') }}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- This menu for multiple linking system --}}
                @role('root_smg_manager')
                @include('layouts.partials._root_smg_sitebar')
                @endrole
                {{-- Product menus --}}

                <li class="nav-item">
                    @role('super_admin|admin|smg_manager|sales_executive')
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-cart-arrow-down"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    @endrole
                    <ul class="nav nav-treeview">
                        @role('super_admin|admin|smg_manager|sales_executive')
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category </p>
                            </a>
                        </li>
                        @endrole
                        @role('super_admin|admin|smg_manager|sales_executive')
                        <li class="nav-item">
                            <a href="{{ route('product.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Products </p>
                            </a>
                        </li>
                        @endrole
                        @role('super_admin|admin|smg_manager|sales_executive')
                        <li class="nav-item">
                            <a href="{{ route('product.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Product</p>
                            </a>
                        </li>
                        @endrole


                    </ul>
                </li>
                {{-- End Product menus --}}
                {{-- Price menus --}}
                @role('super_admin|admin|smg_manager')
                <li class="nav-item">
                    <a href="{{ route('price.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            Pricing
                        </p>
                    </a>
                </li>
                @endrole
                {{-- Price menus End --}}
                {{-- Order menus For Smg_manager Start --}}
                @role('smg_manager')
                <li class="nav-item">
                    <a href="{{ route('smg.order.pending') }}" class="nav-link">
                        <i class="nav-icon fas fa-sort-amount-down-alt"></i>
                        <p>
                            Today's Orders
                            <incommingorder></incommingorder>
                        </p>
                    </a>
                </li>
                @endrole
                {{-- Order menus For Smg_manager End --}}


                {{-- Zone Menu --}}
                @role('super_admin|admin')
                <li class="nav-item">
                    <a href="{{ route('zone.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>
                            Our Zones
                        </p>
                    </a>
                </li>
                @endrole

                {{-- End Zone Menu --}}

                {{-- Packaging's Start --}}
                @role('super_admin|admin|smg_manager')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>
                            Packaging
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('packaging.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Packaging Dashboard</p>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a href="{{ route('chalan.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Delivery Chalan</p>
                            </a>

                        </li>
                        <li>
                            <a href="{{ route('packaging.todayInvoice') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Today's Invoices

                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                {{-- Packaging's End --}}


                {{-- Sale's menus --}}
                @role('super_admin|admin|purchases_team')
                <li class="nav-item">
                    <a href="{{ route('purchaser.order.pending') }}" class="nav-link">
                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>
                            Today's Requirements
                        </p>
                    </a>
                </li>
                @endrole
                @role('super_admin|admin|sales_executive')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('order.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Order</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Today's Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('order.pending') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending Orders</p>
                            </a>
                        </li>
                        @role('super_admin|admin|smg_manager')
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Today's Sales </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Monthly Sales</p>
                            </a>
                        </li>
                        @endrole
                    </ul>

                </li>


                @endrole

                {{-- End Sale's menus --}}

                {{-- Users Group Header --}}
                @role('super_admin|admin|smg_manager')
                <li class="nav-header">USERS GROUP</li>
                {{-- Users Overview --}}
                <li class="nav-item">
                    <a href="{{ route('users.overview') }}" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>
                            Overviews
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>


                {{-- User sitebar menu --}}

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All-Users </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                @role('super_admin|admin')
                <li class="nav-item">
                    <a href="{{ route('user.adminsIndex') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            Admins
                        </p>
                    </a>
                </li>
                @endrole
                @role('super_admin|admin|smg_manager')
                <li class="nav-item">
                    <a href="{{ route('user.smgManagerIndex') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            SMG Managers
                        </p>
                    </a>
                </li>
                @endrole
                @role('super_admin|admin|smg_manager|sales_executive')
                <li class="nav-item">
                    <a href="{{ route('user.salesExecutiveIndex') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            Sales Executives
                        </p>
                    </a>
                </li>
                @endrole
                @role('super_admin|admin|smg_manager|sales_executive|purchases_team|root_smg_manager')
                <li class="nav-item">
                    <a href="{{ route('user.purchasesTeamIndex') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            Purchase Teams
                        </p>
                    </a>
                </li>
                @endrole




                <li class="nav-header text-uppercase">Customers & Suppliers</li>
                {{-- Customers --}}
                <li class="nav-item">
                    @role('admin|super_admin|smg_manager|sales_executive')
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-restroom"></i>
                        <p>
                            Customers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    @endrole
                    <ul class="nav nav-treeview">
                        @role('admin|super_admin|smg_manager|sales_executive')
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Customers </p>
                            </a>
                        </li>
                        @endrole
                        @role('admin|super_admin|sales_executive|smg_manager')
                        <li class="nav-item">
                            <a href="{{ route('customer.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New </p>
                            </a>
                        </li>
                        @endrole
                        @role('admin|super_admin|sales_executive|smg_manager')
                        <li class="nav-item">
                            <a href="{{ route('account.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account </p>
                            </a>
                        </li>
                        @endrole
                    </ul>
                </li>

                {{-- Suppliers --}}
                @role('super_admin|admin|purchases_team|smg_manager')
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Suppliers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('supplier.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Suppliers </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplier.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Delivery Team
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('delivery.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Delivery Man </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('delivery.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Delivery Man</p>
                            </a>
                        </li>
                        <li>
                        <li>
                            <a href="{{ route('delivery.invoice') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    View Today's Chalan

                                </p>
                            </a>
                        </li>
                </li>
            </ul>
            </li>


            {{-- End Customers --}}
            @role('super_admin|admin|smg_manager')
            {{-- End User's Groups --}}
            <li class="nav-header">SETTINGS</li>
            <li class="nav-item">
                <a href="{{ route('unit.index') }}" class="nav-link">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <p>
                        Set Unit
                    </p>
                </a>
            </li>
            @endrole
            @role('super_admin|admin|smg_manager|sales_executive|purchases_team')
            <li class="nav-header text-uppercase">Notifications</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-file"></i>
                    <p>Reports</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-circle text-warning"></i>
                    <p>Warning</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-circle text-info"></i>
                    <p>Informational</p>
                </a>
            </li>
            @endrole

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>