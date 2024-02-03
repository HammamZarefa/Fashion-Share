@extends('admin.layouts.app')
@section('panel')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="float: right;">@lang('Supplier Information')</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name : ') {{$supplier->name ?? ''}}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Mobile : '){{$supplier->mobile ?? ''}}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Email : ') {{$supplier->email ?? ''}}</label>
                        </div>
                    </div>
                </div>
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
                                <th scope="col">@lang('Price')</th>
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
                                    <td>{{$item->price}}</td>
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
                                        <a href="{{ route('admin.service.editWithSupplier',[$supplier->id,$item->id]) }}"
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
                    <a href="{{route('admin.service.createWithSupplier',$supplier->id)}}" class="btn btn-outline-primary b-radius--capsule">
                        @lang('Add Product')
                    </a>
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
    });


    function myFunction() {
        document.getElementById("myForm").submit();
    }
</script>
@endpush
