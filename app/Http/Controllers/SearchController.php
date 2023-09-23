<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\product;
use App\Models\product_category;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class SearchController extends Controller
{
    public function index(Request $request){
        $query = $request->get('query');
    
        $query = strtolower($query);

    // Sử dụng điều kiện LIKE với ký tự '%' để tìm kiếm một phần của từ khóa
        $results = Product::whereRaw('LOWER(Name) LIKE ?', ["%{$query}%"])
                        ->orWhereRaw('LOWER(Description) LIKE ?', ["%{$query}%"])
                        ->paginate(12);

        $categories1 = Category::where('parent_id', '!=', -1)->get();
        Debugbar::debug($results);
        return view('pages.searchPage', ['results' => $results, 'query' => $query,'categories1'=>$categories1]);
    }
    
    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
    
        $results = Product::where('name', 'like', '%' . $query . '%')->take(5)->get();
    
        $data = [];
        foreach ($results as $result) {
            $firstAttachment = json_decode($result->attachments)[0] ?? null;
            
            // Tạo một mảng chứa thông tin bạn muốn hiển thị
            $data[] = [
                'value' => $result->name,
                'price' => $result->price,
                'attachment' => $firstAttachment,
            ];
        }
    
        Debugbar::debug($data);
        return response()->json($data);
    }
    
    public function filter($id){
        $categories = Category::where('id', '!=', -1)->get();
        $category = Category::findOrFail($id);
        
        // Sử dụng phân trang cho danh sách sản phẩm
        $products = $category->products()->paginate(12);
    
        return view('pages.filters', ['products' => $products, 'categories' => $categories]);
    }
    public function detail($id){

        $currentProductCategoryIds = product_category::where('product_id', $id)
        ->pluck('category_id')
        ->toArray();

    // Lấy các sản phẩm có cùng CategoryID với sản phẩm hiện tại
    $relatedProducts = product_category::select('products.*')
        ->join('products', 'product_categories.product_id', '=', 'products.id')
        ->where('product_categories.product_id', '!=', $id)
        ->whereIn('product_categories.category_id', $currentProductCategoryIds)
        ->take(4)
        ->get();
        $product = Product::find($id);
        $categories1 = Category::where('parent_id', '!=', -1)->get();
    
        $response = new Response(view('pages.productDetail', ['product' => $product, 'categories1' => $categories1, 'relatedProducts'=>$relatedProducts]));
    
        $cookie = cookie('myCookie', 'cookieValue', 60, '/', '', false, true); 
        $response->withCookie($cookie);
    
        return $response;
    }
    
}
