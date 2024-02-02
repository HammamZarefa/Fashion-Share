@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="text-align: right;">

                        <span class="text--blue">
                             @lang('Pieces'){{$sections->sum('product_count')}}
                        </span>
                        @lang('Stock')
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row" style="justify-content: center;">
                        @foreach($sections as $key=>$section)
                            <div class="col-md-6">
                                <div class="bg--{{$key+1}} b-radius--10 p-4 m-2">
                                    <h3 class="center" style="text-align: center">
                                        {{__($section->name)}}
                                    </h3>
                                    <h3 class="center" style="text-align: center">
                                        @lang('Pieces') {{$section->product_count}}
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="text-align: right;">
                        @lang('Best Sellers')
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row" style="justify-content: center;">
                        @foreach($bestSellerCategory as $key=>$bestSeller)
                            <div class="col-md-12 m-4">
                                <div class="row">
                                    <div class="col-md-2">
                                        @lang('Pieces') {{$bestSeller['invoicesProducts_count']}}
                                    </div>
                                    <div class="col-md-8">
                                        <?php
                                        if ($bestSeller['invoicesProducts_count'] < 10)
                                            $x =$bestSeller['invoicesProducts_count'] * 10 ;
                                        elseif ($bestSeller['invoicesProducts_count'] < 100)
                                            $x= $bestSeller['invoicesProducts_count'];
                                        else
                                            $x =$bestSeller['invoicesProducts_count'] / 10;

                                        ?>
                                        <div class="progress-bar">
                                            <div class="progress-bar-fill" style="width: {{$x}}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                         {{__($bestSeller['category_name'])}} -{{$key}}


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')

@endpush

@push('script')
@endpush
