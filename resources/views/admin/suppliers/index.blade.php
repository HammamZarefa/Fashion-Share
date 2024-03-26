@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="card-body col-4">


                    <select class="custom-select" name="branch" onchange="window.location.href=this.options[this.selectedIndex].value;">
                        <option selected value=" {{ route('admin.suppliers.index') }}">

                            All
                        </option>
                    </select>

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Email')</th>
                                 <th scope="col">@lang('Mobile')</th>
                                 <th scope="col">@lang('Product Count')</th>
                                 <th scope="col">@lang('The amount due for payment')</th>
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($suppliers as $item)
                                <tr>
                                    <td data-label="@lang('Name')">{{__($item->name)}}</td>
                                    <td data-label="@lang('Email')">{{$item->email}}</td>
                                    <td data-label="@lang('Mobile')">{{$item->mobile}}</td>
                                    <td data-label="@lang('Product Count')">{{count($item->products)}}</td>
                                    <td data-label="@lang('The amount due for payment')">{{$item->products()->sum('buy_price')}}</td>
                                    <td data-label="@lang('Action')">
{{--                                        <a href="javascript:void(0)" class="icon-btn ml-1 editBtn"--}}
{{--                                           data-original-title="@lang('Edit')" data-toggle="tooltip"--}}
{{--                                           data-url="{{ route('admin.suppliers.update', $item->id)}}" data-name="{{ $item->name }}"--}}
{{--                                           data-field="{{$item->field_name}}" >--}}
{{--                                            <i class="la la-edit"></i>--}}
{{--                                        </a>--}}
                                        <a href="{{route('admin.suppliers.edit',$item->id)}}" class="icon-btn ml-1"
                                           data-original-title="@lang('Edit')">
                                            <i class="la la-edit"></i>
                                        </a>
                                        <a href="{{route('admin.suppliers.show',$item->id)}}" class="icon-btn ml-1 btn--success"
                                           data-original-title="@lang('Edit')">
                                            <i class="la la-eye"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                           class="icon-btn btn--danger ml-1 statusBtn"
                                           data-original-title="@lang('Status')" data-toggle="tooltip"
                                           data-url="{{ route('admin.suppliers.delete', $item->id) }}">
                                            <i class="la la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
{{--                                @empty--}}
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>



    {{-- NEW MODAL --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                         @lang('Add New Supplier')</h4>
                    <button type="button" class="close" data-dismiss="modal" style="margin: -1rem -1rem -1rem 0rem"1 aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.suppliers.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                        class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name" required placeholder="@lang('Enter Supplier Name')">
                            </div>
                        </div>
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Email') <span
                                        class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control has-error bold " id="email" name="email" required placeholder="@lang('Enter Supplier Email')">
                            </div>
                        </div>
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Mobile') <span
                                        class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="mobile" name="mobile" required placeholder="@lang('Enter Supplier Mobile')">
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('User') </label>
                            <div class="col-sm-12">
                                <select name="user_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                                    <option value="-1" selected>@lang('Choose One!')</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" >{{ $user->email }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary" id="btn-save" value="add">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Edit')</h4>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                        class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name" value="{{$item->name ?? ''}}" required>
                            </div>
                        </div>
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Email') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control has-error bold " id="email" name="email" required value="{{$item->email ?? ''}}">
                            </div>
                        </div>
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Mobile') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="mobile" name="mobile" required value="{{$item->mobile ?? ''}}">
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('User') </label>
                            <div class="col-sm-12">
                                <select name="user_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                                    <option value="-1" selected>@lang('Choose One!')</option>
                                    @if(!$suppliers->isEmpty())
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}"  {{ $item->user_id == $user->id ? "selected" :""}}>{{ $user->email }}</option>
                                    @endforeach
                                    @endif
                                </select>

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

    {{-- Status MODAL --}}
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Are you sure to Delete?')</h4>
                    <button type="button" class="close"  style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="delete_id" id="delete_id" class="delete_id" value="0">
                    {{-- <div class="modal-body">
                        <p class="text-muted">@lang('Are you sure to change the status?')</p>
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" href="{{route('admin.suppliers.create')}}"><i
                class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                var url = $(this).data('url');
                var name = $(this).data('name');
                var category = $(this).data('category');
                var section = $(this).data('section');

                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                // modal.find('select[name=category_id]').val(category);
                // modal.find('select[name=section_id]').val(section);

                modal.modal('show');
            });

            $('.statusBtn').on('click', function () {
                var modal = $('#statusModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
