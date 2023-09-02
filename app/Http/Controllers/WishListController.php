<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    // Restituisce 10 prodotti
    public function getTenProducts()
    {
        $products = Product::with('photos')
                            ->take(10)
                            ->get();

        return response()->json($products);
    }

    // Restituisce un prodotto per ID
    public function getProductById($id)
    {
        $product = Product::with('properties', 'photos')
                          ->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    // Aggiunge un prodotto alla wishlist dell'utente in sessione
    public function addToWishlist($productId)
    {
        $user = Auth::user();
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $wishlist = new WishList();
        $wishlist->user_id = $user->id;
        $wishlist->product_id = $product->id;
        $wishlist->saved_price = $product->price;
        $wishlist->save();

        return response()->json(['message' => 'Product added to wishlist']);
    }

    // Crea un nuovo ordine (Semplificato)
    public function checkout()
    {
        $user = Auth::user();

        $order = new Order();  // Supponendo che tu abbia un modello Order
        $order->user_id = $user->id;
        // Altri campi...
        $order->save();

        return response()->json(['message' => 'Order created', 'order_id' => $order->id]);
    }
}
