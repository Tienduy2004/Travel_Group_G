@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách mã khuyến mãi</h1>
    <div class="promotions-container">
        @foreach ($promotions as $promotion)
        <div class="promotion-card">
            <div class="promotion-code">
                <div class="code">Code:
                    <strong>{{ $promotion->code }}</strong>
                </div>
                <pre></pre>
                <strong>{{ $promotion->description }}</strong>
            </div>
            <div class="promotion-expiry">
                <span class="countdown" data-expiry="{{ $promotion->end_date->format('Y-m-d H:i:s') }}"></span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection