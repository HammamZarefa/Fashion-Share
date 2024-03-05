@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="row">
                    <div class="card-body col-4">


                        <label class="card-title float-right">@lang('Section')</label>
                        <select class="custom-select" name="section"
                                onmouseup="filterCategoriesBySectionFilter(this.value)" id="sections_filter">
                            <option selected value="0">

                                All
                            </option>
                            @foreach($sections as $section)
                                <option
                                    {{@$id == $section->id ? 'selected' : ''}} value="{{$section->id}}">

                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="card-body col-4">
                        <label class="card-title float-right">@lang('Category')</label>

                        <select class="custom-select" name="branch" id="categories_filter"
                                onchange="window.location.href=this.options[this.selectedIndex].value;">
                            <option selected value=" {{ route('admin.size.index') }}">

                                All
                            </option>
                            @foreach($categories as $category)
                                <option
                                    {{@$id == $category->id ? 'selected' : ''}} value="{{ route('admin.sizes.search',$category->id) }}">

                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Categories')</th>
                                 <th scope="col">@lang('Section')</th>
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($styles as $item)
                                <tr>
                                    <td data-label="@lang('Name')">{{__($item->name)}}</td>
                                    <td data-label="@lang('Categories')">{{__($item->category->name ?? '')}}</td>
                                    <td data-label="@lang('Section')">{{__($item->section->name ?? '')}}</td>
                                    <td data-label="@lang('Action')">
                                        @if(!Auth::guard('admin')->user()->branch )
                                        <a href="javascript:void(0)" class="icon-btn ml-1 editBtn"
                                           data-original-title="@lang('Edit')" data-toggle="tooltip"
                                           data-url="{{ route('admin.styles.update', $item->id)}}" data-name="{{ $item->name }}"
                                           data-field="{{$item->field_name}}" >
                                            <i class="la la-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                           class="icon-btn btn--danger ml-1 statusBtn"
                                           data-original-title="@lang('Status')" data-toggle="tooltip"
                                           data-url="{{ route('admin.styles.delete', $item->id) }}">
                                            <i class="la la-eye-slash"></i>
                                        </a>
                                        @else
                                            <a href="javascript:void(0)"
                                               class="icon-btn {{Auth::guard('admin')->user()->branch->styles()->where('branchable_id', $item->id)->exists() ? "btn--danger" :"btn--success"}} ml-1 addBtn"
{{--                                               data-original-title="@lang('Add Or Remove Style From Branch')" data-toggle="tooltip"--}}
                                               data-url="{{ route('admin.styles.add', $item->id ) }}">
                                                <i class="la {{Auth::guard('admin')->user()->branch->styles()->where('branchable_id', $item->id)->exists() ? "la-trash" :"la-check"}}"></i>
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
                         @lang('Add New style')</h4>
                    <button type="button" class="close" data-dismiss="modal" style="margin: -1rem -1rem -1rem 0rem"1 aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.styles.store')}}" enctype="multipart/form-data">
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
                                <select onmouseup="filterCategoriesBySection(this.value)" id="sections" name="section_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                                    @foreach($sections as $section)
                                        <option value="{{$section->id}}" >{{ $section->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Categories') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select id="categories"  name="category_id"
                                        class="form-control selectpicker" data-live-search="true">
                                    {{--                                            <option disabled selected>@lang('Choose Section First')</option>--}}
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" data-id="{{$category->section_id}}"
                                                @if($sections[0]->id != $category->section_id)  disabled @endif>{{ $category->name  }}</option>
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
                            <label class="font-weight-bold ">@lang('Section') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select name="section_id" onmouseup="filterCategoriesBySectionEdit(this.value)" id="sections_edit" value="" class="form-control selectpicker"  data-live-search="true">
                                    {{-- <option selected disabled>Select Section</option> --}}
                                    @if(!$styles->isEmpty())

                                        @foreach($sections as $section)
                                            <option value="{{$section->id}}" {{ $item->section_id == $section->id ? "selected" :""}}>{{ $section->name }}</option>
                                        @endforeach
                                    @endif
                                </select>                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Category') <span
                                        class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <select id="categories_edit" name="category_id" value="" class="form-control selectpicker"  data-live-search="true">
                                    {{-- <option selected disabled>Select Section</option> --}}
                                    @if(!$styles->isEmpty())

                                    @foreach($categories as $category)
                                       <option @if($sections[0]->id != $category->section_id)  disabled @endif  data-id="{{$category->section_id}}" value="{{$category->id}}" {{ $item->category->id == $category->id ? "selected" :""}}>{{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                 </select>                            </div>
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

    {{-- Add MODAL --}}
    <div class="modal fade" id="addStyleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Are you sure to Add This Category To Your Branch?')</h4>
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
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" data-toggle="modal" data-target="#myModal"><i
                class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
@endif

@push('script')
    <script>
        document.getElementById("sections").addEventListener("mouseup", function() {
            filterCategoriesBySection(this.value);
        });

        function filterCategoriesBySection(sectionId) {
            var categoriesSelect = document.getElementById("categories");
            categoriesSelect.disabled = false;
            categoriesSelect.innerHTML = "";

            var categories = {!! json_encode($categories) !!};
            var filteredCategories = categories.filter(function(category) {
                return category.section_id == sectionId;
            });

            filteredCategories.forEach(function(category,index) {
                var option = document.createElement("option");
                option.value = category.id;
                option.text = category.name;
                categoriesSelect.appendChild(option);


            });
        }

        document.getElementById("sections_edit").addEventListener("mouseup", function() {
            filterCategoriesBySectionEdit(this.value);
        });

        function filterCategoriesBySectionEdit(sectionId) {
            var categoriesSelect = document.getElementById("categories_edit");
            categoriesSelect.disabled = false;
            categoriesSelect.innerHTML = "";

            var categories = {!! json_encode($categories) !!};
            var filteredCategories = categories.filter(function(category) {
                return category.section_id == sectionId;
            });

            filteredCategories.forEach(function(category,index) {
                var option = document.createElement("option");
                option.value = category.id;
                option.text = category.name;
                categoriesSelect.appendChild(option);


            });
        }

        document.getElementById("sections_filter").addEventListener("mouseup", function () {
            filterCategoriesBySectionFilter(this.value);
        });

        function filterCategoriesBySectionFilter(sectionId) {
            var categoriesSelect = document.getElementById("categories_filter");
            categoriesSelect.disabled = false;
            console.log(sectionId)
            if (sectionId != "0"){
                categoriesSelect.innerHTML = "";

                var categories = {!! json_encode($categories) !!};
                var filteredCategories = categories.filter(function (category) {
                    return category.section_id == sectionId;
                });
                var option = document.createElement("option");
                option.value =  '/admin/sizes' ;
                option.text = 'All';
                categoriesSelect.appendChild(option);

                filteredCategories.forEach(function (category, index) {
                    var option = document.createElement("option");
                    option.value =  '/admin/sizeSearch/' + category.id;
                    option.text = category.name;
                    categoriesSelect.appendChild(option);


                });
            }else {
                categoriesSelect.innerHTML = "";

                var categories = {!! json_encode($categories) !!};
                var filteredCategories = categories;
                var option = document.createElement("option");
                option.value =  '/admin/sizes' ;
                option.text = 'All';
                categoriesSelect.appendChild(option);

                filteredCategories.forEach(function (category, index) {
                    var option = document.createElement("option");
                    option.value =  '/admin/sizeSearch/' + category.id;
                    option.text = category.name;
                    categoriesSelect.appendChild(option);


                });
            }

        }

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

            $('.addBtn').on('click', function () {
                var modal = $('#addStyleModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
