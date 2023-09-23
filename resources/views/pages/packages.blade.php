@extends('layout')
@section('content')
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Organi Shop</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Thực phẩm đóng gói</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Danh sách loại</h4>
                        <ul>
                            @foreach ($categories as $category )
                            <li><a href="#">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="sidebar__item">
                        <div class="latest-product__text">
                            <h4>bán nhiều nhất</h4>
                            <div class="latest-product__slider owl-carousel">
                                <div class="latest-prdouct__slider__item">
                                    @php $count = 0; @endphp
                                    @foreach ($topSellingProducts as $product)
                                        @php
                                            $attachments = json_decode($product->attachments, true);
                                            $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                                            $formattedPrice = number_format($product->price, 0, ',', '.');
                                        @endphp
                                        @if ($count < 3)
                                            <a href="{{ route('detail', ['id' => $product->id]) }}" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="{{ asset('/uploads/images/' . $firstAttachment) }}" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6>{{ $product->name }}</h6>
                                                    <span>${{ $formattedPrice }} vnd</span>
                                                </div>
                                            </a>
                                            @php $count++; @endphp
                                        @else
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                                <div class="latest-prdouct__slider__item">
                                    @php $count = 0; @endphp
                                    @for ($i = count($topSellingProducts) - 3; $i < count($topSellingProducts); $i++)
                                        @php
                                            $product = $topSellingProducts[$i];
                                            $attachments = json_decode($product->attachments, true);
                                            $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                                        @endphp
                                        <a href="{{ route('detail', ['id' => $product->id]) }}" class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ asset('/uploads/images/' . $firstAttachment) }}" alt="">
                                            </div>
                                            <div class="latest-product__item__text">
                                                <h6>{{ $product->name }}</h6>
                                                <span>${{ $formattedPrice }} vnd</span>
                                            </div>
                                        </a>
                                        @php $count++; @endphp
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7">
                <div class="product__discount">
                    <div class="section-title product__discount__title">
                        <h2>Mới nhất</h2>
                    </div>
                    <div class="row">
                        <div class="product__discount__slider owl-carousel">

                            @foreach ($latestProducts as $latestProducts)
                            @php
                                $attachments = json_decode($latestProducts->Attachments, true);
                                $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                                $formattedPrice = number_format($latestProducts->Price, 0, ',', '.');
                            @endphp
                            <div class="col-lg-12">
                                <div class="product__discount__item">
                                    <div class="product__discount__item__pic set-bg"
                                        data-setbg="{{ asset('/uploads/images/'.$firstAttachment) }}">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product__discount__item__text">
                                        <span>{{$latestProducts->CategoryName}}</span>
                                        <h5><a href="{{ route('detail', ['id' => $latestProducts->id]) }}">{{$latestProducts->ProductName}}</a></h5>
                                        <div class="product__item__price">{{$formattedPrice}} vnd</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select>
                                    <option value="0">Default</option>
                                    <option value="0">Default</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($freshProducts as $product)
                    @php
                        $attachments = json_decode($product->Attachments, true);
                        $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                        $formattedPrice = number_format($product->Price, 0, ',', '.');
                    @endphp
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset('/uploads/images/'.$firstAttachment) }}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="{{ route('detail', ['id' => $product->id]) }}">{{ $product->ProductName  }}</a></h6>
                                <h5>{{ $formattedPrice }} vnd</h5>
                            </div>
                        </div>
                    </div> 
                    @endforeach
                    
                </div>
                <div class="product__pagination">
                    {{ $freshProducts->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection