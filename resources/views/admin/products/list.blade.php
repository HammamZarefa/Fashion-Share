@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            {{-- <div>   <span    class="text--medium badge font-weight-normal badge--success">@lang('Available')</span>            </div> --}}

            {{-- <div>   <span    class="text--medium badge font-weight-normal badge--success">@lang('Available')</span>            </div> --}}
                
           

            <div class="card">
                
                <div class="card-body">
                    <form action="{{route('admin.services.create')}}" method=" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-success btn-lg">add new product</button>
                    </form>   
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('ID')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('User')</th>
                                <th scope="col">@lang('Category')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Branch')</th>
                                <th scope="col">@lang('Sale?')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                                <th></th>


                            </tr>
                            </thead>
                            <tbody>
                            @forelse($services as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>
                                        <span class="name">{{__($item->name)}}</span>
                                    </td>
                                    <td data-label="@lang('User')">
                                        <span class="name">{{__(@$item->user->email)}}</span>
                                    </td>
                                    <td>{{$item->categories[0]->name}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->branch->name}}</td>
                                    <td>{{$item->is_for_sale ? 'Sale' : 'Rent'}}</td>
                                    <td data-label="@lang('Status')">
                                        @if($item->status=='available' )
                                            <span    class="text--small badge font-weight-normal badge--success">@lang('Available')</span>
                                        @elseif($item->status=='not_available')
                                            <span
                                                class="text--small badge font-weight-normal badge--warning">@lang('Not available')</span>
                                        @elseif($item->status=='sale')
                                            <span
                                                class="text--small badge font-weight-normal badge--primary">{{$item->status}}</span>
                                        @elseif($item->status=='rejected')
                                            <span
                                                class="text--small badge font-weight-normal badge--danger">{{$item->status}}</span>
                                          
                                        @else
                                            <span    class="text--small badge font-weight-normal badge--dark">{{$item->status}}</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.services.edite', $item->id) }}"
                                           class="icon-btn editGatewayBtn" data-toggle="tooltip" title="@lang('Edit')"
                                           data-original-title="@lang('Edit')">
                                            <i class="la la-pencil"></i>
                                        </a>

                                        <a href="javascript:void(0)" class="icon-btn bg--dark ml-1 editBtn"
                                        data-original-title="@lang('Status')" data-toggle="tooltip"
                                        data-url="{{ route('admin.services.update',$item->id)}}"
                                        data-name="{{ $item->name }}"
                                        data-field="{{$item->field_name}}">
                                        <i class="la la-edit"></i>

                                     </a>
                                           
                                        
                                 
                                        <a href="javascript:void(0)" class="icon-btn bg--info ml-1 showDetails"
                                        data-original-title="@lang('Show')" data-toggle="tooltip"
                                        data-name="{{ $item->name }}"
                                        data-user="{{$item->user}}"
                                        data-branch="{{ $item->branch->name}}"
                                        data-category="{{$item->categories[0]->name}}"
                                        data-price="{{$item->price}}"
                                        data-is_for_sale="{{$item->is_for_sale ? 'Sale' : 'Rent'}}"
                                        data-status="{{$item->status}}"
                                        data-color="{{$item->color->name}}"
                                        data-images="{{ $item->images }}"
                                        data-condition="{{$item->condition->name}}"
                                        data-material="{{$item->material->name}}"
                                        data-size="{{$item->size->name}}"
                                        data-description="{{$item->description}}"
                                        data-location = "{{$item->locaton}}"
                                        data-sections = "{{$item->section->name}}"

                                        data-field="{{$item->field_name}}">
                                        <i class="la la-eye"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="icon-btn bg--warning ml-1 SaleOrRentBtn"
                                        data-original-title="$" data-toggle="tooltip"
                                        data-url="{{ route('admin.services.SaleOrRent',$item->id)}}"
                                        data-is_for_sale="{{ $item->is_for_sale }}">
                                        <i class="la la-usd"></i>
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

                    
    <!-- a Tag for previous page -->
                    </div>
                    
                </div>
                
                <div class="" style="margin:auto; margin-bottom: 20px">
                    {!! $services->links("pagination::bootstrap-4") !!}
                </div> 
            </div><!-- card end -->
            
        </div>
        
    </div>



    {{-- ACTIVATE METHOD MODAL --}}
    <div id="SaleOrRent" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                            @lang('Payment Method Activation Confirmation')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="GET">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to Sale/Rent') <span
                                class="font-weight-bold method-name"></span> @lang('Product')?
                        </p>
                        
                       

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Activate')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Payment Method Disable Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span
                                class="font-weight-bold method-name"></span> @lang('method')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Disable')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



     {{-- DEACTIVATE METHOD MODAL --}}
     <div id="changeStatusProduct" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Change Status Product')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body" style="text-align: center">
                        <p>@lang('Are you sure to change status?') <span
                                class="font-weight-bold method-name"></span> @lang('method')?</p>
                            <select name="status">

                                    <option style="background: #ffffff">    
                                        <span    >@lang('Available')</span>
                                    </option>

                                    <option  style="background: #ffffff">    
                                        <span    >@lang('Not available')</span>
                                    </option>
                                    <option  style="background: #ffffff">
                                        <span    >@lang('rent')</span>
                                    </option>
                                    <option  style="background: #ffffff">
                                        <span    >@lang('sale')</span>
                                    </option>
                                    <option  style="background: #ffffff">
                                        <span    >@lang('rejected')</span>
                                    </option>
                                </select>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Change')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



     {{-- DEACTIVATE METHOD MODAL --}}
     <div id="showDetailsProducts" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

              
                    <div class="modal-body">
                        
                                {{--  name --}}
                                  <div class="form-row">
                 
                                    <div class="col mb-2">
                                    <label for="validationCustom01">@lang('Name')</label>
                                    <input disabled type="text" id="name" name="name" class="form-control" id="validationCustom01" >
                                   
                                  </div>
            
                                  {{-- Branch --}}
                                  <div class="col mb-3">
                                    <label for="validationCustom05">@lang('Branch')</label>
                                    <input  disabled type="text" id="user" name="branch" class="form-control" id="validationCustom01">
                                   
                                  </div>
            
                        <div class="w-100"></div>
            
                                  {{-- Price --}}
                                <div class="col mb-3">
                                    <label for="validationCustomUsername">@lang('Price')</label>
                                      <input disabled type="text" name="price" class="form-control" id="validationCustomUsername">
                                      
                                </div>
            
                                  {{-- Color --}}
                                <div class="col mb-3">
                                      <label for="validationCustom03">@lang('Color')</label>
                                      <input disabled type="text" name="color" class="form-control" id="validationCustomUsername"  >
                                 
                                </div>
            
                        <div class="w-100"></div>
                                     {{-- status --}}
                                     <div class="col mb-3 ">
                                        <label for="validationCustom05">@lang('Status')</label>
                                        <input disabled type="text" name="status" class="form-control" id="validationCustom05" >
      
                                        <div class="invalid-feedback">Example invalid custom select feedback</div>
                  
                                       
                                      </div>
                               

                                    {{-- Condition --}}
                                    <div class="col mb-3">
                                      <label for="validationCustom05">@lang('Condition')</label>
                                      <input disabled type="text" name="condition" class="form-control" id="validationCustomUsername"  >

                                  </div>
              
                        <div class="w-100"></div>
            
                                  {{-- Material --}}
                                  <div class="col mb-3">
                                      <label for="validationCustom05">@lang('Material')</label>
                                     <input disabled type="text" name="material" class="form-control" id="validationCustomUsername" >

                                  </div>
              
                                   {{-- Sale --}}
                                   <div class="col mb-3 ">
                                     <label for="validationCustom05">@lang('Sale?')</label>
                                    <input name="is_for_sale" disabled type="text" class="form-control" id="validationCustom05"  >

                                  </div>
              
                        <div class="w-100"></div>
                                 
                                  {{-- Description --}}
                                  <div class="col mb-3">
                                    <label for="validationCustom02">@lang('Description')</label>
                                    <textarea disabled type="textarea"  name="description" class="form-control" id="validationCustom02"   aria-describedby="inputGroupPrepend"></textarea>
                                   
                                  </div>
                                  
                                  {{-- Location --}}
                                  <div class="col mb-3">
                                      <label for="validationCustom05">@lang('Location')</label>
                                      <textarea disabled type="text" class="form-control" id="validationCustom05"  ></textarea>
                                     
                                  </div>
              
                                
            
                          
                                 
            
                        <div class="w-100"></div>
                                  
                        {{-- Section --}}
                              <div class="col mb-3">
                                <label for="validationCustom05">@lang('Section')</label>
                                <input disabled type="text" name="section" class="form-control" id="validationCustomUsername">

                            </div>
                                {{-- Categories --}}
                                <div class="col mb-3">
                                    <label for="validationCustom05">@lang('Categories')</label>
                                    <input disabled type="text" name="category" class="form-control" id="validationCustom05" >

                                </div>

                                   {{-- Size --}}
                                   <div class="col mb-3">
                                    <label for="validationCustom04">@lang('Size')</label>
                                    <input disabled type="text" name="size" class="form-control" id="validationCustomUsername" >
                                   
                                  </div>
                                  
                                
                     </div>
                     <div class="carousel-inner py-4">
                        <!-- Single item -->
                        <div class="carousel-item active">
                          <div class="container">
                            <div class="row" id="imageContainer">

                               
                              {{-- @foreach($item->images as $img)

                              <div class="col-lg-4">
                              
                                <div class="card">
                                  <img src="{{ asset('storage/images/'.$img->path) }}" class="card-img-top" alt="Waterfall" />
                                </div>

                              </div>
                              @endforeach --}}
                           
                            </div>
                          </div>
                        </div>
                      
                      
                      </div>
                    </div>
                   
            </div>
        </div>
    </div>

    
