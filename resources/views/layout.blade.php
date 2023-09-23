<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}" type="text/css">
</head>
<style>
    .header__top__left,
    .header__top__right {
        display: flex;
        align-items: center;
    }

    .header__top__right__auth {
        margin-left: auto; /* Đẩy phần tử này sang phải cùng */
        display: flex;
        align-items: center;
    }

    .auth-divider {
        margin: 0 10px; /* Khoảng cách giữa các phần tử */
    }

#category-list ul li:nth-child(n+13) {
    display: none;
}
/* Loại bỏ đường viền cho nút "Xem thêm" */
#show-more-button {
    background-color: #7fad39;
    border: none;
    width: 100%;
    outline: none; 
}

#category-list ul {
    padding-left: 0;
    list-style-type: none;
}

#category-list ul li {
    border-bottom: 1px solid #ccc;
    padding: 5px 0; 
}

#category-list ul li:last-child {
    border-bottom: none;
}
/* CSS cho phần gợi ý tìm kiếm */
#autocomplite {
    display: none;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    width: 100%;
    max-height: auto; /* Sửa đổi max-height thành auto */
    /* Loại bỏ thuộc tính overflow-y */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    z-index: 100;
}


#autocomplite li {
    list-style-type: none;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.2s; /* Hiệu ứng hover */
}

#autocomplite li:hover {
    background-color: #f5f5f5; /* Màu nền khi hover */
}
.product-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 10px;
}

</style>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="img/logo.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__auth">
                <a href="{{route('login')}}"><i class="fa fa-user"></i> Đăng nhập</a>
            </div>
            <div class="header__top__right__auth">
                <a href="{{route('login')}}"><i class="fa fa-user"></i> Đăng ký</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="active"><a href="{{route('home')}}">Trang Chủ</a></li>
                <li><a href="{{route('fresh')}}">Thực phẩm tươi</a></li>
                <li><a href="{{route('Package')}}">Thực phẩm đóng gói</a></li>
                <li><a href="{{route('nutritional')}}">Thực phẩm dinh dưỡng</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> tranquochao0102@gmail.com</li>
                                <li>Giao tận nhà free ship</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__auth">
                                @auth
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user"></i> {{ Auth::user()->first_name." ".Auth::user()->last_name}}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                                            @if (Auth::user()->isAdmin())
                                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Đi tới dashboard</a>
                                                <div class="dropdown-divider"></div>
                                            @endif
                                            @if (!Auth::user()->isAdmin())
                                                <a class="dropdown-item" href="{{ route('viewProfile', ['id' => Auth::user()->id]) }}">Xem trang cá nhân</a>
                                                <div class="dropdown-divider"></div>
                                            @endif
                                            <a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                                    <span class="auth-divider">|</span> 
                                    <a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Đăng ký</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ route('home') }}">Trang Chủ</a></li>
                            <li class="{{ request()->is('fresh') ? 'active' : '' }}"><a href="{{ route('fresh') }}">TP Tươi</a></li>
                            <li class="{{ request()->is('package') ? 'active' : '' }}"><a href="{{ route('Package') }}">TP Đóng gói</a></li>
                            <li class="{{ request()->is('nutritional') ? 'active' : '' }}"><a href="{{ route('nutritional') }}">TP Dinh dưỡng</a></li>
                        </ul>
                    </nav>
                    
                </div>
                <div class="col-lg-3">
                    <div class="header__cart cart">
                        <ul >
                            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                            <li style="position: relative" id="cart-icon"><a href="{{route('cart.index')}}"><i class="fa fa-shopping-bag"></i> 
                                <span id="cart-item-count">0</span></a>
                                
                                <div class="cart-items" id="cart-items" style="left: -200px;width: max-content;;top: 20px;position: absolute;z-index: 100;border: 1px solid #ccc; background-color: #fff">
                                    <!-- Hiển thị các sản phẩm trong giỏ hàng ở đây -->
                                </div> </li>
                        </ul>
                        <div class="header__cart__price"><p>Tổng cộng: <span id="cart-total">0.00</span> vnd</p></div>
                        
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Các Loại mặt hàng</span>
                        </div>
                        <div id="category-list">
                            <ul>
                                @foreach ($categories1 as $category)
                                    <li><a href="{{ route('filter', ['id' => $category->id]) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                                <button id="show-more-button">Xem thêm <i class="fa fa-angle-down"></i></button>
                            </ul>
                        </div>                        
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero__search form-group">
                        <div class="hero__search__form input-group col-xs-11" style="position: relative ;">
                            <form action="{{route('search')}}" id="search-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input style="width: 100%;" type="text" id="search-input" placeholder="What do you need?" name="query">
                                <button type="submit" class="site-btn" style="right: 55px;">SEARCH</button>
                            </form>
                        </div>
                        <ul id="autocomplite" class="autocomplite list-group row">
                            <!-- Các mục gợi ý sẽ được thêm bằng JavaScript -->
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+65 11.188.888</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </section>
    <!-- Hero Section End -->
    @yield('content')
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="img/logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 60-49 Road 11378 New York</li>
                            <li>Phone: +65 11.188.888</li>
                            <li>Email: hello@colorlib.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Useful Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">About Our Shop</a></li>
                            <li><a href="#">Secure Shopping</a></li>
                            <li><a href="#">Delivery infomation</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Our Sitemap</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Who We Are</a></li>
                            <li><a href="#">Our Services</a></li>
                            <li><a href="#">Projects</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Innovation</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Join Our Newsletter Now</h6>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#">
                            <input type="text" placeholder="Enter your mail">
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p></div>
                        <div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v18.0" nonce="779JqIQQ"></script>
    <!-- Js Plugins -->
    <script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js')}}"></script>
    <script src="{{ asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('js/jquery.slicknav.js')}}"></script>
    <script src="{{ asset('js/mixitup.min.js')}}"></script>
    <script src="{{ asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('js/main.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

    <script>
