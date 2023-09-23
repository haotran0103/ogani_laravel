<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    public function index(){

        $categories = Category::where('parent_id', '!=', -1)->get();
        $cart = Session::get('cart', []);
        return view('pages.fillInfomation',['categories1' =>$categories, 'cart' =>$cart]);
    }
    public function vnpay_checkout(Request $request){
        $data = $request->all();
        $cart = Session::get('cart', []);
        $cart = Session::get('cart', []);
        $info = ''; 
        $total = 0;
        foreach ($cart as $key => $product) {
            $productName = $product['name'];
            $productPrice = $product['price'];
            $productQuantity = $product['quantity'];
            $total += $productPrice * $productQuantity;
            $info .= "Key: $key, Tên sản phẩm: $productName, Giá: $productPrice, Số lượng: $productQuantity\n";
        }

        $id_Cart = rand(0,9999999);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "https://localhost/vnpay_php/vnpay_return.php";
        $vnp_TmnCode = "0D41YBIL";//Mã website tại VNPAY 
        $vnp_HashSecret = "RNHPVPGCFJKQKYUCVMGXUGWBFHTNDRCB"; //Chuỗi bí mật

        $vnp_TxnRef = $id_Cart;
        $vnp_OrderInfo = $data['address']. ' '.$info.''. $data['first_name'] .''. $data['last_name'] .''. $data['phoneNumber'];
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        //Billing
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                $order = new Order();
                $order->customer_name = $data['first_name'] . ' ' . $data['last_name']; // Tên khách hàng
                $order->order_date = now(); // Ngày đặt hàng
                $order->total_amount = $total; // Tổng số tiền đơn hàng
                $order->save();

                $orderID = $order->id;
                foreach ($cart as $product) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $orderID; // ID của đơn hàng
                    $orderDetail->product_id = $product['id']; // ID của sản phẩm (nếu có)
                    $orderDetail->quantity = $product['quantity']; // Số lượng sản phẩm
                    $orderDetail->price = $product['price']; // Giá sản phẩm
                    $orderDetail->save();
                }
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }
}
