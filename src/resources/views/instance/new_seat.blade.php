@extends('web::layouts.app')

@section('title', trans_choice('pricescore::priceprovider.new_seat_price_provider', 10))
@section('page_header', trans_choice('pricescore::priceprovider.new_seat_price_provider', 10))
@section('page_description', trans_choice('pricescore::priceprovider.new_seat_price_provider', 10))

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ trans_choice('pricescore::priceprovider.new_seat_price_provider', 10) }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pricescore::instance.new.builtin.post') }}" method="POST">
                @csrf

                <input type="hidden" name="id" value="{{ $id ?? "" }}">

                <div class="form-group">
                    <label for="name">{{ trans('pricescore::settings.name') }}</label>
                    <input required type="text" name="name" id="name" class="form-control" placeholder="{{ trans('pricescore::settings.name_placeholder') }}" value="{{ $name }}">
                </div>

                <div class="form-group">
                    <label for="type">{{ trans('pricescore::priceprovider.price_type') }}</label>
                    <select id="type" name="type" class="form-control">
                        <option value="adjusted_price" @if($config['price_type']=='adjusted_price') selected @endif>{{ trans("pricescore::priceprovider.adjusted_price") }}</option>
                        <option value="highest" @if($config['price_type']=='highest') selected @endif>{{ trans("pricescore::priceprovider.highest") }}</option>
                        <option value="lowest" @if($config['price_type']=='lowest') selected @endif>{{ trans("pricescore::priceprovider.lowest") }}</option>
                        <option value="sell_price" @if($config['price_type']=='sell_price') selected @endif>{{ trans("pricescore::priceprovider.sell_price") }}</option>
                        <option value="buy_price" @if($config['price_type']=='buy_price') selected @endif>{{ trans("pricescore::priceprovider.buy_price") }}</option>
                        <option value="average_prices" @if($config['price_type']=='average_prices') selected @endif>{{ trans("pricescore::priceprovider.average_prices") }}</option>
                        <option value="average" @if($config['price_type']=='average') selected @endif>{{ trans("pricescore::priceprovider.average") }}</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ trans("pricescore::priceprovider.save")  }}</button>
            </form>
        </div>
    </div>

@endsection