// Trước hàm document.ready, thêm đoạn CSS cho các thẻ gợi ý <li>
    $('#autocomplite li').css({
    'display': 'flex',
    'align-items': 'center'
});

$(document).ready(function () {
    var searchInput = $('#search-input');
    var autoComplete = $('#autocomplite');

    searchInput.typeahead({
        minLength: 1,
        highlight: true,
        hint: false
    }, {
        source: function (query, process) {
            $.ajax({
                url: '{{ route('searchProducts') }}', 
                method: 'GET',
                data: { query: query },
                success: function (data) {
                    console.log(data);
                    autoComplete.empty();
                    $.each(data, function(index, item) {

                        var image = item.attachment;

                        var imageSrc = "{{ asset('/uploads/images/') }}" + '/' + image;
                        var liBtn = $('<li><div class="row"><div class="col-md-3"><img src="' + imageSrc + '" alt="Product Image"></div><div class="col-md-9"><div class="product-info"><div class="product-name">' + item.value + '</div><div class="product-price">$' + item.price + '</div></div></div></div></li>');

                        liBtn.on('click', function() {
                            searchInput.val(item.value);
                            autoComplete.hide();
                        });
                        autoComplete.append(liBtn); 

                        var imgElement = liBtn.find('img');
                        imgElement.css({
                            'width': '60px', 
                            'height': '60px' 
                        });
                    });
                },
                error: function (error) {
                    console.error(error);
                }
            });
        },  
    });

    var categoryList = $('#category-list ul li');
    var showMoreButton = $('#show-more-button');
    
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
    searchInput.on('input', function () {
        if (searchInput.val() === '') {
            autoComplete.hide(); 
        } else {
            autoComplete.show();
        }
    });
});

      </script>
<script>
    $(document).ready(function() {
        function addToCard(event){
            event.preventDefault();
            var urlCart = $(this).data('url');
            $.ajax({
                url: urlCart,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    alert('Sản phẩm đã được thêm vào giỏ hàng!');
                    location.reload();
                },
                error: function() {
                    alert('Sản phẩm đã được thêm vào giỏ hàng!');
                }
            });
        }

        $(function(){
            $('.add-to-cart-button').on('click', addToCard)
        });
$('.fa-shopping-bag').on({
    mouseenter: function () {
        showCart();
    },
    mouseleave: function () {
    }
});

function showCart() {
    $.ajax({
        url: '{{ route('cart.get') }}',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (Object.keys(response).length > 0) {
                var cartItems = $('#cart-items');
                cartItems.empty(); // Xóa nội dung cũ

                for (var key in response) {
                    if (response.hasOwnProperty(key)) {
                        var item = response[key];
                        var image = "{{ asset('/uploads/images/') }}" + '/' + item.images; // Tạo URL cho hình ảnh

                        var cartItem = `
                            <div class="cart-item">
                                <div class="cart-item__info row">
                                    <img class="col-2" src="${image}" alt="${item.name}" style="width: 30px; height: auto;">
                                    <span class="col-4">${item.name}</span>
                                    <span class="col-2">$${item.price}</span>
                                    <span class="col-2">${item.quantity}</span>
                                    <button class="col-2 remove-from-cart-button" data-url="${key}">Xóa</button>
                                </div>
                            </div>
                        `;
                        cartItems.append(cartItem);
                    }
                }
            }
        },
        error: function () {
            alert('Đã xảy ra lỗi khi lấy thông tin giỏ hàng.');
        }
    });
}


$('.fa-shopping-bag').mouseleave(function () {
    var cartItems = $('#cart-items');
    cartItems.empty();
});
function updateCartItemCount() {
    $.ajax({
        url: '{{ route('cart.count') }}',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            $('#cart-item-count').text(response.count);
        },
        error: function () {
            alert('Đã xảy ra lỗi khi cập nhật số lượng sản phẩm trong giỏ hàng.');
        }
    });
}
function updateCartTotal() {
    $.ajax({
        url: '{{ route('cart.total') }}',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            $('#cart-total').text(response.total);
        },
        error: function () {
            alert('Đã xảy ra lỗi khi cập nhật tổng số tiền trong giỏ hàng.');
        }
    });
}
$(document).on('click', '.remove-from-cart-button', function(event) {
        event.preventDefault();
        var urlCart = $(this).data('url');
        $.ajax({
            url: '/cart/remove/'+urlCart,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                alert('Sản phẩm đã được xóa khỏi giỏ hàng.');
            },
            error: function() {
                alert('Đã xảy ra lỗi khi xóa sản phẩm khỏi giỏ hàng.');
            }
        });
    });
$(document).ready(function () {
    updateCartItemCount();
    updateCartTotal();
});


$(document).ready(function () {
    updateCartInfo();
});

    });
</script>
</body>

</html>