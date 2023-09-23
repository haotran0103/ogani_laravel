@extends('layout')
@section('content')
<section class="hero" style="z-index: 1">
    <div class="container">
        <div class="row">

            <div class="col-lg-12">
                <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
                    <div class="hero__text">
                        <span>Rau củ sạch</span>
                        <h2>Rau củ <br />100% Organic</h2>
                        <p>Cập nhật mỗi ngày và thường xuyên</p>
                        <a href="#" class="primary-btn">Mua ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="img/categories/cat-1.jpg">
                        <h5><a href="#">Trái cây</a></h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="img/categories/cat-2.jpg">
                        <h5><a href="#">các loại hat</a></h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="img/categories/cat-3.jpg">
                        <h5><a href="#">rau củ</a></h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="img/categories/cat-4.jpg">
                        <h5><a href="#">Nước trái cây</a></h5>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="img/categories/cat-5.jpg">
                        <h5><a href="#">Thịt tươi</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Sản phẩm nỗi bật</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        @if (!function_exists('slugify_'))
                        @php
                        function slugify_($string) {
                            $string = strtolower(trim($string));
                            $string = preg_replace('/[^a-z0-9-]+/', '-', $string);
                            $string = preg_replace('/-+/', '-', $string); 
                            return $string;
                        }
                        @endphp
                    @endif
                        @foreach ($categoriesMaster as $category)
                        <li data-filter=".{{ slugify_($category->name) }}">{{ $category->name }}</li>
                        @endforeach
                    </ul>                    
                </div>
                
            </div>
        </div>
        <div class="row featured__filter">
            @php $productCount = 0; @endphp
            @foreach ($productByCategory as $product)
                @php
                    $attachments = json_decode($product->Attachments, true);
                    $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                    $parentCategorySlug = slugify_($product->ParentCategoryName);
                    $formattedPrice = number_format($product->Price, 0, ',', '.');
                @endphp
        
                @if ($productCount < 12)
                <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $parentCategorySlug ?: slugify_($product->CategoryName) }} fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="{{ asset('/uploads/images/' . $firstAttachment) }}">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#" class="add-to-cart-button" data-url="{{ route('cart.add',['id' =>$product->id ])}}"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="{{ route('detail', ['id' => $product->id]) }}">{{ $product->ProductName }}</a></h6>
                            <h5>{{ $formattedPrice }} vnd</h5>
                        </div>
                    </div>
                </div>
                
                    @php $productCount++; @endphp
                @else
                    @break
                @endif
            @endforeach
        </div>
               
    </div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="img/banner/banner-2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>sản phẩm mới nhất</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            @php $count = 0; @endphp
                            @foreach ($lastestProduct as $product)
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
                            @for ($i = count($lastestProduct) - 3; $i < count($lastestProduct); $i++)
                                @php
                                    $product = $lastestProduct[$i];
                                    $attachments = json_decode($product->attachments, true);
                                    $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                                    $formattedPrice = number_format($product->price, 0, ',', '.');
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
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>sản phẩm bán nhiều nhất</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            @php $count = 0; @endphp
                            @foreach ($topsales as $product)
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
                            @for ($i = count($topsales) - 3; $i < count($topsales); $i++)
                                @php
                                    $product = $topsales[$i];
                                    $attachments = json_decode($product->attachments, true);
                                    $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                                    $formattedPrice = number_format($product->price, 0, ',', '.');
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
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>sản phẩm bất kỳ</h4>
                    <div class="latest-product__slider owl-carousel">
                        <div class="latest-prdouct__slider__item">
                            @php $count = 0; @endphp
                            @foreach ($randomProducts as $product)
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
                            @for ($i = count($randomProducts) - 3; $i < count($randomProducts); $i++)
                                @php
                                    $product = $randomProducts[$i];
                                    $attachments = json_decode($product->attachments, true);
                                    $firstAttachment = !empty($attachments) ? $attachments[0] : null;
                                    $formattedPrice = number_format($product->price, 0, ',', '.');
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
</section>
<!-- Latest Product Section End -->

<!-- Blog Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-1.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">Cooking tips make cooking simple</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-2.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="img/blog/blog-3.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">Visit the clean farm in the US</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var categoryList = $('#category-list1 ul li');
        var showMoreButton = $('#show-more-button1');
        
        var isExpanded = false;
    
        showMoreButton.on('click', function () {
            if (isExpanded) {
                categoryList.slice(12).slideUp();
                showMoreButton.html('Xem thêm <i class="fa fa-angle-down"></i>');
            } else {
                categoryList.slice(12).slideDown();
                showMoreButton.html('Ẩn <i class="fa fa-angle-up"></i>');
            }
            
            isExpanded = !isExpanded;
        });
    });
          </script>
<!-- Blog Section End -->

@endsection
