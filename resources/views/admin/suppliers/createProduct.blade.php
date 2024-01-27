@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="card">


                <form enctype="multipart/form-data" name="add-blog-post-form" id="add-blog-post-form" method="post"
                      action="{{ route('admin.service.storeWithSupplier',$supplier->id) }}" style="margin: 20px">
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
                                        <select id="sections" name="section_id"
                                                value="" class="form-control selectpicker" data-live-search="true"
                                                required>
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
                                        <select id="categories" name="category_id"
                                                class="form-control selectpicker" data-live-search="true">
                                            @foreach($Categories as $Category)
                                                <option value="{{$Category->id}}"
                                                        @if ($loop->first) selected @endif >{{ $Category->name }}</option>
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
                                                        @if ($loop->first) selected @endif >{{ $Size->name }}</option>
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
                                            <option value="{{'not_available'}}">@lang('Not available')</option>
                                            <option value="{{'available'}}" selected>@lang('Available')</option>
                                            <option value="{{'sale'}}">@lang('Sale')</option>
                                            <option value="{{'rent'}}">@lang('Rent')</option>
                                            <option value="{{'rejected'}}">@lang('rejected')</option>
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

                                        <select name="style_id" value="" class="form-control selectpicker"
                                                data-live-search="true" required>
                                            @foreach($styles as $style)
                                                <option value="{{$style->id}}"
                                                        @if ($loop->first) selected @endif >{{ $style->name }}</option>
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
                                        <label for="validationCustomUsername">@lang('Price')</label>
                                        <div class="input-group">
                                            <input type="text" name="price" class="form-control" id="validationCustomUsername"
                                                   placeholder="@lang('Price')" value="" required>
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
                                        <button type="button" class="btn btn-primary" id="generateBarcodeBtn" onclick="generateBarcode()">Generate Barcode</button>

                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div id="barcodeContainer"></div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-primary b-radius--capsule" id="printBarcode" onclick="printBarcoderrrrr()" style="display: none;">
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

        {{--function addRowCategory(ele) {--}}
        {{--    var ID = ele;--}}
        {{--    Sections = {!! json_encode($Sections) !!};--}}

        {{--    var ref;--}}
        {{--    for (var i = 0; i < Sections.length; i++) {--}}
        {{--        if (Sections[i].id == ele) {--}}
        {{--            ref = i;--}}
        {{--            console.log(ref);--}}
        {{--        }--}}
        {{--    }--}}
        {{--    category = Sections[ref].category;--}}


        {{--    var categoryOptions = document.getElementById("categories");--}}
        {{--    removeOptions(categoryOptions);--}}

        {{--    var i = 0;--}}
        {{--    category.forEach(function (item, index) {--}}
        {{--        var option = document.createElement("option");--}}
        {{--        option.value = item.id;--}}
        {{--        option.innerHTML = item.name;--}}
        {{--        if (i == 0) {--}}
        {{--            option.selected = true--}}
        {{--        }--}}
        {{--        ;--}}
        {{--        i++;--}}
        {{--        categoryOptions.add(option);--}}
        {{--    });--}}


        {{--    removeOptions(document.getElementById('sizes'));--}}

        {{--    addRowSizes(categoryOptions.value);--}}


        {{--}--}}

        {{--function removeOptions(selectElement) {--}}
        {{--    var i, L = selectElement.options.length - 1;--}}
        {{--    for (i = L; i >= 0; i--) {--}}
        {{--        selectElement.remove(i);--}}
        {{--    }--}}


        {{--}--}}

        {{--function addRowSizes(ele) {--}}
        {{--    removeOptions(document.getElementById('sizes'));--}}


        {{--    var name = ele;--}}
        {{--    Categories = {!! json_encode($Categories) !!};--}}
        {{--    if (Categories != null) {--}}

        {{--        var ref;--}}
        {{--        for (var i = 0; i < Categories.length; i++) {--}}
        {{--            if (Categories[i].id == ele) {--}}
        {{--                ref = i;--}}
        {{--            }--}}
        {{--        }--}}
        {{--        console.log(Categories)--}}
        {{--        size = Categories[ref].sizes;--}}
        {{--    }--}}
        {{--    var x = document.getElementById("sizes");--}}

        {{--    console.log(size)--}}
        {{--    size.forEach(function (item, index) {--}}
        {{--            var option = document.createElement("option");--}}
        {{--            option.value = item.id;--}}
        {{--            option.innerHTML = item.name;--}}
        {{--            x.add(option);--}}
        {{--        }--}}
        {{--    );--}}
        {{--}--}}


        {{--window.onload = selectSection();--}}

        {{--function selectSection() {--}}

        {{--    var firstselectsection = document.getElementById("sections");--}}
        {{--    addRowCategory(firstselectsection.value);--}}
        {{--};--}}
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
            JsBarcode(canvas, barcodeValue);

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
        function printBarcoderrrrr() {
            // var barcodeContainer = document.getElementById('barcodeContainer').cloneNode(true);
            // var printWindow = window.open('', '_blank');
            //
            // printWindow.document.open();

            // printWindow.document.close();
            //
            // printWindow.document.body.appendChild(barcodeContainer);
            // printWindow.print();
            // printWindow.close();
        }
    </script>
@endpush


