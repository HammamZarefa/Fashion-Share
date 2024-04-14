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
                                <th scope="col">@lang('ID')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Code')</th>
                                <th scope="col">@lang('Address')</th>
                                <th scope="col">@lang('Mobile')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($branch as $item)
                                <tr>
                                    <td data-label="@lang('ID')">{{__($item->id)}}</td>
                                    <td data-label="@lang('Name')">{{__($item->name)}}</td>
                                    <td data-label="@lang('Admin')">{{__($item->code)}}</td>
                                    <td data-label="@lang('Address')">{{__($item->address)}}</td>
                                    <td data-label="@lang('latitude')">{{__($item->mobile)}}</td>

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.branch.edit',$item->id)}}" class="icon-btn ml-1"
                                           data-original-title="@lang('Edit')" data-toggle="tooltip"
                                           {{-- data-url="{{ route('admin.branch.update',$item->id)}}" --}}
                                           {{-- data-name="{{ $item->name }}" --}}
                                           {{-- data-address="{{$item->address}}" --}}
                                           {{-- data-latitude="{{$item->latitude}}" --}}
                                           {{-- data-longitude="{{$item->longitude}}" --}}

                                           >
                                            <i class="la la-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.branch.show',$item->id)}}" class="icon-btn ml-1"
                                           data-original-title="@lang('Show')" data-toggle="tooltip">
                                            <i class="la la-eye"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           class="icon-btn btn--danger ml-1 statusBtn"
                                           data-original-title="@lang('Status')" data-toggle="tooltip"
                                           data-url="{{ route('admin.branch.delete', $item->id ) }}">
                                            <i class="la la-eye-slash"></i>
                                        </a>
                                        <a href="{{ route('admin.branch.dashboard',$item->id)}}" class="icon-btn ml-1"
                                           data-original-title="@lang('Login As Branch Admin')" data-toggle="tooltip">
                                            <i class="la la-store"></i>
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
        <div class="modal-dialog" style="max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">
                        @lang('Add New branch')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.branch.store')}}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Name') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="code" name="name"
                                                   placeholder="@lang('Enter branch name')">
                                        </div>
                                    </div>


                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('phone') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="code" name="phone" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Mobile') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="mobile" name="mobile" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Facebook') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="facebook" name="facebook" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('latitude') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="latitude" name="latitude" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('longitude') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="longitude" name="longitude" >
                                        </div>
                                    </div>

                                    <div id="map" style="height: 200px;"></div>



                                </div>
                                <div class="col-md-6">

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Code') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="code" name="code" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Address') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="code" name="address" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Whatsapp') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="whatsapp" name="whatsapp" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Instagram') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="instagram" name="instagram" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Twitter') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="twitter" name="twitter" >
                                        </div>
                                    </div>



                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('working_hours') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="code" name="working_hours" >
                                        </div>
                                    </div>





                                </div>
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


    {{-- Status MODAL --}}
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('Are you sure to Delete?')</h4>
                    <button type="button" class="close"  style="margin: -1rem -1rem -1rem 0rem" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                var address = $(this).data('address');
                var longitude = $(this).data('longitude');
                var latitude = $(this).data('latitude');

                console.log(longitude);
                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=location]').val(location);

                // document.getElementById('maps_google').src="https://maps.google.com/maps?width=500&height=500&hl=en&q="+longitude+", "+latitude+"&t=&z=14&ie=UTF8&iwloc=B&output=embed";




                modal.modal('show');
            });

            $('.statusBtn').on('click', function () {
                var modal = $('#statusModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        })(jQuery);


        $( "#myModal" ).on('shown.bs.modal', function(){
            var map = new ol.Map({
                target: 'map',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    })
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([36.650390625, 33.4314413355753]), // Initial map center coordinates
                    zoom: 10 // Initial zoom level
                }),
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                        anchor: [0.5, 1],
                        src: 'marker.png'
                    })
                })
            });

            // Event handler for clicking on the map
            map.on('click', function(event) {
                var coordinates = ol.proj.toLonLat(event.coordinate);
                document.getElementById('latitude').value=coordinates[0];
                document.getElementById('longitude').value=coordinates[1];
                console.log(coordinates[0]);
            });
        });











    </script>
@endpush
