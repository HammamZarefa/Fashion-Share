@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('ID')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Category')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Branch')</th>
                                <th scope="col">@lang('Sale?')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($services as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>
                                        <span class="name">{{__($item->name)}}</span>
                                    </td>
                                    <td data-label="@lang('User')">
                                        <span class="name">{{__(@$item->user->email)}}</span>
                                    </td>
                                    <td>{{$item->categories[0]->name}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->branch->name}}</td>
                                    <td>{{$item->is_for_sale ? 'Sale' : 'Rent'}}</td>
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
                                        <a href="{{ route('admin.services.show', $item->id) }}"
                                           class="icon-btn btn--primary ml-1"
                                           data-original-title="@lang('Show')">
                                            <i class="la la-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.services.edite', $item->id) }}"
                                           class="icon-btn btn--primary ml-1" data-toggle="tooltip" title="@lang('Edit')"
                                           data-original-title="@lang('Edit')">
                                            <i class="la la-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" class="icon-btn btn--danger ml-1"
                                           data-original-title="@lang('Status')" data-toggle="tooltip"
                                           data-url="{{ route('admin.services.update',$item->id)}}"
                                           data-name="{{ $item->name }}"
                                           data-field="{{$item->field_name}}">
                                            <i class="la la-eye-slash"></i>

                                        </a>
                                        <a href="javascript:void(0)" class="icon-btn bg--warning ml-1 SaleOrRentBtn"
                                           data-original-title="@lang("Sale")" data-toggle="tooltip"
                                           data-url="{{ route('admin.services.SaleOrRent',$item->id)}}"
                                           data-is_for_sale="{{ $item->is_for_sale }}">
                                            <i class="la la-usd"></i>
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
                <div class="card-footer">
                    {{ $services->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>

    {{-- ACTIVATE METHOD MODAL --}}
    <div id="SaleOrRent" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @lang('Payment Method Activation Confirmation')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="GET">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to Sale/Rent') <span
                                class="font-weight-bold method-name"></span> @lang('Product')?
                        </p>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Activate')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Payment Method Disable Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span
                                class="font-weight-bold method-name"></span> @lang('method')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Disable')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="changeStatusProduct" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Change Status Product')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body" style="text-align: center">
                        <p>@lang('Are you sure to change status?') <span
                                class="font-weight-bold method-name"></span> @lang('method')?</p>
                        <select name="status">

                            <option style="background: #ffffff">
                                <span>@lang('Available')</span>
                            </option>

                            <option style="background: #ffffff">
                                <span>@lang('Not available')</span>
                            </option>
                            <option style="background: #ffffff">
                                <span>@lang('rent')</span>
                            </option>
                            <option style="background: #ffffff">
                                <span>@lang('sale')</span>
                            </option>
                            <option style="background: #ffffff">
                                <span>@lang('rejected')</span>
                            </option>
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Change')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <div class="row">
        <div class="col-lg-3">
            <div class="page-title">
                <a class="btn btn--primary"
                   href="{{route('admin.services.create')}}">@lang('Add New')</a>
            </div>
        </div>
    </div>
@endpush
@push('script')
    <script>

        $(function () {
            "use strict";

            $('.SaleOrRentBtn').on('click', function () {
                // var modal = $('#SaleOrRent');
                // var url = $(this).data('url');
                // modal.find('.method-name').text($(this).data('name'));

                var modal = $('#SaleOrRent');
                var url = $(this).data('url');
                var name = $(this).data('name');
                var is_for_sale = $(this).data('is_for_sale');
                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);

                modal.modal('show');
            });
            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code]').val($(this).data('code'));
            });
            $('.statusBtn').on('click', function () {
                var modal = $('#changeStatusProduct');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
            $('.editBtn').on('click', function () {
                var modal = $('#changeStatusProduct');
                var url = $(this).data('url');
                var name = $(this).data('name');

                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                modal.modal('show');
            });
            $('.showDetails').on('click', function () {
                var modal = $('#showDetailsProducts');
                var name = $(this).data('name');
                var images = $(this).data('images');
                modal.find('input[name=name]').val(name);

                var container = document.getElementById('imageContainer');
                var keys = [];
                for (var i = 0, j = images.length; i < j; i++) {

                    var col_lg_4 = document.createElement('div');
                    col_lg_4.className = 'col-lg-4';

                    var card = document.createElement('div');
                    card.className = 'card';

                    container.appendChild(col_lg_4);
                    col_lg_4.appendChild(card);

                    var img = document.createElement('img');
                    img.className = "card-img-top";
                    img.alt = "Waterfall";

                    for (var key in images[i]) {
                        if (images[0].hasOwnProperty(key)) {
                            if (key == "path") {
                                var path = "{{asset('storage/')}}";
                                img.src = path + '/' + images[i][key];
                                card.appendChild(img);

                            }
                        }
                    }
                }
                modal.modal('show');
            });
        });
    </script>
@endpush
