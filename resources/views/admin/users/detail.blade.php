@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">

            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.$user->image,imagePath()['profile']['user']['size'])}}" alt="@lang('Profile Image')" class="b-radius--10 w-100">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{$user->fullname}}</h4>
                            <span class="text--small">@lang('Joined At') <strong>{{showDateTime($user->created_at,'d M, Y h:i A')}}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('User information')</h5>
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="font-weight-bold">{{$user->username}}</span>
                        </li>


                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @switch($user->status)
                                @case(1)
                                <span class="badge badge-pill bg--success">@lang('Active')</span>
                                @break
                                @case(2)
                                <span class="badge badge-pill bg--danger">@lang('Banned')</span>
                                @break
                            @endswitch
                        </li>

                    </ul>
                </div>
            </div>
        </div>

{{--            User details--}}
            <div class="card mt-50">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{$user->fullname}} @lang('Information')</h5>

                    <form action="{{route('admin.users.update',[$user->id])}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('First Name')<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname" value="{{$user->firstname}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Last Name') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname" value="{{$user->lastname}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Email') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{$user->email}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile" value="{{$user->mobile}}">
                                </div>
                            </div>
                        </div>

                            {{--<div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">--}}
                                {{--<label class="form-control-label font-weight-bold">@lang('SMS Verification') </label>--}}
                                {{--<input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"--}}
                                       {{--data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"--}}
                                       {{--@if($user->sv) checked @endif>--}}

                            {{--</div>--}}
                            {{--<div class="form-group  col-md-6  col-sm-3 col-12">--}}
                                {{--<label class="form-control-label font-weight-bold">@lang('2FA Status') </label>--}}
                                {{--<input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"--}}
                                       {{--data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactive')" name="ts"--}}
                                       {{--@if($user->ts) checked @endif>--}}
                            {{--</div>--}}

                            {{--<div class="form-group  col-md-6  col-sm-3 col-12">--}}
                                {{--<label class="form-control-label font-weight-bold">@lang('2FA Verification') </label>--}}
                                {{--<input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"--}}
                                       {{--data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="tv"--}}
                                       {{--@if($user->tv) checked @endif>--}}
                            {{--</div>--}}
                        {{--</div>--}}


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        "use strict";
        $("select[name=country]").val("{{ @$user->address->country }}");
    </script>
@endpush
