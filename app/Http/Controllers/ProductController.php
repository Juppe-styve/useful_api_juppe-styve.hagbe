<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where(["user_id" => auth()->id()])->get();
        return response([
            ProductResource::collection($products)
        ], 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "price" => "required|numeric|gt:0",
            "stock" => "required|integer|gte:0",
            "min_stock" => "required|integer|gte:0",
        ]);
        try {
            $product = Product::create([
                "name" => $request->name,
                "stock" => $request->stock,
                "min_stock" => $request->min_stock,
                "price" => $request->price,
                "user_id" => auth()->id()
            ]);
            return response([
                $product
            ], 201);
        } catch (Exception $e) {
        }
    }

    public function restock(Request $request, $id)
    {
        $request->validate([
            "quantity" => "required|integer|gt:0"
        ]);
        $product = Product::where(['id' => $id])->first();
        if ($product->user_id == auth()->id()) {
            if (!$product) {
                return response([
                    "error" => "no product found"
                ], 400);
            }
            try {
                $product->update(['stock' => $product->stock + $request->quantity]);
                return response([
                    "product_id" => $id,
                    "new_stock" => $product->stock,
                    "restocked_quantity" => $request->quantity
                ], 200);
            } catch (Exception $e) {
                return response([
                    "error" => "try later"
                ], 400);
            }
        } else {
            return response([
                "error" => "can't update this product"
            ], 403);
        }
    }
}