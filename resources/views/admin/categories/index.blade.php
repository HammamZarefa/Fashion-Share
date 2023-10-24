@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div >

                <div class="card-body col-4">
       

                    <select class="custom-select" name="branch" onchange="window.location.href=this.options[this.selectedIndex].value;">
                        <option selected value=" {{ route('admin.categories.index') }}">
                                                            
                            All
                        </option>
                        @foreach($sections as $section)
                        <option  {{@$id == $section->id ? 'selected' : ''}} value=" {{ route('admin.categories.search',$section->id) }}">
                           
                            {{ $section->name }}
                        </option>
                     @endforeach
                    </select>
                
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Section')</th>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($categories as $item)
                                <tr>
                                    <td data-label="@lang('Name')">{{__($item->name)}}</td>
                                    <td data-label="@lang('Name')">{{$item->section->name ?? ''}}</td>
                                    <td data-label="@lang('Image')"><img src="{{ getImage(imagePath()['category']['path'].'/'. $item->image,imagePath()['category']['size'])}}"></td>
                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)" class="icon-btn ml-1 editBtn"
                                           data-original-title="@lang('Edit')" data-toggle="tooltip"
                                           data-url="{{ route('admin.categories.update', $item->id)}}"
                                           data-name="{{ $item->name }}"
                                           data-section="{{$item->section->id ?? ''}}"
                                           data-field="{{$item->field_name}}" >
                                            <i class="la la-edit"></i>
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
                                class="fa fa-share-square"></i> @lang('Add New Category')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.categories.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                        class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name" required placeholder="@lang('Enter category name')">
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Section') <span
                                        class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="section_id" value="" class="form-control selectpicker"  data-live-search="true">
                                    <option selected disabled>Select Section</option>
                                    @foreach($sections as $section)
                                       <option value="{{$section->id}}" >{{ $section->name }}</option>
                                    @endforeach
                                 </select>                            </div>
                        </div>


                        <div class="avatar-edit">
                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                            <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
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
                    <h4 class="modal-title" id="myModalLabel"><i
                                class="fa fa-fw fa-share-square"></i>@lang('Edit')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
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
                            <label class="font-weight-bold ">@lang('Name') <span
                                        class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="section_id" value="" class="form-control selectpicker"  data-live-search="true">
                                    {{-- <option selected disabled>Select Section</option> --}}

                                    @if(!$categories->isEmpty())
                                    @foreach($sections as $section)
                                       <option value="{{$section->id}}" {{ $item->section_id == $section->id ? "selected" :""}}>{{ $section->name }}</option>
                                    @endforeach
                                    @endif
                                 </select>                            </div>
                        </div>


                        <div class="avatar-edit">
                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                            <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
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
                    <h4 class="modal-title" id="myModalLabel">@lang('Update Status')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="">
                    @csrf
                    <input type="hidden" name="delete_id" id="delete_id" class="delete_id" value="0">
                    <div class="modal-body">
                        <p class="text-muted">@lang('Are you sure to change the status?')</p>
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
                var section =$(this).data('section');

                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                modal.find('select[name=section_id]').val(section);
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
