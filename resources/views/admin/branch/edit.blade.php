@extends('admin.layouts.app')
@section('panel')
    {{-- <div class="row">
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
    </div> --}}



   

    <div class="" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <form method="post" action="{{ route('admin.branch.update',$item->id)}}" enctype="multipart/form-data">
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


                            
                            <label class="font-weight-bold ">@lang('latitude') <span
                                class="text-danger">*</span></label>

                        <div class="col-sm-12" >
                            <input type="text" id="latitude" class="form-control has-error bold " id="code" name="latitude"
                            value="{{$item->latitude ?? ''}}" >
                        </div>


                        <label class="font-weight-bold ">@lang('longitude') <span
                            class="text-danger">*</span></label>

                        <div class="col-sm-12">
                            <input type="text" id="longitude" class="form-control has-error bold " id="code" name="longitude"
                            value="{{$item->longitude ?? ''}}" >
                        </div>


                        <br><br>
                            

                        <div class="form-row form-group">

                        <div id="map" style="height: 200px"></div>

                        </div>
                    </div>


                        <div class="modal-footer">
                           

                            <button type="button"   class="btn btn--dark" data-dismiss="modal"><a style="color: white" href="{{route('admin.branch')}}">@lang('Close')</a></button>

                            <button type="submit"  class="btn btn--primary" id="btn-save"
                            value="add">@lang('Update')</button>
                
                        </div>

                    </div>
                </form>
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
