@extends('admin.layouts.app')
@section('panel')


    <div class="card-body col-4">

        @if(!Auth::guard('admin')->user()->branch)

            <select class="custom-select" name="branch"
                    onchange="window.location.href=this.options[this.selectedIndex].value;">
                <option selected value=" {{ route('admin.invoices') }}">All Branch</option>
                @foreach($branchs as $branch)
                    <option {{$id == $branch->id ?'selected':''}} value=" {{ route('admin.invoices',$branch->id) }}">

                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="card-body p-0">
                    <form class="form-horizontal" action="{{route('admin.rent.search',$id)}}" method="post">
                        <div class="card">
                            <div class="card-title">
                                <h1 style="text-align: right;display: inline-block;float: right;margin-left: 25px;margin-right: 25px">
                                    @lang('Rents')
                                </h1>

                                @csrf

                                <select class="form-control col-md-3" name="days"
                                        style="display: inline-block;margin-top: 10px">
                                    <option value="1">@lang('Today')</option>
                                    <option value="2">@lang('This Week')</option>
                                    <option value="3">@lang('This Month')</option>
                                    <option value="4">@lang('This Year')</option>
                                    <option value="5">@lang('All Times')</option>
                                </select>
                                <h4 style="display: inline-block;margin-left: 25px;margin-right: 25px">
                                    @lang('Choose Date')
                                </h4>
                                <input type="date" class="form-control col-md-3" name="date"
                                       style="display: inline-block;margin-top: 10px">
                                <input type="submit"
                                       class="btn btn-sm btn--primary box--shadow1 text-white text--small col-md-1"
                                       value="@lang('Submit')">
                                <a href="javascript:void(0)" class="btn btn-sm btn--success box--shadow1 text-white text--small col-md-2 editBtn"
                                style="padding: 10px 20px;-webkit-border-radius: 5px;font-size: 0.875rem !important;"
                                   data-original-title="@lang('Rent Products')" data-toggle="tooltip"
                                >
                                    @lang('Rent Products')
                                </a>

                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="row">
                                    <h1 style="text-align: right;display:block;float: right;margin-left: 25px">
                                        {{@$invoicesStatistics[0]->total_price}} @lang('SP')
                                    </h1>
                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <div class="row form-group">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control"
                                                       placeholder="@lang('Enter Product Code Or Name')"
                                                       name="product_code">
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" name="section">
                                                    <option value="-1" selected>@lang('Section')</option>
                                                    @foreach($sections as $section)
                                                        <option value="{{$section->id}}">{{$section->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" name="category">
                                                    <option value="-1" selected>@lang('Category')</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{--                                            <div class="col-md-3">--}}
                                            {{--                                                <input type="submit" class="form-control" placeholder="@lang('Enter Product Code Or Name')" name="product_code">--}}
                                            {{--                                            </div>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                            </div>

                        </div>
                    </form>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Invoice Number')</th>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Products Code')</th>
                                <th scope="col">@lang('Products Name')</th>
                                <th scope="col">@lang('Sell Price')</th>
                                <th scope="col">@lang('Cost')</th>
                                <th scope="col">@lang('Buy Price')</th>
                                <th scope="col">@lang('Profit')</th>
                                <th scope="col">@lang('Section')</th>
                                <th scope="col">@lang('Categories')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Supplier')</th>
                                <th scope="col">@lang('Client Name')</th>
                                <th scope="col">@lang('Mobile')</th>
                                <th scope="col">@lang('Date Of Return')</th>
                                <th scope="col">@lang('Date Of Process')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($invoices as $invoice)
                                <tr>
                                    <td data-label="@lang('Invoice Number')">{{__($invoice->id)}}</td>
                                    <td data-label="@lang('Image')">
                                        @foreach($invoice->products as $product)
                                            @if(@$product->images[0])
                                                <img max-width="40px" width="70px;"
                                                     src="{{ getImage(imagePath()['service']['path'].'/'. $product->images[0]->path,imagePath()['service']['size'])}}"

                                                     alt="Waterfall"/><br><br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Products Code')">
                                        @foreach($invoice->products as $product)
                                            {{__($product->sku )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Products Name')">
                                        @foreach($invoice->products as $product)
                                            {{__($product->name )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Sell Price')">
                                        @foreach($invoice->products as $product)
                                            {{__($product->sell_price )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Cost')">
                                        @foreach($invoice->products as $product)
                                            {{__($product->price )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Buy Price')">
                                        @foreach($invoice->products as $product)
                                            {{__($product->buy_price )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Profit')">
                                        @foreach($invoice->products as $product)
                                            {{$product->sell_price - ($product->buy_price + $product->price) }}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Section')">
                                        @foreach($invoice->products as $product)
                                            {{__($product->section->name )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Category')">
                                        @foreach($invoice->products as $product)
                                            {{__($product->category->name )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Status')">
                                        <span
                                            class="text--small badge font-weight-normal badge--primary">{{$invoice->status}}</span>
                                    </td>
                                    <td data-label="@lang('Supplier')">
                                        @foreach($invoice->products as $product)
                                            {{__(@$product->supplier->name )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Client Name')">{{__($invoice->username)}}</td>
                                    <td data-label="@lang('Mobile')">{{__($invoice->mobile)}}</td>
                                    <td data-label="@lang('Date Of Return')">
                                        @foreach(@json_decode($invoice->details,true) as $key=>$product)
                                            {{$product['return_date']}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Date Of Process')">{{__($invoice->date_of_process)}}</td>


                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >
        <div class="modal-dialog" style="width: 90%;max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Rent Products')</h4>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                    <div class="modal-body">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light tabstyle--two custom-data-table">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Image')</th>
                                    <th scope="col">@lang('Products Code')</th>
                                    <th scope="col">@lang('Products Name')</th>
                                    <th scope="col">@lang('Client Name')</th>
                                    <th scope="col">@lang('Mobile')</th>
                                    <th scope="col">@lang('Date Of Return')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($rentProducts as $product)
                                    <tr>
                                        <td data-label="@lang('Image')">
                                                @if(@$product->images[0])
                                                    <img max-width="40px" width="70px;"
                                                         src="{{ getImage(imagePath()['service']['path'].'/'. $product->images[0]->path,imagePath()['service']['size'])}}"

                                                         alt="Waterfall"/>
                                                @endif
                                        </td>
                                        <td data-label="@lang('Products Code')">
                                                {{__($product->sku )}}
                                        </td>
                                        <td data-label="@lang('Products Name')">
                                                {{__($product->name )}}
                                        </td>

                                        <td data-label="@lang('Client Name')">{{__($product->username)}}</td>
                                        <td data-label="@lang('Mobile')">{{__($product->mobile)}}</td>
                                        <td data-label="@lang('Date Of Return')">
                                            {{$product->return_date}}
{{--                                            @foreach(@json_decode($invoice->details,true) as $key=>$product)--}}
{{--                                                {{$product['return_date']}}<br><br>--}}
{{--                                            @endforeach--}}
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table><!-- table end -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>

                        </div>
                    </div>
            </div>
        </div>
    </div>



@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" href="{{route('admin.rent.create')}}"><i
            class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.editBtn').on('click', function () {
                var modal = $('#editModal');

                modal.modal('show');
            });


        })(jQuery);
    </script>
@endpush
