@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('User Name')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Branch')</th>
                                <th scope="col">@lang('Action')</th>

                                {{-- <th scope="col">@lang('Phone')</th>
                                <th scope="col">@lang('Joined At')</th>
                                <th scope="col">@lang('Action')</th> --}}
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                            <tr>

                                {{-- <td data-label="@lang('Username')"><a href="{{ route('admin.users.detail', $user->id) }}">{{ $user->username }}</a></td> --}}
                                <td data-label="@lang('Image')">
                                    <div class="user">
                                        <div class="thumb">
                                            <img src="{{ getImage(imagePath()['profile']['admin']['path'].'/'.$user->image,imagePath()['profile']['admin']['size'])}}" alt="@lang('image')">
                                        </div>
                                        <span class="name">{{$user->fullname}}</span>
                                    </div>
                                </td>
                                <td data-label="@lang('Name')">{{ $user->name }}</td>
                                <td data-label="@lang('User Name')">{{ $user->username }}</td>
                                <td data-label="@lang('Email')">{{ $user->email }}</td>
                                <td data-label="@lang('Branch')">{{ $user->branch->name }}</td>
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)" class="icon-btn ml-1 editBtn"
                                       data-original-title="@lang('Edit')" data-toggle="tooltip"
                                       data-url="{{ route('admin.users.update', $user->id)}}"
                                       data-name="{{ $user->name }}"
                                       data-branch="{{$user->branch->id ?? ''}}"
                                       data-username="{{$user->username}}"
                                       data-email="{{$user->email}}"
                                       data-password="{{$user->password}}"
                                       data-mobile="{{$user->mobile}}"
                                    >
                                        <i class="la la-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                       class="icon-btn btn--danger ml-1 statusBtn"
                                       data-original-title="@lang('Status')" data-toggle="tooltip"
                                       data-url="{{ route('admin.users.delete', $user->id ) }}">
                                        <i class="la la-eye-slash"></i>
                                    </a>
                                </td>

                                {{-- <td data-label="@lang('Joined At')">{{ showDateTime($user->created_at) }}</td> --}}
{{--                                 <td data-label="@lang('Action')">--}}
{{--                                     <a href="{{ route('admin.users.detail', $user->id) }}" class="icon-btn" data-toggle="tooltip" title="" data-original-title="@lang('Details')">--}}
{{--                                         <i class="las la-desktop text--shadow"></i>--}}
{{--                                     </a>--}}
{{--                                 </td>--}}
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
                <div class="card-footer py-4">
                    {{ paginateLinks($users) }}
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
                        @lang('Add New User')</h4>
                    <button type="button" class="close" data-dismiss="modal" style="margin: -1rem -1rem -1rem 0rem"1 aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.users.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="avatar-edit">
                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1"
                                   accept=".png, .jpg, .jpeg">
                            <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                        </div>
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name" required placeholder="@lang('Enter User Name')">
                            </div>
                        </div>
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('User name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="username" name="username" required placeholder="@lang('Enter User Username')">
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
                            <label class="font-weight-bold ">@lang('Password') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control has-error bold " id="password" name="password" required placeholder="@lang('Enter User Password')">
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
                            <label class="font-weight-bold ">@lang('Branch') </label>
                            <div class="col-sm-12">
                                <select name="branch_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                                    <option value="-1" selected>@lang('Choose One!')</option>
                                    @foreach($branches as $branche)
                                        <option value="{{$branche->id}}" >{{ $branche->name }}</option>
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
                        <div class="avatar-edit">
                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1"
                                   accept=".png, .jpg, .jpeg">
                            <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                        </div>
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name" value="{{$item->name ?? ''}}" required>
                            </div>
                        </div>
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('User name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="username" value="{{$item->username ?? ''}}" name="username" required placeholder="@lang('Enter User Username')">
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
                            <label class="font-weight-bold ">@lang('Password') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control has-error bold " id="password" name="password"  value="{{$item->password ?? ''}}" required placeholder="@lang('Enter User Password')">
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
                            <label class="font-weight-bold ">@lang('Branch') </label>
                            <div class="col-sm-12">
                                <select name="branch_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                                    <option value="-1" selected>@lang('Choose One!')</option>
                                    @foreach($branches as $branche)
                                        <option value="{{$branche->id}}" >{{ $branche->name }}</option>
                                    @endforeach
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
                var username = $(this).data('username');
                var email = $(this).data('email');
                var mobile = $(this).data('mobile');
                var branch = $(this).data('branch');
                var password = $(this).data('password');
console.log(username);
                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=username]').val(username);
                modal.find('input[name=email]').val(email);
                modal.find('input[name=password]').val(password);
                modal.find('input[name=mobile]').val(mobile);
                modal.find('select[name=branch_id]').val(branch);
                modal.modal('show');
            });

            $('.statusBtn').on('click', function () {
                var modal = $('#statusModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });

            $('.addBtn').on('click', function () {
                var modal = $('#addCatModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
