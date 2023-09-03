<?php

namespace App\Http\Controllers\Api\Rent;

use App\Http\Controllers\Controller;
use App\Http\Services\Rent\RentMeABitService;

class ApiRentMeABitController extends Controller {

    protected $rentService;

    public function __construct(RentMeABitService $rentService) {

        $this->rentService = $rentService;

    }

    // Restituisce 10 prodotti
    public function get_products() {

        $response = $this->rentService->get_products();
        return response()->json($response);

    }

    // Restituisce un prodotto per ID
    public function ecommerce_detail($id) {

        $response = $this->rentService->ecommerce_detail($id);
        return response()->json($response);

    }


    // Aggiunge un prodotto alla wishlist dell'utente in sessione
    public function addToWishlist($productId)
    {
        $response = $this->rentService->addToWishlist($productId);
        return response()->json($response);
    }

    // Crea un nuovo ordine (Semplificato)
    public function checkout()
    {
        $response = $this->rentService->checkout();
        return response()->json($response);
    }
}
