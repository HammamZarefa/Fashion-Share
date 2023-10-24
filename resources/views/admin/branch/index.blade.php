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
                                <th scope="col">@lang('Admin')</th>
                                <th scope="col">@lang('Address')</th>
                                <th scope="col">@lang('longitude')</th>
                                <th scope="col">@lang('latitude')</th>

                                <th scope="col">@lang('working_hours')</th>
                                <th scope="col">@lang('phone')</th>
                                <th scope="col">@lang('whatsapp')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($branch as $item)
                                <tr>
                                    <td data-label="@lang('ID')">{{__($item->id)}}</td>
                                    <td data-label="@lang('Name')">{{__($item->name)}}</td>
                                    <td data-label="@lang('Admin')">{{__($item->Admin->email ?? '')}}</td>
                                    <td data-label="@lang('Adress')">{{__($item->address)}}</td>
                                    <td data-label="@lang('longitude')">{{__($item->longitude)}}</td>
                                    <td data-label="@lang('latitude')">{{__($item->latitude)}}</td>

                                    <td data-label="@lang('Name')">{{__($item->working_hours)}}</td>
                                    <td data-label="@lang('Adress')">{{__($item->phone)}}</td>
                                    <td data-label="@lang('Adress')">{{__($item->whatsapp)}}</td>

                                    <td data-label="@lang('Action')">
                                        <a href="javascript:void(0)" class="icon-btn ml-1 editBtn"
                                           data-original-title="@lang('Edit')" data-toggle="tooltip"
                                           data-url="{{ route('admin.branch.update',$item->id)}}"
                                           data-name="{{ $item->name }}"
                                           data-address="{{$item->address}}"
                                           data-latitude="{{$item->latitude}}"
                                           data-longitude="{{$item->longitude}}"

                                           >
                                            <i class="la la-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           class="icon-btn btn--danger ml-1 statusBtn"
                                           data-original-title="@lang('Status')" data-toggle="tooltip"
                                           data-url="{{ route('admin.branch.delete', $item->id ) }}">
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
                            class="fa fa-share-square"></i> @lang('Add New branch')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.branch.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name"
                                       placeholder="@lang('Enter branch name')">
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
                            <label class="font-weight-bold ">@lang('working_hours') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="working_hours" >
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('phone') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="phone" >
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('whatsapp') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="whatsapp" >
                            </div>
                        </div>



                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('longitude') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="longitude" >
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('latitude') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="latitude" >
                            </div>
                        </div>
                        <div id="map" style="height: 200px;"></div>

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
                <form method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="name"
                                       value="{{$item->name ?? ''}}" >
                            </div>
                        </div>



                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('Address') <span
                                    class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control has-error bold " id="code" name="address"
                                        value="{{$item->address ?? ''}}"    >
                                    </div>
                        </div>



                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('working_hours') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="working_hours"
                                value="{{$item->working_hours ?? ''}}" >
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('phone') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="phone"
                                value="{{$item->phone ?? ''}}" >
                            </div>
                        </div>

                        <div class="form-row form-group">
                            <label class="font-weight-bold ">@lang('whatsapp') <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="whatsapp"
                                value="{{$item->whatsapp ?? ''}}" >
                            </div>
                        </div>

                        <div class="form-row form-group">


                            <label class="font-weight-bold ">@lang('longitude') <span
                                class="text-danger">*</span></label>

                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="code" name="longitude"
                                value="{{$item->longitude ?? ''}}" >
                            </div>

                            <label class="font-weight-bold ">@lang('latitude') <span
                                class="text-danger">*</span></label>

                        <div class="col-sm-12">
                            <input type="text" class="form-control has-error bold " id="code" name="latitude"
                            value="{{$item->latitude ?? ''}}" >
                        </div>

                            <br>
                            <div class="col-sm-12">
                                <p>{{$item->location}}</p>
                                <br>
                                <div class="mapouter"><div id="gmap_canvas" class="gmap_canvas">
                                    <iframe id="maps_google" name="map"
                                    class="gmap_iframe"
                                    width="100%"
                                    frameborder="0"
                                    scrolling="no"
                                    marginheight="0"
                                    marginwidth="0"
                                    {{-- src="https://maps.google.com/maps?width=500&amp;height=500&amp;hl=en&amp;q=35.53802606238954, 35.77994740061135&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" --}}
                                    >
                                </iframe>
                                   </div>
                                    <style>.mapouter{position:relative;text-align:right;width:100%;height:300px;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;height:300px;}.gmap_iframe {height:300px!important;}</style></div>

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
                var address = $(this).data('address');
                var longitude = $(this).data('longitude');
                var latitude = $(this).data('latitude');

                console.log(longitude);
                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=location]').val(location);

                document.getElementById('maps_google').src="https://maps.google.com/maps?width=500&height=500&hl=en&q="+longitude+", "+latitude+"&t=&z=14&ie=UTF8&iwloc=B&output=embed";


                modal.modal('show');
            });

            $('.statusBtn').on('click', function () {
                var modal = $('#statusModal');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
        })(jQuery);

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
            })
        });

        // Event handler for clicking on the map
        map.on('click', function(event) {
            var coordinates = ol.proj.toLonLat(event.coordinate);
            alert("You clicked the map at " + coordinates);
            // You can handle the picked location data here
        });
    </script>
@endpush