@endsection


@push('breadcrumb-plugins')
    {{-- <a class="btn btn-sm btn--primary box--shadow1 text--small" href="{{ route('admin.gateway.manual.create') }}"><i
            class="fa fa-fw fa-plus"></i>@lang('Add New')</a> --}}
@endpush
@push('script')
    <script>

        $(function () {
            "use strict";

            $('.SaleOrRentBtn').on('click', function () {
                // var modal = $('#SaleOrRent');
                // var url = $(this).data('url');
                // modal.find('.method-name').text($(this).data('name'));

                var modal = $('#SaleOrRent');
                var url = $(this).data('url');
                var name = $(this).data('name');
                var is_for_sale = $(this).data('is_for_sale');
                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);

                modal.modal('show');
            });
            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code]').val($(this).data('code'));
            });
            $('.statusBtn').on('click', function () {
                var modal = $('#changeStatusProduct');
                var url = $(this).data('url');

                modal.find('form').attr('action', url);
                modal.modal('show');
            });
            $('.editBtn').on('click', function () {
                var modal = $('#changeStatusProduct');
                var url = $(this).data('url');
                var name = $(this).data('name');
                var price = $(this).data('price');
                var user = $(this).data('user');
                var branch = $(this).data('branch');

                modal.find('form').attr('action', url);
                modal.find('input[name=name]').val(name);
                modal.modal('show');
            });
            $('.showDetails').on('click', function () {
                var modal = $('#showDetailsProducts');

                var name = $(this).data('name');
                modal.find('input[name=name]').val(name);

                var user = $(this).data('user');
                modal.find('input[name=user]').val(user);
                
                var price = $(this).data('price');
                modal.find('input[name=price]').val(price);
                
                var branch = $(this).data('branch');
                modal.find('input[name=branch]').val(branch);

                var color = $(this).data('color');
                modal.find('input[name=color]').val(color);

                var category = $(this).data('category');
                modal.find('input[name=category]').val(category);

                var is_for_sale = $(this).data('is_for_sale');
                modal.find('input[name=is_for_sale]').val(is_for_sale);

                var condition = $(this).data('condition');
                modal.find('input[name=condition]').val(condition);

                var material  = $(this).data('material');
                modal.find('input[name=material]').val(material);

                var size  = $(this).data('size');
                modal.find('input[name=size]').val(size);

                var description = $(this).data('description');
                modal.find('input[name=description]').val(description);

                var location = $(this).data('location');
                modal.find('input[name=location]').val(location);

                var sections = $(this).data('sections');
                console.log(sections);

                modal.find('input[name=section]').val(sections);

                var status = $(this).data('status');
                modal.find('input[name=status]').val(status);

                var images = $(this).data('images');
                modal.find('input[name=images]').val(images);

                var container = document.getElementById('imageContainer');
                var keys = [];
                for (var i = 0, j = images.length; i < j; i++) {
                    
                    var col_lg_4 = document.createElement('div');
                    col_lg_4.className ='col-lg-4';

                    var card = document.createElement('div');
                    card.className ='card';
                    
                    container.appendChild(col_lg_4);    
                    col_lg_4.appendChild(card);

                    var img = document.createElement('img');
                    img.className="card-img-top"; 
                    img.alt="Waterfall";
                    
                    for (var key in images[i]) {
                        if (images[0].hasOwnProperty(key)) 
                        {
                            if(key == "path")
                            {
                            var path="{{ getImage(imagePath()['service']['path'].'/',imagePath()['service']['size'])}}";
                            // var path= "{{asset('storage/')}}";
                            img.src = path +'/'+ images[i][key];                                                    
                            card.appendChild(img);

                        }   
                        }
                    }
                };                
                modal.modal('show');
            });
        });

    </script>
@endpush
