@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                @if($model == 'Section')
                                    <th scope="col">@lang('Is For Rent')</th>
                                @endif
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td data-label="@lang('Name')">{{__($item->name)}}</td>
                                    @if($model == 'Section')
                                        <td data-label="@lang('Is For Rent')">{{__($item->is_rent)}}</td>
                                    @endif
                                    <td data-label="@lang('Action')">
                                        @if(!Auth::guard('admin')->user()->branch )
                                            <a href="javascript:void(0)" class="icon-btn ml-1 editBtn"
                                               data-original-title="@lang('Edit')" data-toggle="tooltip"
                                               data-url="{{ route('admin.model.update',['model'=> $model,'id'=>$item->id])}}"
                                               data-name="{{ $item->name }}"
                                               data-field="{{$item->field_name}}">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                               class="icon-btn btn--danger ml-1 statusBtn"
                                               data-original-title="@lang('Status')" data-toggle="tooltip"
                                               data-url="{{ route('admin.model.delete',['model'=>$model,'id'=> $item->id]) }}">
                                                <i class="la la-eye-slash"></i>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)"
                                               class="icon-btn {{Auth::guard('admin')->user()->branch->model($model)->where('branchable_id', $item->id)->exists() ? "btn--danger" :"btn--success"}} ml-1 addBtn"
{{--                                               data-original-title="@lang('Add Or Remove Category From Branch')"--}}
{{--                                               data-toggle="tooltip"--}}
                                               data-url="{{ route('admin.modelAddBranch.add',['model'=>$model,'id'=> $item->id]) }}">
                                                <i class="la {{Auth::guard('admin')->user()->branch->model($model)->where('branchable_id', $item->id)->exists() ? "la-trash" :"la-check"}}"></i>
                                            </a>
                                        @endif
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
            </div><!-- card end -->
        </div>
    </div>



    {{-- NEW MODAL --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        @lang('Add New '.$model)</h4>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal"
                            aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.model.store',$model)}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name" required
                                       placeholder="@lang('Enter '.$model.' name')">
                            </div>
                            @if($model == 'Section')
                                <label class="font-weight-bold ">@lang('Is For Rent') <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="checkbox" class="form-control has-error bold " id="is_rent" name="is_rent"
                                           placeholder="@lang('Enter '.$model.' name')">
                                </div>
                            @endif

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
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Edit')</h4>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal"
                            aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name"
                                       value="{{$item->name ?? ''}}" required>
                            </div>
                            @if($model == 'Section')
                                <label class="font-weight-bold ">@lang('Is For Rent') <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="checkbox" class="form-control has-error bold " id="is_rent" name="is_rent"
                                        >
                                </div>
                            @endif
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
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Are you sure to Delete?')</h4>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal"
                            aria-hidden="true">&times;
                    </button>
                </div>
                <form method="post" action="">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="delete_id" id="delete_id" class="delete_id" value="0">
                    {{-- <div class="modal-body">
                        <p class="text-muted">@lang('Are you sure to delete?')</p>
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- Add MODAL --}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"
                        id="myModalLabel">@lang('Are you sure to Add This Category To Your Branch?')</h4>
                    <button type="button" class="close" style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal"
                            aria-hidden="true">&times;
                    </button>
                </div>
                <form method="post" action="">
                    @csrf
                    <input type="hidden" name="delete_id" id="delete_id" class="delete_id" value="0">
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@if(!Auth::guard('admin')->user()->branch )
    @push('breadcrumb-plugins')
        <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" data-toggle="modal"
           data-target="#myModal"><i
                class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
    @endpush
@endif

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                var url = $(this).data('url');
                var name = $(this).data('name');
                @if($model == 'Section')
                var is_rent = $(this).data('is_rent');
                console.log(modal.find('input[name=is_rent]'))
                modal.find('input[name=is_rent]').checked;
                @endif
                var name = $(this).data('name');
                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                modal.modal('show');
            });

            $('.statusBtn').on('click', function () {
                var modal = $('#statusModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });


            $('.addBtn').on('click', function () {
                var modal = $('#addModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
