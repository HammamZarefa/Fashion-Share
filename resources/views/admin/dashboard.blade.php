@extends('admin.layouts.app')

@section('panel')

    <div class="row mb-none-30">
        <div class="col-xl-3  col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_users']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Users')</span>
                    </div>
                    <a href="{{route('admin.users.all')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    
       
        <div class="col-xl-3  col-sm-6 mb-30">
            <div class="dashboard-w1 bg--warning b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-tshirt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_Product']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Products')</span>
                    </div>
                    <a href="{{route('admin.services.index')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3  col-sm-6 mb-30">
            <div class="dashboard-w1 bg--secondary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-store-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_Branch']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Branchs')</span>
                    </div>
                    <a href="{{route('admin.branch')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>

        
        <div class="col-xl-3  col-sm-6 mb-30">
            <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-tags"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_Category']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Categories')</span>
                    </div>
                    <a href="{{route('admin.categories.index')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>

            
        <div class="col-xl-3  col-sm-6 mb-30">
            <div class="dashboard-w1 bg--info b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-cubes"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{$widget['total_Section']}}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Sections')</span>
                    </div>
                    <a href="{{route('admin.model.index','section')}}"
                       class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <!-- dashboard-w1 end -->
    </div>
    <!-- row end-->


{{--    <div class="row mt-50 mb-none-30">--}}
{{--        <div class="col-xl-4 col-sm-6 mb-30">--}}
{{--            <a href="{{ route('admin.orders.all') }}">--}}
{{--                <div class="widget-two box--shadow2 b-radius--5 bg--white">--}}
{{--                    <i class="las la-shopping-cart overlay-icon text--primary"></i>--}}
{{--                    <div class="widget-two__icon b-radius--5 bg--primary">--}}
{{--                        <i class="las la-shopping-cart"></i>--}}
{{--                    </div>--}}
{{--                    <div class="widget-two__content">--}}
{{--                        <h2 class="">{{$widget['total_orders']}}</h2>--}}
{{--                        <p>@lang('Total Order')</p>--}}
{{--                    </div>--}}
{{--                </div><!-- widget-two end -->--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="col-xl-4 col-sm-6 mb-30">--}}
{{--            <a href="{{ route('admin.orders.pending') }}">--}}
{{--                <div class="widget-two box--shadow2 b-radius--5 bg--white">--}}
{{--                    <i class="las la-spinner overlay-icon text--warning"></i>--}}
{{--                    <div class="widget-two__icon b-radius--5 bg--warning">--}}
{{--                        <i class="las la-spinner"></i>--}}
{{--                    </div>--}}
{{--                    <div class="widget-two__content">--}}
{{--                        <h2 class="">{{$widget['pending_orders']}}</h2>--}}
{{--                        <p>@lang('Pending Order')</p>--}}
{{--                    </div>--}}
{{--                </div><!-- widget-two end -->--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="col-xl-4 col-sm-6 mb-30">--}}
{{--            <a href="{{ route('admin.orders.processing') }}">--}}
{{--                <div class="widget-two box--shadow2 b-radius--5 bg--white">--}}
{{--                    <i class="la la-refresh overlay-icon text--teal"></i>--}}
{{--                    <div class="widget-two__icon b-radius--5 bg--teal">--}}
{{--                        <i class="la la-refresh"></i>--}}
{{--                    </div>--}}
{{--                    <div class="widget-two__content">--}}
{{--                        <h2 class="">{{$widget['processing_orders']}}</h2>--}}
{{--                        <p>@lang('Processing Order')</p>--}}
{{--                    </div>--}}
{{--                </div><!-- widget-two end -->--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="row mt-50 mb-none-30">--}}
{{--        <div class="col-xl-4 col-sm-6 mb-30">--}}
{{--            <a href="{{ route('admin.orders.completed') }}">--}}
{{--                <div class="widget-two box--shadow2 b-radius--5 bg--white">--}}
{{--                    <i class="las la-check-circle overlay-icon text--green"></i>--}}
{{--                    <div class="widget-two__icon b-radius--5 bg--green">--}}
{{--                        <i class="las la-check-circle"></i>--}}
{{--                    </div>--}}
{{--                    <div class="widget-two__content">--}}
{{--                        <h2 class="">{{$widget['completed_orders']}}</h2>--}}
{{--                        <p>@lang('Completed Order')</p>--}}
{{--                    </div>--}}
{{--                </div><!-- widget-two end -->--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="col-xl-4 col-sm-6 mb-30">--}}
{{--            <a href="{{ route('admin.orders.cancelled') }}">--}}
{{--                <div class="widget-two box--shadow2 b-radius--5 bg--white">--}}
{{--                    <i class="las la-times-circle overlay-icon text--pink"></i>--}}
{{--                    <div class="widget-two__icon b-radius--5 bg--pink">--}}
{{--                        <i class="la la-times-circle"></i>--}}
{{--                    </div>--}}
{{--                    <div class="widget-two__content">--}}
{{--                        <h2 class="">{{$widget['cancelled_orders']}}</h2>--}}
{{--                        <p>@lang('Cancelled Order')</p>--}}
{{--                    </div>--}}
{{--                </div><!-- widget-two end -->--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="col-xl-4 col-sm-6 mb-30">--}}
{{--            <a href="{{ route('admin.orders.refunded') }}">--}}
{{--                <a href="{{ route('admin.orders.refunded') }}">--}}
{{--                    <div class="widget-two box--shadow2 b-radius--5 bg--white">--}}
{{--                        <i class="las la-fast-backward overlay-icon text--secondary"></i>--}}
{{--                        <div class="widget-two__icon b-radius--5 bg--secondary">--}}
{{--                            <i class="la la-fast-backward"></i>--}}
{{--                        </div>--}}
{{--                        <div class="widget-two__content">--}}
{{--                            <h2 class="">{{$widget['refunded_orders']}}</h2>--}}
{{--                            <p>@lang('Refunded Order')</p>--}}
{{--                        </div>--}}
{{--                    </div><!-- widget-two end -->--}}
{{--                </a>--}}
{{--        </div>--}}
    </div>
@endsection


@push('script')

@endpush
