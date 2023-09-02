<?php

namespace App\Http\Controllers\Rent;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\RelatedProductView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentMeABitController extends Controller
{
    // Restituisce 10 prodotti
    public function get_products()
    {
        $products = Product::with(['user', 'photos' => function($query) {
            $query->where('main', true);
        }])
        ->withCount(['rents as rent_count', 'feedbacks as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(rating),0)'));
        }])
        ->take(10)
        ->get()
        ->map(function($product) {
            return [
                'id' => $product->id,
                'price' => $product->price,
                'title' => $product->title,
                'description' => $product->description,
                'main_photo' => $product->photos->first() ? $product->photos->first()->url : null, // Assumendo che la relazione con le foto si chiami "photos"
                'username' => $product->user->name, // Assumendo che l'attributo per lo name sia "name"
                'average_rating' => round($product->average_rating, 2), // Arrotonda la media delle valutazioni
                'rent_count' => $product->rent_count // Numero di volte che il prodotto è stato affittato
            ];
        });


        $pageConfigs = [
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['name' => "Rent a Bit"]
        ];

        return view('/content/apps/ecommerce/app-ecommerce-shop', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'products' => $products
        ]);
    }

    // Restituisce un prodotto per ID
    public function ecommerce_detail($id)
    {
        // Prima query: Ottieni le informazioni sul prodotto principale
        $product = Product::with(['properties', 'photos', 'user'])
            ->withCount(['feedbacks as average_rating' => function($query) {
                $query->select(DB::raw('coalesce(avg(rating),0)'));
            }])
            ->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->average_rating = round($product->average_rating, 2);



        // Seconda query per i prodotti correlati
        $relatedProducts = RelatedProductView::where('product_id', $product->id)->get();


        $pageConfigs = [
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "rent/", 'name' => "Rent A Bit"], ['name' => "Shop"]
        ];

        return view('/content/apps/ecommerce/app-ecommerce-details', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }


    // Aggiunge un prodotto alla wishlist dell'utente in sessione
    public function addToWishlist($productId)
    {
        $user = Auth::user();

        $user->wishlist()->attach($productId);  // Supponendo che tu abbia definito una relazione "wishlist" nel modello User

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
