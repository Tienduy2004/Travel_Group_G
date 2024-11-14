@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách mã khuyến mãi</h1>
    <div class="promotions-container">
        @foreach ($promotions as $promotion)
            <div class="promotion-card">
                <div class="promotion-code">               
                <div id="code">Code</div>
                    <strong>{{ $promotion->code }}</strong>
                    <div id="thoigian">Thời Gian còn</div>
                </div>
                <div class="promotion-expiry">
                    <span class="countdown" data-expiry="{{ $promotion->end_date->format('Y-m-d H:i:s') }}"></span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection


