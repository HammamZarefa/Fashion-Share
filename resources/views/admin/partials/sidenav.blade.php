<div
    class="sidebar {{ sidebarVariation()['selector'] }} {{ sidebarVariation()['sidebar'] }} {{ @sidebarVariation()['overlay'] }} {{ @sidebarVariation()['opacity'] }}"
    data-background="{{getImage('assets/admin/images/sidebar/2.jpg','400x800')}}">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{route('admin.dashboard')}}" class="sidebar__main-logo"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('image')"></a>
            <a href="{{route('admin.dashboard')}}" class="sidebar__logo-shape"><img
                    src="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                @if(!Auth::guard('admin')->user()->branch && !isset($branch_id))
                    <li class="sidebar-menu-item {{menuActive('admin.dashboard')}}">
                        <a href="{{route('admin.dashboard')}}" class="nav-link ">
                            <i class="menu-icon las la-home"></i>
                            <span class="menu-title">@lang('Dashboard')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item {{menuActive('admin.branchs*')}}">
                        <a href="{{route('admin.branch')}}" class="nav-link ">
                            <i class="menu-icon las la-store-alt"></i>
                            <span class="menu-title">@lang('Branchs')</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{menuActive('admin.users*',3)}}">
                            <i class="menu-icon las la-users"></i>
                            <span class="menu-title">@lang('Manage Users')</span>
                        </a>
                        <div class="sidebar-submenu {{menuActive('admin.users*',2)}} ">
                            <ul>
                                <li class="sidebar-menu-item {{menuActive('admin.users.all')}} ">
                                    <a href="{{route('admin.users.all')}}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('All Users')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{menuActive('admin.users.email.all')}}">
                                    <a href="{{route('admin.users.email.all')}}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Send Email')</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->branch || isset($branch_id))
                    <li class="sidebar-menu-item {{menuActive('admin.invoices')}}">
                        <a href="{{route('admin.invoices')}}" class="nav-link ">
                            <i class="menu-icon las la-file"></i>
                            <span class="menu-title">@lang('Invoices')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{menuActive('admin.rents')}}">
                        <a href="{{route('admin.rents',4)}}" class="nav-link ">
                            <i class="menu-icon las la-file"></i>
                            <span class="menu-title">@lang('Rents')</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-menu-item {{menuActive('admin.section*')}}">
                    <a href="{{route('admin.model.index','section')}}" class="nav-link ">
                        <i class="menu-icon las la-cubes"></i>
                        <span class="menu-title">@lang('Sections')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('admin.categories*')}}">
                    <a href="{{route('admin.categories.index')}}" class="nav-link ">
                        <i class="menu-icon las la-tags"></i>
                        <span class="menu-title">@lang('Categories')</span>
                    </a>
                </li>
                @if(Auth::guard('admin')->user()->branch)
                <li class="sidebar-menu-item {{menuActive('admin.services*')}}">
                    <a href="{{route('admin.services.index')}}" class="nav-link ">
                        <i class="menu-icon las la-tshirt"></i>
                        <span class="menu-title">@lang('Services')</span>
                    </a>
                </li>
                    @endif
                    <hr>
                    <li class="sidebar__menu-header">@lang('Product Fillter')</li>
                <li class="sidebar-menu-item {{menuActive('admin.size*')}}">
                    <a href="{{route('admin.size.index')}}" class="nav-link ">
                        <i class="menu-icon las la-ruler"></i>
                        <span class="menu-title">@lang('Size')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('admin.color*')}}">
                    <a href="{{route('admin.color.index')}}" class="nav-link ">
                        <i class="menu-icon las la-palette"></i>
                        <span class="menu-title">@lang('Colors')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('admin.condition*')}}">
                    <a href="{{route('admin.model.index','condition')}}" class="nav-link ">
                        <i class="menu-icon las la-info-circle"></i>
                        <span class="menu-title">@lang('Product Condition')</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{menuActive('admin.material*')}}">
                    <a href="{{route('admin.model.index','material')}}" class="nav-link ">
                        <i class="menu-icon las la-vial"></i>
                        <span class="menu-title">@lang('Material')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.season*')}}">
                    <a href="{{route('admin.model.index','season')}}" class="nav-link ">
                        <i class="menu-icon las la-vial"></i>
                        <span class="menu-title">@lang('Season')</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{menuActive('admin.style*')}}">
                    <a href="{{route('admin.style.index')}}" class="nav-link ">
                        <i class="menu-icon las la-ruler"></i>
                        <span class="menu-title">@lang('Style')</span>
                    </a>
                </li>

                    <hr>
                    <li class="sidebar__menu-header">@lang('Setting')</li>
                    @if(Auth::guard('admin')->user()->branch || isset($branch_id))
                <li class="sidebar-menu-item">
                    <a href="{{route('admin.banner')}}" class="nav-link ">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Manage Banners')</span>
                    </a>
                </li>
                    @endif

                {{--                Orders--}}
                {{--                <li class="sidebar-menu-item sidebar-dropdown">--}}
                {{--                    <a href="javascript:void(0)" class="{{menuActive('admin.orders*',3)}}">--}}
                {{--                        <i class="menu-icon las la-file-invoice"></i>--}}
                {{--                        <span class="menu-title">@lang('Manage Orders')</span>--}}

                {{--                        @if($pending_orders > 0 || $processing_orders > 0)--}}
                {{--                            <span class="menu-badge pill bg--primary ml-auto">--}}
                {{--                                <i class="fa fa-exclamation"></i>--}}
                {{--                            </span>--}}
                {{--                        @endif--}}
                {{--                    </a>--}}
                {{--                    <div class="sidebar-submenu {{menuActive('admin.orders*',2)}} ">--}}
                {{--                        <ul>--}}
                {{--                            <li class="sidebar-menu-item {{menuActive('admin.orders.all')}} ">--}}
                {{--                                <a href="{{route('admin.orders.all')}}" class="nav-link">--}}
                {{--                                    <i class="menu-icon las la-dot-circle"></i>--}}
                {{--                                    <span class="menu-title">@lang('All Orders')</span>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}

                {{--                            <li class="sidebar-menu-item {{menuActive('admin.orders.pending')}} ">--}}
                {{--                                <a href="{{route('admin.orders.pending')}}" class="nav-link">--}}
                {{--                                    <i class="menu-icon las la-dot-circle"></i>--}}
                {{--                                    <span class="menu-title">@lang('Pending Orders')</span>--}}
                {{--                                    @if($pending_orders)--}}
                {{--                                        <span class="menu-badge pill bg--primary ml-auto">{{$pending_orders}}</span>--}}
                {{--                                    @endif--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <li class="sidebar-menu-item {{menuActive('admin.orders.processing')}} ">--}}
                {{--                                <a href="{{route('admin.orders.processing')}}" class="nav-link">--}}
                {{--                                    <i class="menu-icon las la-dot-circle"></i>--}}
                {{--                                    <span class="menu-title">@lang('Processing Orders')</span>--}}
                {{--                                    @if($processing_orders)--}}
                {{--                                        <span class="menu-badge pill bg--primary ml-auto">{{$processing_orders}}</span>--}}
                {{--                                    @endif--}}
                {{--                                </a>--}}
                {{--                            </li>--}}

                {{--                            <li class="sidebar-menu-item {{menuActive('admin.orders.completed')}}">--}}
                {{--                                <a href="{{route('admin.orders.completed')}}" class="nav-link">--}}
                {{--                                    <i class="menu-icon las la-dot-circle"></i>--}}
                {{--                                    <span class="menu-title">@lang('Completed Orders')</span>--}}
                {{--                                    @if($sms_unverified_users_count)--}}
                {{--                                        <span--}}
                {{--                                            class="menu-badge pill bg--primary ml-auto">{{$sms_unverified_users_count}}</span>--}}
                {{--                                    @endif--}}
                {{--                                </a>--}}
                {{--                            </li>--}}

                {{--                            <li class="sidebar-menu-item {{menuActive('admin.orders.cancelled')}}">--}}
                {{--                                <a href="{{route('admin.orders.cancelled')}}" class="nav-link">--}}
                {{--                                    <i class="menu-icon las la-dot-circle"></i>--}}
                {{--                                    <span class="menu-title">@lang('Cancelled Orders')</span>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}

                {{--                            <li class="sidebar-menu-item {{menuActive('admin.orders.refunded')}}">--}}
                {{--                                <a href="{{route('admin.orders.refunded')}}" class="nav-link">--}}
                {{--                                    <i class="menu-icon las la-dot-circle"></i>--}}
                {{--                                    <span class="menu-title">@lang('Refunded Orders')</span>--}}
                {{--                                </a>--}}
                {{--                            </li>--}}

                {{--                        </ul>--}}
                {{--                    </div>--}}
                {{--                </li>--}}

                {{--                Users--}}


                @if(getSettingState())

                    {{--                    <li class="sidebar__menu-header">@lang('Settings')</li>--}}

                    {{--                    <li class="sidebar-menu-item {{menuActive('admin.setting.index')}}">--}}
                    {{--                        <a href="{{route('admin.setting.index')}}" class="nav-link">--}}
                    {{--                            <i class="menu-icon las la-life-ring"></i>--}}
                    {{--                            <span class="menu-title">@lang('General Setting')</span>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}

                    {{--                    <li class="sidebar-menu-item {{menuActive('admin.setting.logo_icon')}}">--}}
                    {{--                        <a href="{{route('admin.setting.logo_icon')}}" class="nav-link">--}}
                    {{--                            <i class="menu-icon las la-images"></i>--}}
                    {{--                            <span class="menu-title">@lang('Logo Icon Setting')</span>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}

                    <li class="sidebar-menu-item  {{menuActive(['admin.language.manage','admin.language.key'])}}">
                        <a href="{{route('admin.language.key', (\App\Models\Language::where('code' ,'ar')->first())->id)}}"
                           class="nav-link"
                           data-default-url="">
                            <i class="menu-icon las la-language"></i>
                            <span class="menu-title">@lang('Translation') </span>
                        </a>
                    </li>

                @endif

            </ul>
        </div>
    </div>
</div>
<script>
    function showRate() {
        document.getElementById("rate").style.display = "block";
    }
</script>
