@extends('admin.layouts.app')
@section('panel')

    <div class="" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style="max-width: 70%;">
            <div class="modal-content">
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
                                                   value="{{$item->name ?? ''}}" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('phone')</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="code" name="phone"
                                                   value="{{$item->phone ?? ''}}" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Mobile') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="mobile" name="mobile"
                                                   value="{{$item->mobile ?? ''}}" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Facebook') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="facebook" name="facebook"
                                                   value="{{json_decode($item->social)->facebook ?? ''}}" >
                                        </div>
                                    </div>
                                    <div class="form-row form-group">



                                        <label class="font-weight-bold ">@lang('latitude') </label>

                                        <div class="col-sm-12" >
                                            <input type="text" id="latitude" class="form-control has-error bold " id="code" name="latitude"
                                                   value="{{$item->latitude ?? ''}}" >
                                        </div>


                                        <label class="font-weight-bold ">@lang('longitude') </label>

                                        <div class="col-sm-12">
                                            <input type="text" id="longitude" class="form-control has-error bold " id="code" name="longitude"
                                                   value="{{$item->longitude ?? ''}}" >
                                        </div>


                                        <br><br>




                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Code') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="code" name="code"
                                                   value="{{$item->code ?? ''}}"    >
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
                                        <label class="font-weight-bold ">@lang('whatsapp') <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="code" name="whatsapp"
                                                   value="{{$item->whatsapp ?? ''}}" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Instagram') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="instagram" name="instagram"
                                                   value="{{json_decode($item->social)->instagram ?? ''}}" >
                                        </div>
                                    </div>

                                    <div class="form-row form-group">
                                        <label class="font-weight-bold ">@lang('Twitter') </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="twitter" name="twitter"
                                                   value="{{json_decode($item->social)->twitter ?? ''}}" >
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
                                </div>
                                <div class="col-md-12">

                                    <div id="map" style="height: 200px"></div>

                                </div>
                            </div>
                        </div>


                    </div>


                        <div class="modal-footer">

                            <a href="{{ route('admin.branch.dashboard',$item->id)}}" class="icon-btn ml-1"
                               data-original-title="@lang('Login As Branch Admin')" data-toggle="tooltip">
                                @lang('Login As Branch Admin')
                            </a>
                        </div>

                    </div>
            </div>
        </div>
    </div>


@endsection


@push('script')
    <script>


        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([{{$item->latitude}}, {{$item->longitude}}]), // Initial map center coordinates
                zoom: 10 // Initial zoom level
            })
        });

        // Event handler for clicking on the map
        map.on('click', function(event) {
            var coordinates = ol.proj.toLonLat(event.coordinate);
            document.getElementById('latitude').value=coordinates[0];
            document.getElementById('longitude').value=coordinates[1];
            console.log(coordinates[0]);
        });








    </script>
@endpush
