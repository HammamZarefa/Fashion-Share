@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">

        <div class="col-lg-8">
            <div class="card">
               
             


               <form enctype="multipart/form-data" name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('admin.services.update', $services->id ) }}" style="margin: 20px">
                  @csrf  
                  <div class="form-row">
                 

                        <div class="col mb-2">
                        <label for="validationCustom01">@lang('Name')</label>
                        <input type="text" id="name" name="name" class="form-control" id="validationCustom01" placeholder="First name" value="{{__($services->name)}}" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>


                      <div class="col mb-3">
                        <label for="validationCustom05">@lang('Branch')</label>
                        <select name="branch_id" value="" class="form-control selectpicker"  data-live-search="true">
                          @foreach($branchs as $branch)
                             <option value="{{$branch->id}}" {{ $services->branch_id == $branch->id ? "selected" :""}}>{{ $branch->name }}</option>
                          @endforeach
                       </select>
                        {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services[0]->branch->name)}}" required> --}}
                        <div class="invalid-feedback">
                          Please provide a valid Branch.
                        </div>
                    </div>

                          <div class="w-100"></div>


                      <div class="col mb-3">
                        <label for="validationCustomUsername">@lang('Price')</label>
                        <div class="input-group">
                          <input type="text" name="price" class="form-control" id="validationCustomUsername" placeholder="Price" value="{{__($services->price)}}"  required>
                          <div class="invalid-feedback">
                            Please choose a Price.
                          </div>
                        </div>
                      </div>

                      
                        <div class="col mb-3">
                          <label for="validationCustom03">@lang('Color')</label>
                          
                          <select name="color_id" id="color" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Colors as $color)
                            {{-- <p>{{ old('color') }}</p>; --}}
                               <option value="{{ $color->id }}"  {{ $services->color_id == $color->id ? "selected" :""}}>{{ $color->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom03" placeholder="City" value="{{__($services[0]->color->name)}}" required> --}}
                          
                          <div class="invalid-feedback">
                            Please provide a valid Color.
                          </div>
                        </div>

                            <div class="w-100"></div>


                        <div class="col mb-3">
                          <label for="validationCustom04">@lang('Size')</label>
                          <select name="size_id" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Sizes as $size)
                               <option value="{{$size->id}}"  {{ $services->size_id == $size->id ? "selected" :""}}>{{ $size->name }}</option>
                            @endforeach
                         </select>

                          {{-- <input type="text" class="form-control" id="validationCustom04" placeholder="State" value="{{__($services[0]->size->name)}}" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Size.
                          </div>
                        </div>
                        <div class="col mb-3">
                          <label for="validationCustom05">@lang('Condition')</label>
                          
                          <select name="condition_id" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Conditions as $Condition)
                               <option value="{{$Condition->id}}" {{ $services->condition_id == $Condition->id ? "selected" :""}}>{{ $Condition->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services[0]->condition->name)}}" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Condition.
                          </div>
                      </div>
  
                          <div class="w-100"></div>

                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Material')</label>
                          <select name="material_id" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Materials as $Material)
                               <option value="{{$Material->id}}"  {{ $services->material_id == $Material->id ? "selected" :""}}>{{ $Material->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services[0]->material->name)}}" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Material.
                          </div>
                        </div>
  
                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Section')</label>
                          <select name="section_id" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Sections as $Section)
                               <option value="{{$Section->id}}" {{ $services->section_id == $Section->id ? "selected" :""}}>{{ $Section->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services[0]->section->name)}}" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Section.
                          </div>
                        </div>
  
                            <div class="w-100"></div>
                     
  
                      <div class="col mb-3">
                        <label for="validationCustom02">@lang('Description')</label>
                        <input type="text"  name="description" class="form-control" id="validationCustom02" placeholder="Description" value="{{__($services->description)}}"  aria-describedby="inputGroupPrepend" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>

                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Location')</label>
                          <input type="text" name="location" class="form-control" id="validationCustom05" placeholder="Location" value="{{__($services->location)}}" required>
                          <div class="invalid-feedback">
                            Please provide a valid Location.
                          </div>
                      </div>
  
                  <div class="w-100"></div>
                      <div class="col mb-3 ">
                          <label for="validationCustom05">@lang('Sale?')</label>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services->is_for_sale ? 'Sale' : 'Rent')}}" required> --}}
                          <select class="custom-select"  name="is_for_sale" required>
                            <option  class="text--small badge font-weight-normal badge--success"  value="Sale">@lang('Sale')</option>
                            <option  class="text--small badge font-weight-normal badge--warning"  value="Rent">@lang('Rent')</option>
                          </select>
                          <div class="invalid-feedback">
                            Please provide a valid Sale.
                          </div>
                      </div>

              

                      <div class="col mb-3">
                        <label for="validationCustom05">@lang('Categories')</label>
                        <select name="category_id" value="" class="form-control selectpicker"  data-live-search="true">
                          @foreach($Categories as $Categorie)
                             <option value="{{$Categorie->id}}" {{ $services->category_id == $Categorie->id ? "selected" :""}}>{{ $Categorie->name }}</option>
                          @endforeach
                       </select>
                        {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services[0]->section->name)}}" required> --}}
                        <div class="invalid-feedback">
                          Please provide a valid Categories.
                        </div>
                      </div>

                      <div class="w-100"></div>


                    <div class="col mb-3 ">
                      <label for="validationCustom05">@lang('Status')</label>

                      <select class="custom-select" name="status"  required>
                        <option {{ old('status') == 'available' ? "@lang('Not available')" : "" }}   value="'not_available">@lang('Not available')</option>
                        <option {{ old('status') == 'not_available' ? "@lang('Available')" : "" }}    value="available">@lang('Available')</option>
                        <option {{ old('status') == 'sale' ? "selected" : "" }}    value="sale">@lang('Sale')</option>
                        <option {{ old('status') == 'rent' ? "selected" : "" }}       value="rent">@lang('Rent')</option>
                      </select>
                      <div class="invalid-feedback">Please provide a valid Status</div>


                    </div>

                 
                    </div>
                    <div class="mb-3">
                      <input 
                          type="file" 
                          name="images[]" 
                          id="inputImage"
                          multiple="multiple" 
                          class="form-control @error('images') is-invalid @enderror">
        
                      @error('images')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                    <button class="btn btn-primary" type="submit">Submit form</button>
                  </form>
             
                    

























                    <div class="container">
       
                      <div class="row justify-content-center mt-5">
                          <div class="col-md-11 mt-3">
                    
                         
                              @if ($message = Session::get('success'))
                  
                                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                                      <strong>{{ $message }}</strong>
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>
                  
                                  @foreach(Session::get('images') as $image)
                                      <img src="images/{{ $image['name'] }}" width="250px">
                                  @endforeach
                  
                              @endif
                            
                              <form action="" method="POST" enctype="multipart/form-data" class="mt-4">
                                  @csrf
                        
                                  
                         
                                  <div class="mb-3">
                                      {{-- <button type="" class="btn btn-success">Upload</button> --}}
                                  </div>
                             
                              </form>
                          </div>
                      </div>
                  </div>





















                    <!-- Carousel wrapper -->
<div
id="carouselMultiItemExample"
class="carousel slide carousel-dark text-center"
data-mdb-ride="carousel"
>
<!-- Controls -->
{{-- <div class="d-flex justify-content-center mb-4">
  <button
    class="carousel-control-prev position-relative"
    type="button"
    data-mdb-target="#carouselMultiItemExample"
    data-mdb-slide="prev"
  >
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button
    class="carousel-control-next position-relative"
    type="button"
    data-mdb-target="#carouselMultiItemExample"
    data-mdb-slide="next"
  >
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div> --}}
<!-- Inner -->
<div class="carousel-inner py-4">
  <!-- Single item -->
  <div class="carousel-item active">
    <div class="container">
      <div class="row">
        @foreach($services->images as $img)
        <div class="col-lg-4">
          <div class="card">
            <img
              src="{{$img->path}}"
              class="card-img-top"
              alt="Waterfall" />
            <div class="card-body">             
              <a href="#!" class="btn btn-danger" style="margin: 0px">Delete</a>
            </div>
          </div>
        </div>
        @endforeach
     
      </div>
    </div>
  </div>


</div>
<!-- Inner -->
</div>
<!-- Carousel wrapper -->



































                   
                  

            </div>
        </div>
    </div>
@endsection


