<!-- Main Sidebar Container -->
<style>
    @media(max-width:768px){
         .main-sidebar, .main-sidebar::before{
            /*margin-left:0;*/
            margin-right:-250px !important;
        }
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('/') }}" class="brand-link" style="width: 100px;
    height: 100px;
    margin: auto;border-bottom: 0">
        <img src="{{asset("img/logoNav.png")}}" alt="AdminLTE Logo" class="" style="float: unset !important;
    height: 100%;
    width: 100%;
    object-fit: scale-down;
    margin: auto;"
             style="opacity: .8">
{{--        <span class="brand-text font-weight-light">@lang('dashboard.HalaTicket')</span>--}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset("img/user2-160x160.jpg")}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('/') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item  ">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            @lang('dashboard.Home')
                        </p>
                    </a>
                </li>
                <!-- <li class="nav-item ">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>
                            @lang('dashboard.Admins')
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            @lang('dashboard.categories')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('dashboard.Resident Seekers')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('dashboard.Non-Resident Seekers')</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="nav-item ">
                    <a href="{{ url('category') }}" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            @lang('dashboard.categories')
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ url('event') }}" class="nav-link">
                        <i class="nav-icon fas fa-ad"></i>
                        <p>
                            @lang('dashboard.events')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('userticket') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            @lang('dashboard.Users_Tickets')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('adminticket') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            @lang('dashboard.Admin_Tickets')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('ticketreject') }}" class="nav-link">
                    <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            @lang('dashboard.ticketreject')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('orders') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i>
                        <!-- <i class="fas fa-file-invoice"></i> -->
                        <p>
                            @lang('dashboard.Orders')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('payments') }}" class="nav-link">
                        <i class="fas fa-credit-card"></i>
                        <p>
                            @lang('dashboard.Payments')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('copounes') }}" class="nav-link">
                        <i class="nav-icon nav-icon fas fa-lock"></i>
                        <p>
                            @lang('dashboard.copounes')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('user') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            @lang('dashboard.Users')
                        </p>
                    </a>
                </li>
                <!-- <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list-ol"></i>
                        <p>
                            @lang('dashboard.Jobs and Skills')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link {{ in_array(request()->route()->getName(), ['jobs.index', 'jobs.create', 'jobs.edit']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('dashboard.Jobs')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ in_array(request()->route()->getName(), ['skills.index', 'skills.create', 'skills.edit']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('dashboard.Skills')</p>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <li class="nav-item ">
                    <a href="{{ url('contact-us') }}" class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            @lang('dashboard.Messages')
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ url('commonquestion') }}" class="nav-link">
                        <i class="nav-icon fas fa-question"></i>
                        <p>
                            @lang('dashboard.Questions')
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ url('policy') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            @lang('dashboard.Policies')
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{ route('setting') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            @lang('dashboard.Settings')
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
