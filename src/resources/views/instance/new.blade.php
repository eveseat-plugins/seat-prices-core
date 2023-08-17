@extends('web::layouts.app')

@section('title', trans('pricescore::settings.new_price_provider_instance'))
@section('page_header', trans('pricescore::settings.new_price_provider_instance'))
@section('page_description', trans('pricescore::settings.new_price_provider_instance'))

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-baseline">
        <h3 class="card-title">{{ trans('pricescore::settings.new_price_provider_instance') }}</h3>
        <a class="btn btn-secondary ml-auto" href="{{ route('pricescore::settings') }}">{{ trans('pricescore::settings.back') }}</a>
    </div>
    <div class="card-body">
        <form action="{{ route('pricescore::instance.new.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('pricescore::settings.name') }}</label>
                <input required type="text" name="name" id="name" class="form-control" placeholder="{{ trans('pricescore::settings.name_placeholder') }}">
            </div>
            <div class="form-group">
                <label for="type">{{ trans('pricescore::settings.price_provider_type') }}</label>
                <select required id="type" name="type" class="form-control">
                    @foreach(config('priceproviders.backends') as $type=>$backend)
                        <option value="{{$type}}">{{ trans($backend['label'] ?? 'web::seat.unknown') }} ({{ trans($backend['plugin'] ?? 'pricescore::settings.unknown_plugin') }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">{{ trans('pricescore::settings.next') }}</button>
        </form>
    </div>
</div>

@endsection
