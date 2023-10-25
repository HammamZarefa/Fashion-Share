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
                                <th scope="col">@lang('Hexcolor')</th>
                                <th scope="col">@lang('color')</th>
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($colors as $item)
                                <tr>
                                    <td data-label="@lang('Name')">{{__($item->name)}}</td>
                                    <td data-label="@lang('Hexcolor')">{{@__($item->Hexcolor)}}</td>
                                    <td data-label="@lang('color')">
                                        @if($item->Hexcolor) <div  
                                        style="
                                            margin:auto;
                                             appearance: auto;
                                             inline-size: 150px;
                                             block-size: 27px;
                                             box-sizing: border-box;
                                             background-color: {{@__($item->Hexcolor)}};
                                             color: buttontext;
                                             border-width: 1px;
                                             border-style: solid;
                                             border-color: buttonborder;
                                             border-image: initial;
                                             padding: 1px 2px;
                                        ">  </div> 
                                        @endif                                
                                        </td>
                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)" class="icon-btn ml-1 editBtn"
                                           data-original-title="@lang('Edit')" data-toggle="tooltip"
                                           data-url="{{ route('admin.color.update',$item->id)}}"
                                           data-name="{{ $item->name }}"
                                           data-hexcolor = "{{ $item->Hexcolor }}"
                                           data-field="{{$item->field_name}}">
                                            <i class="la la-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           class="icon-btn btn--danger ml-1 statusBtn"
                                           data-original-title="@lang('Status')" data-toggle="tooltip"
                                           data-url="{{ route('admin.color.delete', $item->id) }}">
                                            <i class="la la-eye-slash"></i>
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
            </div><!-- card end -->
        </div>
    </div>



    {{-- NEW MODAL --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i
                            class="fa fa-share-square"></i> @lang('Add Color')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.color.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name" required
                                       placeholder="@lang('Enter Color name')">
                            </div>

                            <br><br><br><br>
                            
                            <label class="font-weight-bold ">@lang('Hexcolor') <span
                                class="text-danger">*</span></label>
                            <div class="col-sm-2">
                                <input type="color" id="Hexcolor" name="Hexcolor" value="#000000" required
                                       placeholder="@lang('Enter Color Hexa')" style="
                                           appearance: auto;
                                            inline-size: 150px;
                                            block-size: 27px;
                                            cursor: default;
                                            box-sizing: border-box;
                                            background-color: buttonface;
                                            color: buttontext;
                                            border-width: 1px;
                                            border-style: solid;
                                            border-color: buttonborder;
                                            border-image: initial;
                                            padding: 1px 2px;
                                       ">
                            
                                <br>
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
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i
                            class="fa fa-fw fa-share-square"></i>@lang('Edit')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name"
                                       value="{{$item->name ?? ''}}" required>
                            </div>

                            <br><br><br><br>
                            
                            <label class="font-weight-bold ">@lang('Hexcolor') <span
                                class="text-danger">*</span></label>
                            <div class="col-sm-2">
                                <input type="color" id="Hexcolor" name="Hexcolor" value="{{$item->Hexcolor}}"
                                style="
                                appearance: auto;
                                 inline-size: 150px;
                                 block-size: 27px;
                                 cursor: default;
                                 box-sizing: border-box;
                                 background-color: buttonface;
                                 color: buttontext;
                                 border-width: 1px;
                                 border-style: solid;
                                 border-color: buttonborder;
                                 border-image: initial;
                                 padding: 1px 2px;
                            ">
                            
                                <br>
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
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Update Status')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="delete_id" id="delete_id" class="delete_id" value="0">
                    <div class="modal-body">
                        <p class="text-muted">@lang('Are you sure to delete?')</p>
                    </div>
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
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" data-toggle="modal" data-target="#myModal"><i
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
                var Hexcolor = $(this).data('hexcolor');

                console.log(Hexcolor);

                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=Hexcolor]').val(Hexcolor);
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
