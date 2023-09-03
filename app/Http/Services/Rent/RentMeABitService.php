<?php

namespace App\Http\Services\Rent;

use App\Models\Order;
use App\Models\Product;
use App\Models\RelatedProductView;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentMeABitService
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

        $response = [
            'message' => 'Recupero riuscito',
            'products' => $products,
            'code' => Response::HTTP_OK
        ];

        return $response;
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
            $response = [
                'message' => 'Product not found',
                'code' => Response::HTTP_NO_CONTENT,
                'data' => [],
            ];
        }else{

            $product->average_rating = round($product->average_rating, 2);
            // Seconda query per i prodotti correlati
            $relatedProducts = RelatedProductView::where('product_id', $product->id)->get();

            $response = [
                'message' => 'Recupero riuscito',
                'product' => $product,
                'related_products' => $relatedProducts,
                'code' => Response::HTTP_OK
            ];
        }

        return $response;

    }


    // Aggiunge un prodotto alla wishlist dell'utente in sessione
    public function addToWishlist($productId)
    {
        $user = Auth::user();

        $user->wishlist()->attach($productId);  // Supponendo che tu abbia definito una relazione "wishlist" nel modello User

        $response = [
            'message' => 'Product added to wishlist',
            'code' => Response::HTTP_CREATED,
            'data' => [],
        ];

        return $response;
    }

    // Crea un nuovo ordine (Semplificato)
    public function checkout()
    {
        $user = Auth::user();

        $order = new Order();  // Supponendo che tu abbia un modello Order
        $order->user_id = $user->id;
        // Altri campi...
        $order->save();

        $response = [
            'message' => 'Order created',
            'order_id' => $order->id,
            'code' => Response::HTTP_CREATED,
            'data' => [],
        ];

        return $response;
    }
}
