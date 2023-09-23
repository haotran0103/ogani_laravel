@extends('layout')
@section('content')
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        @php
                        $attachments = json_decode($product->attachments, true);
                        $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                        $formattedPrice = number_format($product->price, 0, ',', '.');
                        @endphp
                        <img class="product__details__pic__item--large"
                            src="{{ asset('/uploads/images/' . $firstAttachment) }}" alt="">
                    </div>
                    <div class="product__details__pic__slider owl-carousel">
                    @foreach ($attachments as $key =>$attachments)
                    @if ($key >= 1)
                        <img data-imgbigurl="{{ asset('/uploads/images/' . $attachments) }}"
                            src="{{ asset('/uploads/images/' . $attachments) }}" alt="">
                    @endif    
                    @endforeach
                </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>{{$product ->name}}</h3>
                    <div class="product__details__rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <span>(18 reviews)</span>
                    </div>
                    <div class="product__details__price">{{$formattedPrice}} vnd</div>
                    <p>{{$product ->description}}.</p>
                    <div class="product__details__quantity">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="text" value="1">
                            </div>
                        </div>
                    </div>
                    <a href="#" class="primary-btn">ADD TO CARD</a>
                    <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                    <ul>
                        <li><b>Số lượng còn lại:</b> <span>{{$product->stock_quantity}}</span></li>
                        <li><b>nhà | nơi sản xuất:</b> <span>{{$product->manufacturer}}</span></li>
                        <li><b>đã bán: </b> <span>{{$product ->sales}}</span></li>
                        <li><b>Share on</b>
                            <div class="share">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                aria-selected="false">Reviews <span>(1)</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Mô tả sản phẩm</h6>
                                <p>{{$product->description}}</p>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Review về sản phẩm</h6>
                                <div class="fb-comments" data-href="http://localhost:8000/detail/{{$product->id}}" data-width="" data-numposts="10"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Related Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($relatedProducts as $product)
            @php
            $attachments = json_decode($product->attachments, true);
           $firstAttachment = !empty($attachments) ? $attachments[0] : null;
           $formattedPrice = number_format($product->price, 0, ',', '.');
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{ asset('/uploads/images/' . $firstAttachment) }}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{ route('detail', ['id' => $product->id]) }}">{{ $product->name }}</a></h6>
                        <h5>{{ $formattedPrice }} vnd</h5>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</section>

<!-- Related Product Section End -->
@endsection