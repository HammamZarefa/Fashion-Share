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
                        <label for="validationCustom05">@lang('Branch')</label>
                        <select name="branch_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                          @foreach($branchs as $branch)
                             <option value="{{$branch->id}}" >{{ $branch->name }}</option>
                          @endforeach

                       </select>
                        {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                        <div class="invalid-feedback">
                          Please provide a valid Branch.
                        </div>
                    </div>

                          <div class="w-100"></div>


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
                               <option value="{{ $color->id }}" >{{ $color->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom03" placeholder="City" value="" required> --}}
                          
                          <div class="invalid-feedback">
                            Please provide a valid Color.
                          </div>
                        </div>

                            <div class="w-100"></div>


                        <div class="col mb-3">
                          <label for="validationCustom04">@lang('Size')</label>
                          <select name="size_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                            @foreach($Sizes as $size)
                               <option value="{{$size->id}}"  >{{ $size->name }}</option>
                            @endforeach
                         </select>

                          {{-- <input type="text" class="form-control" id="validationCustom04" placeholder="State" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Size.
                          </div>
                        </div>
                        <div class="col mb-3">
                          <label for="validationCustom05">@lang('Condition')</label>
                          
                          <select name="condition_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                            @foreach($Conditions as $Condition)
                               <option value="{{$Condition->id}}" >{{ $Condition->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Condition.
                          </div>
                      </div>
  
                          <div class="w-100"></div>

                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Material')</label>
                          <select name="material_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                            @foreach($Materials as $Material)
                               <option value="{{$Material->id}}"  >{{ $Material->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Material.
                          </div>
                        </div>
  
                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Section')</label>
                          <select name="section_id" value="" class="form-control selectpicker"  data-live-search="true" required>
                            @foreach($Sections as $Section)
                               <option value="{{$Section->id}}" >{{ $Section->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid Section.
                          </div>
                        </div>
  
                            <div class="w-100"></div>
                     
  
                      <div class="col mb-3">
                        <label for="validationCustom02">@lang('Description')</label>
                        <textarea rows="2" name="description" type="text"   class="form-control" id="validationCustom02" placeholder="@lang('Description')" value=""  aria-describedby="inputGroupPrepend" required></textarea>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>

                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Location')</label>
                          <textarea rows="2" type="text" name="location" class="form-control" id="validationCustom05" placeholder="@lang('Location')" value="" required></textarea>
                          <div class="invalid-feedback">
                            Please provide a valid Location.
                          </div>
                      </div>
  
                     <div class="w-100"></div>
                      <div class="col mb-3 ">
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
                        <label for="validationCustom05">@lang('Categories')</label>
                        <select name="category_id" value="" class="form-control selectpicker"  data-live-search="true">
                          @foreach($Categories as $Categorie)
                             <option value="{{$Categorie->id}}" >{{ $Categorie->name }}</option>
                          @endforeach
                       </select>
                        {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="{{__($services[0]->section->name)}}" required> --}}
                        <div class="invalid-feedback">
                          Please provide a valid Categories.
                        </div>
                      </div>

                   
                      <div class="col mb-3 ">
                        <label for="validationCustom05">@lang('Status')</label>
  
                        <select class="custom-select"  required>
                          <option   value="@lang('not_available')">@lang('Not available')</option>
                          <option   value="@lang('available')">@lang('Available')</option>
                          <option   value="@lang('sale')">@lang('Sale')</option>
                          <option   value="@lang('rent')">@lang('Rent')</option>
                          <option   value="@lang('rejected')">@lang('rejected')</option>
                        </select>
                        <div class="invalid-feedback">Please provide a valid select Status</div>
                        <div class="w-100"></div>


                    
                    </div>

                    
                    </div>
                    <div class=" mb-3">
                      <label for="validationCustom05">@lang('Images')</label>

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
@endsection


