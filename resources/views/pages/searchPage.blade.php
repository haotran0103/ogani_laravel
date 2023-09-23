@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        @if ($results->isEmpty())
            <div class="col-md-12">
                <p>Không có kết quả tìm kiếm nào cho "{{ $query }}"</p>
            </div>
        @else
            <h3>Kết quả tìm kiếm cho "{{ $query }}"</h3>
            @foreach ($results as $product)
                @php
                    $attachments = json_decode($product->attachments, true);
                    $firstAttachment = !empty($attachments) ? asset('/uploads/images/'.$attachments[0]) : null;
                    $formattedPrice = number_format($product->price, 0, ',', '.');
                @endphp
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{ $firstAttachment }}">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="{{ route('detail', ['id' => $product->id]) }}">{{ $product->name }}</a></h6>
                            <h5>{{ $formattedPrice  }} vnd</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="product__pagination">
        {{ $results->links() }}
    </div>
</div>
@endsection
