@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">

        <div class="col-lg-8">
            <div class="card">
               
             


               <form enctype="multipart/form-data" name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('admin.services.store') }}" style="margin: 20px">
                  @csrf  
                  <div class="form-row">
                 

                        <div class="col mb-2">
                        <label for="validationCustom01">@lang('Name')</label>
                        <input type="text" id="name" name="name" class="form-control" id="validationCustom01" placeholder="@lang('Name')" value="" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>

                      <div class="col mb-3">
                        <label for="validationCustom05">@lang('User')</label>   
                        <select name="condition_id" value="" class="form-control selectpicker"  data-live-search="true" >
                          <option selected></option>
                          @foreach($Users as $user)
                             <option value="{{$user->id}}"   >{{ $user->email }}</option>
                          @endforeach
                       </select>
                      </div>

                     

                          <div class="w-100"></div>


                          <div class="col mb-3">
                            <label for="validationCustom05">@lang('Branch')</label>
                            <select name="branch_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                              @foreach($branchs as $branch)
                                 <option value="{{$branch->id}}"  @if ($loop->first) selected @endif>{{ $branch->name }}</option>
                              @endforeach
    
                           </select>
                            {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                            <div class="invalid-feedback">
                              Please provide a valid Branch.
                            </div>
                        </div>
                        
                      <div class="col mb-3">
                        <label for="validationCustomUsername">@lang('Price')</label>
                        <div class="input-group">
                          <input type="text" name="price" class="form-control" id="validationCustomUsername" placeholder="@lang('Price')" value=""  required>
                          <div class="invalid-feedback">
                            Please choose a Price.
                          </div>
                        </div>
                      </div>

                     
                      
                        <div class="col mb-3">
                          <label for="validationCustom03">@lang('Color')</label>
                          <select name="color_id" id="color" value="" class="form-control selectpicker"  data-live-search="true" required>
                            @foreach($Colors as $color)
                            {{-- <p>{{ old('color') }}</p>; --}}
                               <option value="{{ $color->id }}"  @if ($loop->first) selected @endif>{{ $color->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom03" placeholder="City" value="" required> --}}
                          
                          <div class="invalid-feedback">
                            Please provide a valid Color.
                          </div>
                        </div>

                            <div class="w-100"></div>


                        <div class="col mb-3">
                          <label for="validationCustom05">@lang('Sale?')</label>
                          <select class="custom-select"  name="is_for_sale" required>
                            <option  class="text--small badge font-weight-normal badge--success"  value="Sale">@lang('Sale')</option>
                            <option  class="text--small badge font-weight-normal badge--warning"  value="Rent">@lang('Rent')</option>
                          </select>
                          <div class="invalid-feedback">
                            Please provide a valid Sale.
                          </div>

                        </div>
                        
                        <div class="col mb-3">
                          <label for="validationCustom05">@lang('Condition')</label>
                          
                          <select name="condition_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                            @foreach($Conditions as $Condition)
                               <option value="{{$Condition->id}}"  @if ($loop->first) selected @endif >{{ $Condition->name }}</option>
                            @endforeach
                         </select>
                          <div class="invalid-feedback">
                            Please provide a valid Condition.
                          </div>
                      </div>
  
                          <div class="w-100"></div>

                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Material')</label>
                          <select name="material_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                            @foreach($Materials as $Material)
                               <option value="{{$Material->id}}"   @if ($loop->first) selected @endif>{{ $Material->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Material.
                          </div>
                        </div>
  
                      <div class="col mb-3">
                        <label for="validationCustom05">@lang('Status')</label>
  
                        <select name="status" class="custom-select"  required>
                          <option   value="{{'not_available'}}" >@lang('Not available')</option>
                          <option   value="{{'available'}}" selected>@lang('Available')</option>
                          <option   value="{{'sale'}}">@lang('Sale')</option>
                          <option   value="{{'rent'}}">@lang('Rent')</option>
                          <option   value="{{'rejected'}}">@lang('rejected')</option>
                        </select>
                        <div class="invalid-feedback">Please provide a valid select Status</div>
                        
                        </div>
  
                            <div class="w-100"></div>
                     
  
                      <div class="col mb-3">
                        <label for="validationCustom02">@lang('Description')</label>
                        <textarea rows="2" name="description" type="text"   class="form-control" id="validationCustom02" placeholder="@lang('Description')" value=""  aria-describedby="inputGroupPrepend"></textarea>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                       </div>

                        <div class="col mb-3">
                          <label for="validationCustom05">@lang('Location')</label>
                          <textarea rows="2" type="text" name="location" class="form-control" id="validationCustom05" placeholder="@lang('Location')" value=""></textarea>
                          <div class="invalid-feedback">
                            Please provide a valid Location.
                          </div>
                      </div>
  
                     <div class="w-100"></div>


                    <div class="col mb-3 ">
                      
                        <label for="validationCustom05">@lang('Section')</label>
                        <select   onchange="addRowCategory(this.value)" id="sections"  name="section_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                        @foreach($Sections as $Section)
                           <option value="{{$Section->id}}" @if ($loop->first) selected @endif >{{ $Section->name }}</option>
                        @endforeach
                       </select>
                       <div class="invalid-feedback">
                        Please provide a valid Section.
                      </div>
                      <div class="w-100"></div>


                  
                    </div>

        
                      <div class="col mb-3">
                        <label for="validationCustom05">@lang('Categories')</label>
                        <select  onchange="addRowSizes(this.value)" id="categories" name="category_id" value="" class="form-control selectpicker"  data-live-search="true">
        
                       </select>
                       
                        <div class="invalid-feedback">
                          Please provide a valid Categories.
                        </div>
                      </div>

                   
                      <div class="col mb-3 ">
                        <label for="validationCustom04">@lang('Size')</label>
                        <select   id="sizes" name="size_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                         
                       </select>
                      
                        <div class="invalid-feedback">
                          Please provide a valid Size.
                        </div>
                   
                      </div>
                    
                    </div>
                    <div class=" mb-3">
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
                   
                    <button class="btn btn-primary" type="submit">@lang('Create Product')</button>
                  </form>
             

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
   removeOptions(document.getElementById('sizes'));
    
1
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


  