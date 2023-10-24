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
                        <label for="validationCustom03">@lang('User')</label>
                        
                        <select name="color_id" id="color" value="" class="form-control selectpicker"  data-live-search="true">
                          @foreach($Users as $user)
                             <option value="{{ $user->id }}"  {{ $services->user_id == $user->id ? "selected" :""}}>{{ $user->email }}</option>
                          @endforeach
                       </select>
                      </div>
                      
                      
                          <div class="w-100"></div>

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
                               <option value="{{ $color->id }}"  {{ $services->color_id == $color->id ? "selected" :""}}>{{ $color->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom03" placeholder="City" value="{{__($services[0]->color->name)}}" required> --}}
                          
                          <div class="invalid-feedback">
                            Please provide a valid Color.
                          </div>
                        </div>

                            <div class="w-100"></div>

                            <div class="col mb-3 ">
                              <label for="validationCustom05">@lang('Sale?')</label>
                              {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services->is_for_sale ? 'Sale' : 'Rent')}}" required> --}}
                              <select class="custom-select"  name="is_for_sale" required>
                                <option  class="text--small badge font-weight-normal badge--success" {{ old('is_for_sale') == 1 ? "selected" : "" }}    value="sale">@lang('Sale')</option>
                                <option  class="text--small badge font-weight-normal badge--warning"  {{ old('is_for_sale') == 0 ? "selected" : "" }} value="rent">@lang('Rent')</option>
                              </select>
                              <div class="invalid-feedback">
                                Please provide a valid Sale.
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
                        
                        <div class="col mb-3 ">
                          <label for="validationCustom05">@lang('Status')</label>
                          <select class="custom-select" name="status"  >
                            <option {{ $services->status == "not_available" ? "selected" : "" }}   value="not_available">@lang('Not available')</option>
                            <option {{ $services->status== "available"     ? "selected" : "" }}    value="available">@lang('Available')</option>
                            <option {{ $services->status == "sale"          ? "selected" : "" }}    value="sale">@lang('Sale')</option>
                            <option {{ $services->status == "rent"          ? "selected" : "" }}       value="rent" >@lang('Rent')</option>
                          </select>
                          <div class="invalid-feedback">Please provide a valid Status</div>
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
                          <input type="text" name="location" class="form-control" id="validationCustom05" placeholder="Location" value="{{__($services->location)}}" >
                          <div class="invalid-feedback">
                            Please provide a valid Location.
                          </div>
                      </div>
  
                  <div class="w-100"></div>
                     
                  <div class="w-100"></div>


                  <div class="col mb-3 ">
                    
                    <label for="validationCustom05">@lang('Section')</label>
                    <select   onchange="addRowCategory(this.value)" id="sections"  name="section_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                      <option>select section</option>
                      @foreach($Sections as $Section)
                      <option value="{{$Section->id}}" {{ $services->section_id == $Section->id ? "selected" :""}}>{{ $Section->name }}</option>
                      @endforeach
                    </select>
                    {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                    <div class="invalid-feedback">
                      Please provide a valid Section.
                    </div>
                    <div class="w-100"></div>


                
                  </div>

                    <div class="col mb-3">
                      <label for="validationCustom05">@lang('Categories')</label>
                      <select  onchange="addRowSizes(this.value)" id="categories" name="category_id" value="" class="form-control selectpicker"  data-live-search="true">
                        {{-- @foreach($Sections[ {{!! $services->section_id !!}} ]->category as $Categorie)
                          <option value="{{$Categorie->id}}" {{ $services->category_id == $Categorie->id ? "selected" :""}}>{{ $Categorie->name }}</option>
                        @endforeach --}}
                     </select>
                     
                      {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services[0]->section->name)}}" required> --}}
                      <div class="invalid-feedback">
                        Please provide a valid Categories.
                      </div>
                    </div>

                 
                    <div class="col mb-3 ">
                      <label for="validationCustom04">@lang('Size')</label>
                      <select   id="sizes" name="size_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                        {{-- @foreach($Sizes as $size)
                        <option value="{{$size->id}}"  {{ $services->size_id == $size->id ? "selected" :""}}>{{ $size->name }}</option>
                        @endforeach --}}
                     </select>
                    
                      {{-- <input type="text" class="form-control" id="validationCustom04" placeholder="State" value="" required> --}}
                      <div class="invalid-feedback">
                        Please provide a valid Size.
                      </div>
                 
                    </div>  
                   

                 
                    </div>
                    <div class="mb-3">
                      <label for="validationCustom05">@lang('Upload Image')</label>

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
             
                    








                    <!-- Carousel wrapper -->
    <div
    id="carouselMultiItemExample"
    class="carousel slide carousel-dark text-center"
    data-mdb-ride="carousel">

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
                src="{{ getImage(imagePath()['service']['path'].'/'. $img->path,imagePath()['service']['size'])}}"
                              class="card-img-top"
                  alt="Waterfall" />
                <div class="card-body">             
                  <a href="{{url('admin/services/deleteImage/'.$img->id)}}" class="btn btn-danger" style="margin: 0px">Delete</a>
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

    <script>

function addRowCategory(ele) 
{
      var ID= ele;
      Sections = {!! json_encode($Sections) !!};
      category =  Sections[ID-1].category;
      var categoryOptions = document.getElementById("categories"); 
      removeOptions(categoryOptions);
     
      var i=0;
      category.forEach(function(item, index) {
        var option = document.createElement("option");
        option.value = item.id;
        option.innerHTML = item.name;
        if(i == 0){option.selected =true};
        i++;
        categoryOptions.add(option);
      });

     
      removeOptions(document.getElementById('sizes'));
    
      addRowSizes(categoryOptions.value);


  }

  function removeOptions(selectElement) {
   var i, L = selectElement.options.length - 1;
   for(i = L; i >= 0; i--) {
      selectElement.remove(i);
   }


}

function addRowSizes(ele){
      var name= ele;
      Categories = {!! json_encode($Categories) !!};
      if(Categories!= null){
      size =  Categories[name-1].sizes;
      }
      var x = document.getElementById("sizes");



      size.forEach(function(item, index) {
        var option = document.createElement("option");
        option.value = item.id;
        option.innerHTML = item.name;
        x.add(option);
        }
      );
}


      window.onload = selectSection();
      function selectSection (){

        var firstselectsection = document.getElementById("sections");
        addRowCategory(firstselectsection.value);
      };
        </script>



@endsection


