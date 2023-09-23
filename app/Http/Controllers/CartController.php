<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\product;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', '!=', -1)->get();
        $cart = Session::get('cart', []);
        return view('pages.cart', ['categories1' =>$categories, 'cart' =>$cart]);
    }

    public function add($id)
    {  
        $product = product::find($id);
        Debugbar::debug($product);
        $cart =session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
        } else {
            $firstAttachment = json_decode($product->attachments)[0] ?? null;
            $cart[$id] = ['name'=>$product->name,'price'=>$product->price,'images'=>$firstAttachment, 'quantity'=>1];
        }

        session()->put('cart', $cart);
    }

    public function updateCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
                $request->session()->put('cart', $cart);
            }
        }

        return response()->json(['message' => 'Cart updated successfully']);
    }

    public function remove($productId)
    {

    $cart = Session::get('cart', []);
    if (array_key_exists($productId, $cart)) {
        unset($cart[$productId]);
        Session::put('cart', $cart);

        return response()->json(['message' => 'Xóa sản phẩm thành công.']);
    }

    return response()->json(['message' => 'Không tìm thấy sản phẩm trong giỏ hàng.'], 404);
}

    public function getCart(Request $request)
    {
        $cart = session()->get('cart', []);
        return response()->json($cart);
    }
    public function getCartItemCount()
    {
        $cart = Session::get('cart', []); // Lấy giỏ hàng từ session
        $cartItemCount = count($cart); // Đếm số lượng sản phẩm trong giỏ hàng

        return response()->json(['count' => $cartItemCount]);
    }

    // Phương thức để lấy tổng số tiền trong giỏ hàng
    public function getCartTotal()
    {
        $cart = Session::get('cart', []); // Lấy giỏ hàng từ session
        $cartTotal = 0;

        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity']; // Tính tổng số tiền
        }

        return response()->json(['total' => $cartTotal]);
    }

}
