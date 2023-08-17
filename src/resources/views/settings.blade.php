@extends('web::layouts.app')

@section('title', trans_choice('pricescore::settings.price_provider_instance', 10))
@section('page_header', trans_choice('pricescore::settings.price_provider_instance', 10))
@section('page_description', trans_choice('pricescore::settings.price_provider_instance', 10))

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ trans_choice('pricescore::settings.price_provider_instance', 10) }}</h3>
        </div>
        <div class="card-body">
            {!! $dataTable->table([]) !!}
        </div>
    </div>

@endsection

@push('javascript')
    {!! $dataTable->scripts() !!}
@endpush