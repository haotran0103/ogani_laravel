@extends('layout')
@section('content')
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($cart as $key => $product)
                            <tr>
                                <td class="shoping__cart__item">
                                    <img style="width: 200px; height: auto;" src="{{ asset('/uploads/images/'.$product['images']) }}" alt="">
                                    <h5>{{$product['name']}}</h5>
                                </td>
                                <td class="shoping__cart__price">
                                    {{$product['price']}}
                                </td>
                                <td class="shoping__cart__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="number" class="quantity-input" value="{{$product['quantity']}}" min="1">
                                        </div>
                                    </div>
                                </td>
                                <td class="shoping__cart__total">
                                    {{$product['price'] * $product['quantity']}}
                                </td>
                                <td class="shoping__cart__item__close close-button" data-url="{{$key}}">
                                    <span class="icon_close"></span>
                                </td>                                
                            </tr>
                            @php
                                $total = $total + $product['price'] * $product['quantity']
                            @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <a href="#" class="primary-btn cart-btn cart-btn-right update-cart-button"><span class="icon_loading"></span>
                        Upadate Cart</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span>{{$total}}</span></li>
                        <li>Total <span>{{$total}}</span></li>
                    </ul>
                    <a href="{{route('cart.checkout')}}" name="redirect" class="primary-btn">PROCEED TO CHECKOUT</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Đầu tiên, đảm bảo rằng bạn đã bao gồm thư viện jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.update-cart-button', function(e) {
        e.preventDefault();
    
        var productId = $(this).data('product-id');
        var quantity = $(this).siblings('.quantity-input').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
        $.ajax({
            url: "{{ route('update.cart') }}",
            method: "POST",
            data: { 
                product_id: productId, 
                quantity: quantity,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: "json",
            success: function(response) {
                if (response.message === "Cart updated successfully") {
                    alert("Cart updated successfully");
                    location.reload();
                }
            }
        });
    });
    
    $(document).on('click', '.close-button', function(e) {
        event.preventDefault();
        var urlCart = $(this).data('url');
        $.ajax({
            url: '/cart/remove/'+urlCart,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                alert('Sản phẩm đã được xóa khỏi giỏ hàng.');
                location.reload();
            },
            error: function() {
                alert('Đã xảy ra lỗi khi xóa sản phẩm khỏi giỏ hàng.');
            }
        });
    });
    </script>
    
    
