<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductsCollection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProductsCollection
     */
    public function index()
    {
        return new ProductsCollection(
            Product::all(Product::PRODUCT_FIELDS)->sortBy('sort')->values()
        );
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
