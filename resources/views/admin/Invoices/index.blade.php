@extends('admin.layouts.app')
@section('panel')


<div class="card-body col-4">
       

    <select class="custom-select" name="branch" onchange="window.location.href=this.options[this.selectedIndex].value;">
        <option disabled selected>Select Branch</option>
        @foreach($branchs as $branch)
        <option value=" {{ route('admin.invoices',$branch->id) }}">
            
            {{ $branch->name }}
        </option>
     @endforeach
    </select>

</div>

    <div class="row">      
        <div class="col-lg-12">
            <div class="">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light tabstyle--two custom-data-table">
                            <thead>
                            <tr>
                                <th scope="col">@lang('ID')</th>
                                <th scope="col">@lang('Prosuct')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('date_of_process')</th>
                                <th scope="col">@lang('branch')</th>
                            </tr>
                            </thead>
                            <tbody>
                             @forelse ($invoices as $invoice) 
                                 <tr> 
                                    <td data-label="@lang('Name')">{{__($invoice->id)}}</td>
                                    <td data-label="@lang('Name')">{{__($invoice->products->name)}}</td>
                                    <td data-label="@lang('Adress')">{{__($invoice->price)}}</td>
                                    <td data-label="@lang('Status')">
                                      @if($invoice->status=='sale')
                                            <span
                                                class="text--small badge font-weight-normal badge--primary">{{$invoice->status}}</span>
                                        @elseif($invoice->status=='rent')
                                            <span
                                            class="text--small badge font-weight-normal badge--dark">{{$invoice->status}}</span>

                                        @endif  
                                    </td>                                    
                                    <td data-label="@lang('Name')">{{__($invoice->date_of_process)}}</td>
                                    <td data-label="@lang('Adress')">{{__($invoice->products->branch->name)}}</td>

                               

                                 </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>



   
@endsection

