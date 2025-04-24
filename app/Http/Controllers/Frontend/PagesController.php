<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advocate;
use App\Models\Product;
use App\Services\ProductdetailService;
use App\Services\ShippingdetailService;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    protected $productdetailService, $shippingdetailService;

    public function __construct(ProductdetailService $productdetailService, ShippingdetailService $shippingdetailService)
    {
        $this->productdetailService = $productdetailService;
        $this->shippingdetailService = $shippingdetailService;
    }


    public function home()
    {
        $productdetail = $this->productdetailService->all();
        $shippingdetail = $this->shippingdetailService->all();

        return view('frontend.home', compact('productdetail', 'shippingdetail'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
    
        if (empty($searchTerm)) {
            return redirect('/')->with('message', 'Please enter a search term.');
        }
    
        $products = Product::where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('sku', 'like', '%' . $searchTerm . '%')
            ->with('productDetail')
            ->get();
        if ($products->isEmpty()) {
            return redirect('/')->with('message', 'No matching products found.');
        }
    
        // If products are found, show the search view
        return view('frontend.search', compact('products', 'searchTerm'));
    }
    
    
    
}
