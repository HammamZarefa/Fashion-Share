@extends('admin.layouts.app')
@section('panel')


    <div class="card-body col-4">

        @if(!Auth::guard('admin')->user()->branch)

            <select class="custom-select" name="branch"
                    onchange="window.location.href=this.options[this.selectedIndex].value;">
                <option selected value=" {{ route('admin.invoices') }}">All Branch</option>
                @foreach($branchs as $branch)
                    <option {{$id == $branch->id ?'selected':''}} value=" {{ route('admin.invoices',$branch->id) }}">

                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive b-radius--10">
                        <table class="table table--light tabstyle--two custom-data-table b-radius--10" id="table_1">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Products Code')</th>
                                <th scope="col">@lang('Products Name')</th>
                                <th scope="col">@lang('Sell Price')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody id="productTableBody">
                            <tr>
                                <td class="text-muted text-center" colspan="100%"></td>
                            </tr>
                            </tbody>
                        </table><!-- table end -->
                    </div>
                    <select id="mySelect" class="custom-select-for-products" style="height: 200px;" >
                        <option disabled selected>@lang('Choose one')</option>
                        @foreach($products as $product)
                        <option value="1"
                                data-image="{{count($product->images) != 0 ? getImage(imagePath()['service']['path'].'/'. $product->images[0]->path,imagePath()['service']['size']) : ''}}"
                                data-name="{{$product->name}}"
                                data-sku="{{$product->sku}}"
                                data-id="{{$product->id}}"
                                data-price="{{$product->sell_price}}"
                        >{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div><!-- card end -->
        </div>
        <div class="col-lg-5">
            <form action="{{route('admin.invoice.store',)}}" method="post">
                @csrf
                <div class="hidden" id="invoice_products">

                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-align: right;">
                            @lang('Invoice')
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"  style="text-align: right;">
                                <span>555555555555555555</span>
                            </div>
                            <div class="col-md-6">
                                <span>{{\Carbon\Carbon::today()}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive--sm table-responsive b-radius--10">
                                    <table class="table b-radius--10" id="table_2">
                                        <thead>
                                        <tr>
                                            <th scope="col">@lang('Products Code')</th>
                                            <th scope="col">@lang('Products Name')</th>
                                            <th scope="col">@lang('Sell Price')</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="invoicTableBody">
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5"  style="text-align: right;">
                                <h4>@lang('Total :')</h4>

                            </div>
                            <div class="col-md-5">
                                <span id="totalPrice">0 </span><span>sp</span>
                                <input type="hidden" name="total_price" id="total_price_input">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-5"  style="text-align: right;">
                                <h5>@lang('Discount :')</h5>

                            </div>
                            <div class="col-md-5">
                                <input onblur="discountPrice()" class="form-group" type="text" name="discount" id="discountInput">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6"  style="text-align: right;">
                                <h4>@lang('Total After Discount :')</h4>

                            </div>
                            <div class="col-md-4">
                                <span id="totalPriceAfterDiscount">0 </span><span>sp</span>
                                <input type="hidden" name="total_price_after_discount" id="total_price_input_after_discount">
                            </div>
                        </div>
                        <br>
                        <div class="row" style="justify-content: center;">
                            <button type="submit" class="btn btn-primary b-radius--capsule" style="width: 90%;">
                                @lang('Sell')
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>




@endsection

@push('breadcrumb-plugins')
    <div class="container-fluid">
        <div class="row  bg--primary p-3 b-radius--10">
            <div class="col-md-6">
                <h3 class="card-title">@lang('Detailed sales invoice')</h3>
            </div>
            <div class="col-md-6" >
                <div class="bg--gradi-12 b-radius--10 p-2">
                    <span>555555555555555555</span>
                </div>
                <br>
                <div class="bg--gradi-12 b-radius--10 p-2">
                    <span>{{\Carbon\Carbon::today()}}</span>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        function removeRow(button,price) {
            var row = button.parentNode.parentNode;
            var indexRow = row.rowIndex
            // Remove row from table1
            var table1 = document.getElementById("table_1");
            var index1 = row.rowIndex;
            console.log(indexRow)
            table1.deleteRow(indexRow);

            // Remove row from table2
            var table2 = document.getElementById("table_2");
            var index2 = row.rowIndex;
            console.log(indexRow)
            table2.deleteRow(indexRow);

            oldPrice = document.getElementById('totalPrice').innerHTML
            newPrice = parseInt(oldPrice) - parseInt(price)
            document.getElementById('totalPrice').innerHTML = newPrice + ' '

            oldPriceAfterDiscount = document.getElementById('totalPriceAfterDiscount').innerHTML
            newPriceAfterDiscount = parseInt(oldPriceAfterDiscount) - parseInt(price)
            document.getElementById('totalPriceAfterDiscount').innerHTML = newPriceAfterDiscount + ' '

            document.getElementById('total_price_input').value = newPrice
            document.getElementById('total_price_input_after_discount').value = newPriceAfterDiscount


        }
        function discountPrice(){
            val = document.getElementById('discountInput').value;
            oldPriceBeforDiscount = document.getElementById('totalPrice').innerHTML
            newPriceAfterDiscount = parseInt(oldPriceBeforDiscount) - parseInt(val)
            document.getElementById('totalPriceAfterDiscount').innerHTML = newPriceAfterDiscount + ' '
            document.getElementById('total_price_input_after_discount').value = newPriceAfterDiscount

        }
        $(document).ready(function() {
            $('#mySelect').select2({
                templateResult: formatOption,
                templateSelection: formatOption,
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            $('#mySelect').on('select2:select', function(e) {
                var selectedOption = e.params.data;
                var image = selectedOption.element.dataset.image;
                var name = selectedOption.element.dataset.name;
                var sku = selectedOption.element.dataset.sku;
                var price = selectedOption.element.dataset.price;
                var id = selectedOption.element.dataset.id;

                // Create a new row with the selected product data
                var newRow = $('<tr>');
                newRow.append('<td><img max-width="40px" width="40px;" src="' + image + '"></td>');
                newRow.append('<td>' + sku + '</td>');
                newRow.append('<td>' + name + '</td>');
                newRow.append('<td>' + price + '</td>');
                newRow.append('<td><div class="btn btn--danger" onclick="removeRow(this,'+price+')"><i class="la la-trash"></i> </div></td>');

                // Append the new row to the table body
                $('#productTableBody').append(newRow);

                // Create a new row with the selected product data
                var newRow2 = $('<tr>');
                newRow2.append('<td>' + sku + '</td>');
                newRow2.append('<td>' + name + '</td>');
                newRow2.append('<td>' + price + '</td>');

                // Append the new row to the table body
                $('#invoicTableBody').append(newRow2);
                oldPrice = document.getElementById('totalPrice').innerHTML
                oldPriceAfterDiscount = document.getElementById('totalPriceAfterDiscount').innerHTML
                newPrice = parseInt(oldPrice) + parseInt(price)
                newPriceAfterDiscount = parseInt(oldPriceAfterDiscount) + parseInt(price)
                document.getElementById('totalPrice').innerHTML = newPrice + ' '
                document.getElementById('total_price_input').value = newPrice
                document.getElementById('totalPriceAfterDiscount').innerHTML = newPriceAfterDiscount + ' '
                document.getElementById('total_price_input_after_discount').value = newPriceAfterDiscount

                var newRow3 = ('<input type="hidden" name="products[]" value="' + id + '">');
                console.log(newRow3);
                $('#invoice_products').append(newRow3);

                var selectElement = document.getElementById("mySelect");
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                if (selectedOption) {
                    selectedOption.remove();
                    selectElement.selectedIndex = 0;
                }

                // Remove the selected option from the select element
                // $(this).find('option:selected').remove();
            });
        });

        function formatOption(option) {
            if (!option.id) {
                return option.text;
            }

            var image = option.element.dataset.image;
            var name = option.element.dataset.name;
            var sku = option.element.dataset.sku;

            if (!image || !name || !sku) {
                return option.text;
            }

            var $option = $(
                '<span><img max-width="20px" width="20px;" src="' + image + '" class="option-image" /> ' +
                '<span class="option-text1">' + name + '</span>' +
                '<span class="option-text2">' + sku + '</span></span>'
            );

            return $option;
        }
    </script>
@endpush
