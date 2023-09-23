<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\product;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::where('parent_id', '!=', -1)->get();
        $categoriesMaster = Category::all()->where('parent_id',-1);
        $productByCategory = product::select([
            'products.id',
            'products.Name AS ProductName',
            'products.Description',
            'products.Price',
            'products.stock_quantity',
            'products.Manufacturer',
            'products.Attachments',
            'c1.Name AS CategoryName',
            'c2.Name AS ParentCategoryName'
        ])
        ->join('product_categories AS pc', 'products.id', '=', 'pc.product_id')
        ->join('categories AS c1', 'pc.category_id', '=', 'c1.id')
        ->leftJoin('categories AS c2', 'c1.parent_id', '=', 'c2.id')
        ->take(8)
        ->get();
        $latestProducts = Product::latest('updated_at')->take(6)->get();
        $topSellingProducts = Product::orderByDesc('sales')->take(6)->get();
        $randomProducts = Product::inRandomOrder()->take(6)->get();
        Debugbar::debug($latestProducts);
        return view('pages.index',['categories1' => $categories, 'categoriesMaster' => $categoriesMaster,
        'productByCategory'=>$productByCategory,'lastestProduct'=>$latestProducts,
        'topsales'=>$topSellingProducts,'randomProducts'=>$randomProducts]);
    }
}
