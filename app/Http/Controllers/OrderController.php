<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "product_id" => "required|exists:products,id",
            "quantity" => "required|integer|gt:0"
        ]);
        //récupérer le produit
        $product = Product::where(["id" => $request->product_id])->first();
        //vérifier si la quantité restante suffit 
        if ($product->stock < $request->quantity) {
            //retourner une erreur
            return response([
                "message" => "Quantité insuffisante pour la commande"
            ], 400);
        }
        //démarrer une transaction
        DB::beginTransaction();
        try {
            //retirer la quantité
            $product->update(["quantity" => $product->stock - $request->quantity]);
            //enregister la commande
            $order = Order::create([
                "buyer_id" => auth()->id(),
                "seller_id" => $product->user_id,
                "product_id" => $product->id,
                "quantity" => $request->quantity,
                "total_price" => $product->price * $request->quantity,
                "status" => "success"
            ]);
            $checkStock = ($product->stock > $product->min_stock);
        } catch (Exception $e) {
            DB::rollBack();
            $order = Order::create([
                "buyer_id" => auth()->id(),
                "seller_id" => $product->user_id,
                "product_id" => $product->id,
                "quantity" => $request->quantity,
                "total_price" => $product->price * $request->quantity,
                "status" => "failed"
            ]);
        }
        DB::commit();

        return response([
            "order_id" => $order->id,
            "buyer_id" => $order->buyer_id,
            "seller_id" => $order->seller_id,
            "product_id" => $product->id,
            "quantity" => $order->quantity,
            "total_price" => $order->total_price,
            "status" => $order->status,
            "created_at" => $order->created_at,
            "min_stock_ateint" => !$checkStock
        ], 201);
    }
}