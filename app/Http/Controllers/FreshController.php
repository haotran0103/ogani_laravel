<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\product;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class FreshController extends Controller
{
    public function index(){
        $categories = Category::where('parent_id',1)->get();
            $latestProducts = product::select([
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
                ->whereIn('c1.id',$categories->pluck('id')) 
                ->orderBy('products.created_at', 'desc') 
                ->take(6) 
                ->get();
                    $freshProducts = product::select([
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
                        ->whereIn('c1.id', $categories->pluck('id'))
                        ->inRandomOrder() 
                        ->paginate(9);    
        $topSellingProducts = Product::orderByDesc('sales')->take(6)->get();
        $categories1 = Category::where('parent_id', '!=', -1)->get();
                 Debugbar::debug($freshProducts);
                return view('pages.freshs', ['categories'=>$categories,'categories1'=>$categories1, 'latestProducts'=>$latestProducts, 'freshProducts'=>$freshProducts,'topSellingProducts'=>$topSellingProducts]);

        
    }

    }

