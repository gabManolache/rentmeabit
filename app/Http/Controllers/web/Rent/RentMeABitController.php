<?php

namespace App\Http\Controllers\Web\Rent;

use App\Http\Controllers\Controller;
use App\Http\Services\Rent\RentMeABitService;
use Illuminate\Http\Response;

class RentMeABitController extends Controller
{

    protected $rentService;

    public function __construct(RentMeABitService $rentService) {

        $this->rentService = $rentService;

    }

    // Restituisce 10 prodotti
    public function get_products() {

        $response = $this->rentService->get_products();

        $pageConfigs = [
            'contentLayout' => "content-detached-left-sidebar",
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['name' => "Rent a Bit"]
        ];

        return view('/content/ecommerce/app-ecommerce-shop', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'response' => $response
        ]);

    }

    // Restituisce un prodotto per ID
    public function ecommerce_detail($id) {

        $response = $this->rentService->ecommerce_detail($id);

        if ($response['code'] == Response::HTTP_NO_CONTENT) {
            // TODO da ritornare la vista 404
            return response()->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $pageConfigs = [
            'pageClass' => 'ecommerce-application',
        ];

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "pages/rent", 'name' => "Rent A Bit"], ['name' => "Shop"]
        ];

        return view('/content/ecommerce/app-ecommerce-details', [
            'pageConfigs' => $pageConfigs,
            'breadcrumbs' => $breadcrumbs,
            'response' => $response
        ]);

    }


    // Aggiunge un prodotto alla wishlist dell'utente in sessione
    public function addToWishlist($productId) {

        $response = $this->rentService->addToWishlist($productId);
        return response()->json($response);

    }

    // Crea un nuovo ordine (Semplificato)
    public function checkout() {

        $response = $this->rentService->checkout();

        return response()->json($response);

    }
}
