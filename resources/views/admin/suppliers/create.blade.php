@extends('admin.layouts.app')
@section('panel')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="float: right;">@lang('Supplier Information')</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" method="post" action="{{ route('admin.suppliers.store',$supplier->id)}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-row form-group">
                                <label class="font-weight-bold ">@lang('Name') </label>
                                <input type="text" class="form-control" name="name"
                                       placeholder="@lang('Supplier Name')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row form-group">
                                <label class="font-weight-bold ">@lang('Mobile')</label>
                                <input type="text" class="form-control" name="mobile"
                                       placeholder="@lang('Supplier Mobile')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row form-group">
                                <label class="font-weight-bold ">@lang('Email')</label>
                                <input type="email" class="form-control" name="email"
                                       placeholder="@lang('Supplier Email')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Save')</label>
                            <input type="submit" class="btn  btn--primary text-white form-control" value="@lang('Save')">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="card-header">
                    <h3 class="card-title" style="float: right;">@lang('Products')</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Product Image')</th>
                                <th scope="col">@lang('Code')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Buy Price')</th>
                                <th scope="col">@lang('Cost')</th>
                                <th scope="col">@lang('Added Date')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($supplier->products as $item)
                                <tr>
                                    <td>
                                        @if(@$item->images[0])
                                            <img  max-width="40px" width="70px;"
                                                  src="{{ getImage(imagePath()['service']['path'].'/'. $item->images[0]->path,imagePath()['service']['size'])}}"

                                                  alt="Waterfall" />
                                        @endif
                                    </td>
                                    <td>{{$item->sku}}</td>
                                    <td><span class="name">{{__($item->name)}}</span></td>
                                    <td>{{$item->buy_price}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                                    <td data-label="@lang('Status')">
                                        @if($item->status=='available' )
                                            <span
                                                class="text--small badge font-weight-normal badge--success">@lang('Available')</span>
                                        @elseif($item->status=='not_available')
                                            <span
                                                class="text--small badge font-weight-normal badge--warning">@lang('Not available')</span>
                                        @elseif($item->status=='sale')
                                            <span
                                                class="text--small badge font-weight-normal badge--primary">{{$item->status}}</span>
                                        @elseif($item->status=='rejected')
                                            <span
                                                class="text--small badge font-weight-normal badge--danger">{{$item->status}}</span>

                                        @else
                                            <span
                                                class="text--small badge font-weight-normal badge--dark">{{$item->status}}</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.service.editWithSupplier',[$supplier->id,$item->id,'create']) }}"
                                           class="icon-btn editGatewayBtn ml-1" data-toggle="tooltip"
                                           title="@lang('Edit')"
                                           data-original-title="@lang('Edit')">
                                            <i class="la la-pencil"></i>
                                        </a>

                                        <a href="{{ route('admin.services.ditails', $item->id) }}"
                                           class="icon-btn bg--info ml-1" data-toggle="tooltip" title="@lang('Show Details')"
                                           data-original-title="@lang('Show')">
                                            <i class="la la-eye"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="icon-btn bg--danger ml-1 DeleteService"
                                           data-toggle="tooltip" title="@lang('Delete')"
                                           data-url="{{ route('admin.services.delete', $item->id)}}"
                                           data-original-title="@lang('Delete')">
                                            <i class="la la-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer" style="text-align-last:right">
                    <a href="{{route('admin.service.createWithSupplier',[$supplier->id,'create'])}}" class="btn btn-outline-primary b-radius--capsule">
                        @lang('Add Product')
                    </a>
                </div>
            </div><!-- card end -->
            <div>
                <div class="card-header">
                    <h3 class="card-title" style="float: right;">@lang('Payments')</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Data')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($supplier->supplierPayments as $item)
                                <tr>
                                    <td>{{$item->amount}}</td>
                                    <td><span class="name">{{date('d/m/Y', strtotime($item->created_at))}}</span></td>

                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)" class="icon-btn editPaymentBtn ml-1"
                                           data-original-title="@lang('Edit Payment')" data-toggle="tooltip"
                                           data-amount="{{ $item->amount }}"
                                           data-url="{{ route('admin.suppliers.editPayment',$item->id) }}" >
                                            <i class="la la-pencil"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="icon-btn bg--danger ml-1 DeleteService"
                                           data-toggle="tooltip" title="@lang('Delete')"
                                           data-url="{{ route('admin.suppliers.deletePayment', $item->id)}}"
                                           data-original-title="@lang('Delete')">
                                            <i class="la la-trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer" style="text-align-last:right">
                    <a href="javascript:void(0)" class="btn btn-outline-primary b-radius--capsule addPaymentBtn"
                       data-original-title="@lang('Add Payment')" data-toggle="tooltip"
                       data-url="{{ route('admin.suppliers.createpayment',[$supplier->id,'create'])}}" >
                        @lang('Add Payment')
                    </a>
                    {{--                    <a href="{{route('admin.suppliers.createpayment',$supplier->id)}}" class="btn btn-outline-primary b-radius--capsule">--}}
                    {{--                        @lang('Add Payment')--}}
                    {{--                    </a>--}}
                </div>
            </div><!-- card end -->
        </div>
    </div>

    {{-- ACTIVATE METHOD MODAL --}}
    <div id="DeleteService" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Are you sure to Delete?')
                    </h5>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem -1rem" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')


                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Delete')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ACTIVATE METHOD MODAL --}}
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Add payment')</h4>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Amount') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="amount" name="amount" required>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary" id="btn-save"
                                    value="add">@lang('Update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ACTIVATE METHOD MODAL --}}
    <div class="modal fade" id="editPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Edit payment')</h4>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Amount') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="amount" name="amount" required>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary" id="btn-save"
                                    value="add">@lang('Update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>

        $(function () {
            "use strict";


            $('.DeleteService').on('click', function () {
                var modal = $('#DeleteService');
                var url = $(this).data('url');


                modal.find('form').attr('action', url);
                modal.modal('show');
            });

            $('.addPaymentBtn').on('click', function () {
                var modal = $('#addPaymentModal');
                var url = $(this).data('url');


                modal.find('form').attr('action', url);
                modal.modal('show');
            });


            $('.editPaymentBtn').on('click', function () {
                var modal = $('#editPaymentModal');
                var url = $(this).data('url');


                var amount = $(this).data('amount');
                modal.find('input[name=amount]').val(amount);
                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        });


        function myFunction() {
            document.getElementById("myForm").submit();
        }
    </script>
@endpush
