@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">

            <div class="card b-radius--10 mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <td data-label="@lang('Name')"><b>@lang('Name') : </b></td>
                                    <td data-label="@lang('Name')">{{ $item->name }}</td>

                                    <td data-label="@lang('description')"><b>@lang('description'): </b></td>
                                    <td data-label="@lang('description')">{{ $item->description}}</td>

                                    <td data-label="@lang('price')"><b>@lang('price') : </b></td>
                                    <td data-label="@lang('price')">{{ $item->price }}</td>
                                </tr>

                                <tr>
                                    <td data-label="@lang('Color')"><b>@lang('Color'): </b></td>
                                    <td data-label="@lang('Color')">{{ $item->color->name }}</td>

                                    <td data-label="@lang('Size')"><b>@lang('Size') :</b></td>
                                    <td data-label="@lang('Size')">{{ $item->size->name }}</td>

                                    <td data-label="@lang('Condition')"><b>@lang('Condition') : </b></td>
                                    <td data-label="@lang('Condition')">{{ $item->condition->name }}</td>
                                </tr>

                                <tr>
                                    <td data-label="@lang('Material')"><b>@lang('Material') : </b></td>
                                    <td data-label="@lang('Material')">{{ $item->material->name }}</td>

                                    <td data-label="@lang('Section')"><b>@lang('Section') : </b></td>
                                    <td data-label="@lang('Section')">{{ $item->section->name }}</td>

                                    <td data-label="@lang('Branch')"><b>@lang('Branch') : </b></td>
                                    <td data-label="@lang('Branch')">{{ $item->branch->name }}</td>

                                    <td></td>
                                </tr>

                                <tr>
                                    <td data-label="@lang('is_for_sale')"><b>@lang('For sale') : </b></td>
                                    <td data-label="@lang('is_for_sale')">{{ $item->is_for_sale ? "للبيع" : "للإيجار" }}</td>

                                    <td data-label="@lang('User')"><b>@lang('User') : </b>
                                    </td>
                                    <td data-label="@lang('User')">{{ @$item->user->email }}</td>

                                    <td data-label="@lang('status')"><b>@lang('status') : </b></td>
                                    <td data-label="@lang('status')">{{$item->status}} </td>
                                </tr>

                                <tr>
                                    <td data-label="@lang('sku')"><b>@lang('sku') : </b>
                                    </td>
                                    <td data-label="@lang('sku')">{{ $item->sku }}</td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div><!-- card end -->
        </div>
    </div>


@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary box--shadow1 text-white text--small" href="{{ url()->previous() }}"><i
                class="fa fa-fw fa-backward"></i>@lang('Go Back')</a>

@endpush

