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
                                                <img  max-width="40px" width="70px;"
                                                      src="{{ getImage(imagePath()['service']['path'].'/'. $product->images[0]->path,imagePath()['service']['size'])}}"

                                                      alt="Waterfall" /><br><br>
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
                                            <span class="text--small badge font-weight-normal badge--primary">{{$invoice->status}}</span>
                                    </td>
                                    <td data-label="@lang('Supplier')">
                                        @foreach($invoice->products as $product)
                                            {{__(@$product->supplier->name )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Client Name')">{{__($invoice->username)}}</td>
                                    <td data-label="@lang('Mobile')">{{__($invoice->mobile)}}</td>
                                    <td data-label="@lang('Date Of Return')">
                                        @foreach($invoice->products as $key=>$product)
                                            {{__(@$invoice->date_of_return[$key] )}}<br><br>
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




@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" href="{{route('admin.rent.create')}}"><i
            class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
