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
                                <th scope="col">@lang('ID')</th>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Products Code')</th>
                                <th scope="col">@lang('Products Name')</th>
                                <th scope="col">@lang('Section')</th>
                                <th scope="col">@lang('Categories')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Date Of Process')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($invoices as $invoice)
                                <tr>
                                    <td data-label="@lang('Id')">{{__($invoice->id)}}</td>
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
                                    <td data-label="@lang('Section')">
                                        @foreach($invoice->products as $product)
                                            {{__($product->section->name )}}<br><br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Category')">
                                        @foreach($invoice->products as $product)
                                            @foreach($product->categories as $category)
                                                {{__($category->name )}}<br><br>
                                            @endforeach
                                                <br>
                                        @endforeach
                                    </td>
                                    <td data-label="@lang('Status')">
                                            <span class="text--small badge font-weight-normal badge--primary">{{$invoice->status}}</span>
                                    </td>
                                    <td data-label="@lang('Name')">{{__($invoice->date_of_process)}}</td>


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
