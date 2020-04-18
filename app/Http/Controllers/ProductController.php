<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Resources\ProductsCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProductsCollection
     */
    public function index()
    {
        $dataCacheKey = env('PRODCUTS_CACHE_KEY', 'products_cache_key') . '_data';
        return Cache::remember($dataCacheKey, 24*60*60, function () {
            return new ProductsCollection(
                Product::all(Product::PRODUCT_FIELDS)->sortBy('sort')->values()
            );
        });
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        return $game = Product::findOrFail($product);
    }
}
