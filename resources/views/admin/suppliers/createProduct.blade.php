@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="card">


                <form enctype="multipart/form-data" name="add-blog-post-form" id="add-blog-post-form" method="post"
                      action="{{ route('admin.service.storeWithSupplier',[$supplier->id,@$from]) }}" style="margin: 20px">
                    @csrf
                    <div class="card card-group">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="col mb-3 ">

                                        <label for="validationCustom05">@lang('Section')</label>
                                        <select onmouseup="filterCategoriesBySection(this.value)" id="sections" name="section_id" class="form-control selectpicker" data-live-search="true" required>
                                            @foreach($Sections as $Section)
                                                <option value="{{$Section->id}}"
                                                        @if ($loop->first) selected @endif >{{ $Section->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid Section.
                                        </div>
                                        <div class="w-100"></div>


                                    </div>
                                    <div class="col mb-3">
                                        <label for="validationCustom05">@lang('Categories')</label>
                                        <select id="categories"  name="category_id" onmouseup="filterSizesByCategory(this.value)" onchange="filterSizesByCategory(this.value)"
                                                class="form-control selectpicker" data-live-search="true">
{{--                                            <option disabled selected>@lang('Choose Section First')</option>--}}
                                            @foreach($Categories as $Category)
                                                <option value="{{$Category->id}}" data-id="{{$Category->section_id}}"
                                                @if(!$Sections[0]->id == $Category->section_id)  disabled @endif>{{ $Category->name }}</option>
                                            @endforeach

                                        </select>

                                        <div class="invalid-feedback">
                                            Please provide a valid Categories.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="float: right;">
                                @lang('Product Description')
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    {{--Name--}}
                                    <div class="col mb-2">
                                        <label for="validationCustom01">@lang('Name')</label>
                                        <input type="text" id="name" name="name" class="form-control" id="validationCustom01"
                                               placeholder="@lang('Name')" value="" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    {{--Size--}}
                                    <div class="col mb-3 ">
                                        <label for="validationCustom04">@lang('Size')</label>
                                        <select id="sizes" name="size_id" value="" class="form-control selectpicker"
                                                data-live-search="true" required>
                                            @foreach($Sizes as $Size)
                                                <option value="{{$Size->id}}"
                                                        @if ($Size->category_id == $Categories->where('section_id',$Sections[0]->id)->first()->id) selected @else disabled @endif >{{ $Size->name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="invalid-feedback">
                                            Please provide a valid Size.
                                        </div>

                                    </div>
                                    {{--Material--}}
                                    <div class="col mb-3">
                                        <label for="validationCustom05">@lang('Material')</label>
                                        <select name="material_id" value="" class="form-control selectpicker"
                                                data-live-search="true" required>
                                            @foreach($Materials as $Material)
                                                <option value="{{$Material->id}}"
                                                        @if ($loop->first) selected @endif>{{ $Material->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                                        <div class="invalid-feedback">
                                            Please provide a valid Material.
                                        </div>
                                    </div>
                                    {{--Season--}}
                                    <div class="col mb-3">
                                        <label for="validationCustom05">@lang('Season')</label>
                                        <select name="season_id" value="" class="form-control selectpicker"
                                                data-live-search="true" required>
                                            @foreach($seasons as $season)
                                                <option value="{{$season->id}}"
                                                        @if ($loop->first) selected @endif>{{ $season->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" value="" required> --}}
                                        <div class="invalid-feedback">
                                            Please provide a valid Material.
                                        </div>
                                    </div>
                                    {{--Status--}}
                                    <div class="col mb-3">
                                        <label for="validationCustom05">@lang('Status')</label>

                                        <select name="status" class="custom-select" required>
                                            <option value="{{'available'}}" selected>@lang('Available')</option>
                                            <option value="{{'sale'}}">@lang('Sale')</option>
                                            <option value="{{'rent'}}">@lang('Rent')</option>
                                        </select>
                                        <div class="invalid-feedback">Please provide a valid select Status</div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{--Description--}}
                                    <div class="col mb-3">
                                        <label for="validationCustom02">@lang('Description')</label>
                                        <textarea rows="2" name="description" type="text" class="form-control"
                                                  id="validationCustom02" placeholder="@lang('Description')" value=""
                                                  aria-describedby="inputGroupPrepend"></textarea>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    {{--Color--}}
                                    <div class="col mb-3">
                                        <label for="validationCustom03">@lang('Color')</label>
                                        <select name="color_id" id="color" value="" class="form-control selectpicker"
                                                data-live-search="true" required>
                                            @foreach($Colors as $color)
                                                {{-- <p>{{ old('color') }}</p>; --}}
                                                <option value="{{ $color->id }}"
                                                        @if ($loop->first) selected @endif>{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="text" class="form-control" id="validationCustom03" placeholder="City" value="" required> --}}

                                        <div class="invalid-feedback">
                                            Please provide a valid Color.
                                        </div>
                                    </div>
                                    {{--Condition--}}
                                    <div class="col mb-3">
                                        <label for="validationCustom05">@lang('Condition')</label>

                                        <select name="condition_id" value="" class="form-control selectpicker"
                                                data-live-search="true" required>
                                            @foreach($Conditions as $Condition)
                                                <option value="{{$Condition->id}}"
                                                        @if ($loop->first) selected @endif >{{ $Condition->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid Condition.
                                        </div>
                                    </div>
                                    {{--Style--}}
                                    <div class="col mb-3">
                                        <label for="validationCustom05">@lang('Style')</label>

                                        <select name="style_id" value="" class="form-control selectpicker" id="styles"
                                                data-live-search="true" required>
                                            @foreach($styles as $style)
                                                <option value="{{$style->id}}"
                                                        @if ($style->category_id == $Categories->where('section_id',$Sections[0]->id)->first()->id) selected @else disabled @endif >{{ $style->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid Style.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="float: right;">
                                @lang('Product Price')
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col mb-3">
                                        <label for="validationCustomUsername">@lang('Buy Price')</label>
                                        <div class="input-group">
                                            <input type="text" name="buy_price" class="form-control" id="validationCustomUsername"
                                                   placeholder="@lang('Buy Price')" value="" required>
                                            <div class="invalid-feedback">
                                                Please choose a Buy Price.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col mb-3">
                                        <label for="validationCustomUsername">@lang('Cost')</label>
                                        <div class="input-group">
                                            <input type="text" name="price" class="form-control" id="validationCustomUsername"
                                                   placeholder="@lang('Cost')" value="" required>
                                            <div class="invalid-feedback">
                                                Please choose a Price.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col mb-3">
                                        <label for="validationCustomUsername">@lang('Sell Price')</label>
                                        <div class="input-group">
                                            <input type="text" name="sell_price" class="form-control" id="validationCustomUsername"
                                                   placeholder="@lang('Sell Price')" value="" required>
                                            <div class="invalid-feedback">
                                                Please choose a Sell Price.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="float: right;">
                                @lang('Product Barcode')
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="col mb-3">
{{--                                        <label for="validationCustom05">@lang('Barcode')</label>--}}
                                        <input type="hidden" name="barcode" id="barcodeInput">
                                        <button type="button" class="btn btn-primary" id="generateBarcodeBtn" onclick="generateBarcode()">@lang('Generate Barcode')</button>

                                    </div>

                                </div>
                                <div class="col-md-2" id="barcodeContainerDiv">
                                    <img id="barcodeContainer" />
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-primary b-radius--capsule" id="printBarcode" onclick="printBarcodeee()" style="display: none;">
                                       @lang('Print Barcode') <i class="la la-print"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>




                    <button class="btn btn-primary" type="submit">@lang('Create Product')</button>
                </form>


            </div>
        </div>
    </div>






@endsection
@push('script')
    <script>
        document.getElementById("sections").addEventListener("mouseup", function() {
            filterCategoriesBySection(this.value);
        });

        function filterCategoriesBySection(sectionId) {
            var categoriesSelect = document.getElementById("categories");
            categoriesSelect.disabled = false;
            categoriesSelect.innerHTML = "";

            var categories = {!! json_encode($Categories) !!};
            var filteredCategories = categories.filter(function(category) {
                return category.section_id == sectionId;
            });

            filteredCategories.forEach(function(category,index) {
                var option = document.createElement("option");
                option.value = category.id;
                option.text = category.name;
                categoriesSelect.appendChild(option);
                if (index == 0){
                    filterSizesByCategory(category.id)
                }

            });
        }

        document.getElementById("categories").addEventListener("onmouseup", function() {
            filterSizesByCategory(this.value);
        });
        document.getElementById("categories").addEventListener("change", function() {
            filterSizesByCategory(this.value);
        });

        function filterSizesByCategory(categoryId) {
            var sizesSelect = document.getElementById("sizes");
            sizesSelect.disabled = false;
            sizesSelect.innerHTML = "";

            var sizes = {!! json_encode($Sizes) !!};
            var filteredSizess = sizes.filter(function(size) {
                return size.category_id == categoryId;
            });

            filteredSizess.forEach(function(size) {
                var option = document.createElement("option");
                option.value = size.id;
                option.text = size.name;
                sizesSelect.appendChild(option);
            });

            var stylesSelect = document.getElementById("styles");
            stylesSelect.disabled = false;
            stylesSelect.innerHTML = "";

            var styles = {!! json_encode($styles) !!};
            var filteredStyles = styles.filter(function(style) {
                return style.category_id == categoryId;
            });

            filteredStyles.forEach(function(style) {
                var styleOption = document.createElement("option");
                styleOption.value = style.id;
                styleOption.text = style.name;
                stylesSelect.appendChild(styleOption);
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.3/dist/JsBarcode.all.min.js"></script>
    <script>
        function generateBarcode(){
            var barcodeValue = generateRandomBarcode();
            console.log(barcodeValue)
            document.getElementById('barcodeInput').value = barcodeValue;
            printButton = document.getElementById('printBarcode');
            printButton.style.display = 'block';

            var canvas = document.createElement('canvas');

            // Generate barcode using JsBarcode
            JsBarcode('#barcodeContainer', barcodeValue);

            // Append the canvas to the barcode container
            var barcodeContainer = document.getElementById('barcodeContainer');
            barcodeContainer.innerHTML = '';
            barcodeContainer.appendChild(canvas);

            // Add the barcode value to a hidden input field in the form
            var barcodeInput = document.createElement('input');
            barcodeInput.type = 'hidden';
            barcodeInput.name = 'barcode';
            barcodeInput.value = barcodeValue;

            var form = document.querySelector('form');
            form.appendChild(barcodeInput);
        }
        // document.addEventListener('DOMContentLoaded', function() {
        //
        //
        //     // Submit the form
        //     // form.submit();
        // });

        function generateRandomBarcode() {
            var characters = '0123456789';
            var barcodeLength = 10;
            var barcodeValue = '';

            for (var i = 0; i < barcodeLength; i++) {
                barcodeValue += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            return barcodeValue;
        }
        function printBarcodeee() {
            var body =document.body.innerHTML;
            var data =document.getElementById('barcodeContainerDiv').innerHTML;
            document.body.innerHTML = data;
            window.print();
            document.body.innerHTML = body;

        }
    </script>
@endpush


