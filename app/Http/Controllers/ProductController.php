<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\product_category;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

        public function index()
        {
            // Hiển thị form thêm sản phẩm
            return view('admin.storeproduct');
        }
        public function show()
        {
            // Hiển thị form thêm sản phẩm
            return view('admin.showproduct');
        }
    
public function storeProduct(Request $request)
    {
    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required',
        'stock_quantity' => 'required',
        'manufacturer' => 'required',
        'attachments.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Đảm bảo là hình ảnh hợp lệ
        'parent_id' => 'required'
    ]);

    $images = [];
    $path = 'uploads/images';
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $image) {
            $get_name_image = $image->getClientOriginalExtension();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $new_image); 
            $images[] = $new_image;
        }
    }
    $product = new Product([
        'name' => $request->get('name'),
        'description' => $request->get('description'),
        'price' => $request->get('price'),
        'stock_quantity' => $request->get('stock_quantity'),
        'manufacturer' => $request->get('manufacturer'),
        'attachments' => json_encode($images),
    ]);
        Debugbar::debug($product);
        $product->save();
        $productId = $product->id;
        $parentId = $request->get('parent_id');
        $this->saveCategoryProduct($productId, $parentId);
        return view('admin.storeproduct')->with('success','thêm sản phẩm'.$product->name.'thành công');
 }
        public function saveCategoryProduct($product, $parentId){
            DB::table('product_categories')->insert([
                'product_id' => $product,
                'category_id' => $parentId,
            ]);
        }
    
        public function editProduct($id)
        {
            $product = Product::find($id);
    
            if (!$product) {
                return redirect()->route('product.index')->with('error', 'Không tìm thấy sản phẩm.');
            }
            return response()->json($product);
        }
    
        public function update(Request $request, $id)
        {
            $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'stock_quantity' => 'required',
                'manufacturer' => 'required',
            ]);

            $product = Product::find($id);
    
            if (!$product) {
                return redirect()->route('product.index')->with('error', 'Không tìm thấy sản phẩm.');
            }

            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->price = $request->get('price');
            $product->stock_quantity = $request->get('stock_quantity');
            $product->manufacturer = $request->get('manufacturer');
    
            $product->save();
            return response()->json(['success' => true]);
        }
    
        public function deleteProduct($id)
        {
            $product = Product::find($id);
    
            if (!$product) {
                return redirect()->route('admin.showProduct')->with('error', 'Không tìm thấy sản phẩm.');
            }
            if (file_exists(public_path('uploads/images/' . $product->attachments))) {
                unlink(public_path('uploads/images/' . $product->attachments));
            }
            $product->delete();
            return redirect()->route('admin.showProduct')->with('success', 'Sản phẩm đã được xóa thành công.');
        }
    
        public function loadProduct()
        {
            $products = Product::all();
            Debugbar::debug($products);
            return response()->json($products);
        }
    }
