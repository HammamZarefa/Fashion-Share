@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">

        <div class="col-lg-8">
            <div class="card">
               
             


               <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{ route('admin.services.store') }}" style="margin: 20px">
                  @csrf  
                  <div class="form-row">
                 

                        <div class="col mb-2">
                        <label for="validationCustom01">@lang('Name')</label>
                        <input type="text" id="name" name="name" class="form-control" id="validationCustom01" placeholder="First name" value="" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>


                      <div class="col mb-3">
                        <label for="validationCustom05">@lang('Branch')</label>
                        <select name="branch_id" value="" class="form-control selectpicker"  data-live-search="true">
                          @foreach($branchs as $branch)
                             <option value="{{$branch->id}}" >{{ $branch->name }}</option>
                          @endforeach
                       </select>
                        {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                        <div class="invalid-feedback">
                          Please provide a valid zip.
                        </div>
                    </div>

                          <div class="w-100"></div>


                      <div class="col mb-3">
                        <label for="validationCustomUsername">@lang('Price')</label>
                        <div class="input-group">
                          <input type="text" name="price" class="form-control" id="validationCustomUsername" placeholder="Username" value=""  required>
                          <div class="invalid-feedback">
                            Please choose a username.
                          </div>
                        </div>
                      </div>

                      
                        <div class="col mb-3">
                          <label for="validationCustom03">@lang('Color')</label>
                          
                          <select name="color_id" id="color" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Colors as $color)
                            {{-- <p>{{ old('color') }}</p>; --}}
                               <option value="{{ $color->id }}" >{{ $color->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom03" placeholder="City" value="" required> --}}
                          
                          <div class="invalid-feedback">
                            Please provide a valid city.
                          </div>
                        </div>

                            <div class="w-100"></div>


                        <div class="col mb-3">
                          <label for="validationCustom04">@lang('Size')</label>
                          <select name="size_id" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Sizes as $size)
                               <option value="{{$size->id}}"  >{{ $size->name }}</option>
                            @endforeach
                         </select>

                          {{-- <input type="text" class="form-control" id="validationCustom04" placeholder="State" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid state.
                          </div>
                        </div>
                        <div class="col mb-3">
                          <label for="validationCustom05">@lang('Condition')</label>
                          
                          <select name="condition_id" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Conditions as $Condition)
                               <option value="{{$Condition->id}}" >{{ $Condition->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid zip.
                          </div>
                      </div>
  
                          <div class="w-100"></div>

                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Material')</label>
                          <select name="material_id" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Materials as $Material)
                               <option value="{{$Material->id}}"  >{{ $Material->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid zip.
                          </div>
                        </div>
  
                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Section')</label>
                          <select name="section_id" value="" class="form-control selectpicker"  data-live-search="true">
                            @foreach($Sections as $Section)
                               <option value="{{$Section->id}}" >{{ $Section->name }}</option>
                            @endforeach
                         </select>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                          <div class="invalid-feedback">
                            Please provide a valid zip.
                          </div>
                        </div>
  
                            <div class="w-100"></div>
                     
  
                      <div class="col mb-3">
                        <label for="validationCustom02">@lang('Description')</label>
                        <input type="text"   class="form-control" id="validationCustom02" placeholder="Last name" value=""  aria-describedby="inputGroupPrepend" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>

                      <div class="col mb-3">
                          <label for="validationCustom05">@lang('Location')</label>
                          <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required>
                          <div class="invalid-feedback">
                            Please provide a valid zip.
                          </div>
                      </div>
  
                  <div class="w-100"></div>
                      <div class="col mb-3 ">
                          <label for="validationCustom05">@lang('Sale?')</label>
                          {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                          <select class="custom-select"  name="is_for_sale" required>
                            <option  class="text--small badge font-weight-normal badge--success"  value="Sale">@lang('Sale')</option>
                            <option  class="text--small badge font-weight-normal badge--warning"  value="Rent">@lang('Rent')</option>
                          </select>
                          <div class="invalid-feedback">
                            Please provide a valid zip.
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
                          Please provide a valid zip.
                        </div>
                      </div>

                      <div class="w-100"></div>
              



                    <div class="col mb-3 ">
                      <label for="validationCustom05">@lang('Status')</label>

                      <select class="custom-select"  required>
                        <option {{ old('status') == 'available' ? "@lang('Not available')" : "" }}  class="text--small badge font-weight-normal badge--success"  value="@lang('Not available')">@lang('Not available')</option>
                        <option {{ old('name') == 'available1' ? "@lang('Available')" : "" }}  class="text--small badge font-weight-normal badge--warning"  value="@lang('Available')">@lang('Available')</option>
                     </select>
                      <div class="invalid-feedback">Example invalid custom select feedback</div>

                    </div>

                    </div>

                   
                    <button class="btn btn-primary" type="submit">Submit form</button>
                  </form>
             

            </div>
        </div>
    </div>
@endsection


