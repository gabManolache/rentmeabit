<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use App\Models\ProductProp;
use Error;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'title',
            3 => 'description',
            4 => 'price',
        ];

        $search = [];

        $totalData = Product::count();

        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $priceStart = $request->input('priceStart');
        $priceEnd = $request->input('priceEnd');


        $query = Product::query();

        if (!empty($priceStart) && !empty($priceEnd)) {
            $query->whereBetween('price', [$priceStart, $priceEnd]);
        }

        if (empty($request->input('search.value'))) {
            $products = $query->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
            $products = $query->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $query->count();
        }

        $data = [];

        if (!empty($products)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($products as $product) {
                $nestedData['id'] = $product->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['title'] = $product->title;
                $nestedData['description'] = $product->description;
                $nestedData['price'] = $product->price;

                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'NoItemFound',
                'code' => 204,
                'data' => [],
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Inizia una transazione per assicurarti che tutte le operazioni abbiano successo prima di eseguire commit
    DB::beginTransaction();

    try {
        $productData = $request->only([
            'title',
            'status',
            'rents',
            'description',
            'price',
            'user_id',
        ]);

        // Crea il prodotto
        $product = Product::create($productData);

        // Gestione delle proprietà del prodotto (come nell'originale)
        if ($request->has('properties')) {
            $properties = $request->input('properties');
            foreach ($properties as $property) {
                $product->properties()->create([
                    'code' => $property['code'],
                    'label' => $property['label'],
                    'value' => $property['value'],
                ]);
            }
        }

        // Commit della transazione
        DB::commit();

        $responseData = [
            'response_code' => Response::HTTP_CREATED,
            'message' => 'Product created successfully',
            'new_id' => $product->id,
        ];

        return response()->json($responseData, Response::HTTP_CREATED);

    } catch (\Exception $e) {
        // In caso di errore, annulla la transazione e restituisci un errore
        DB::rollback();

        $responseData = [
            'response_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e,
        ];

        return response()->json($responseData, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      // Carica il prodotto con le sue proprietà e le foto
      $product = Product::with(['properties', 'photos'])->findOrFail($id);

      $responseData = [
          'response_code' => Response::HTTP_OK,
          'message' => 'Edit product',
          'product' => $product,
      ];

      return response()->json($responseData, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // Inizia una transazione per assicurarti che tutte le operazioni abbiano successo prima di eseguire commit
        DB::beginTransaction();

        try {
            // Aggiorna i dati principali del prodotto
            $product->update($request->all());

            // Gestione delle proprietà del prodotto (come nell'originale)
            if ($request->has('properties')) {
                $properties = $request->input('properties');
                foreach ($properties as $propertyData) {
                    // Trova una proprietà esistente con lo stesso ID
                    $existingProperty = $product->properties()->find($propertyData['id']);

                    if ($existingProperty) {
                        // Se esiste, aggiorna il valore
                        $existingProperty->update([
                            'value' => $propertyData['value'],
                        ]);
                    } else {
                        // Altrimenti, crea una nuova proprietà
                        $product->properties()->create([
                            'code' => $propertyData['code'],
                            'label' => $propertyData['label'],
                            'value' => $propertyData['value'],
                        ]);
                    }
                }
            }
            // Commit della transazione
            DB::commit();

            $responseData = [
                'response_code' => Response::HTTP_OK,
                'message' => 'Product updated successfully',
                'product_id' => $product->id,
            ];

            return response()->json($responseData, Response::HTTP_OK);
        } catch (\Exception $e) {
            // In caso di errore, annulla la transazione e restituisci un errore
            DB::rollback();

            $responseData = [
                'response_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal Server Error',
            ];

            return response()->json($responseData, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function addPhotos(Request $request, $productId)
    {


        $product = Product::find($productId);

        if (!$product) {
            $responseData = [
                'response_code' => Response::HTTP_NOT_FOUND,
                'message' => 'Product not found',
            ];
            return response()->json($responseData, Response::HTTP_NOT_FOUND);
        }

        $photosFiles = $request->allFiles('photos');

        if (!empty($photosFiles)) {
            $photos = [];

            foreach ($photosFiles as $file) {
                $path = $file->store('products/photos', 'public'); // Salva l'immagine nello storage

                $photos[] = [
                    'url' => asset('storage/' . $path), // Ottieni l'URL completo dell'immagine
                    'description' => '', // Imposta la descrizione se necessario
                    'width' => null, // Imposta la larghezza se necessario
                    'height' => null, // Imposta l'altezza se necessario
                ];
            }

            // Crea le foto associate al prodotto nel database
            $product->photos()->createMany($photos);

            $responseData = [
                'response_code' => Response::HTTP_CREATED,
                'message' => 'Photos added successfully',
                'product_id' => $product->id,
            ];

            return response()->json($responseData, Response::HTTP_CREATED);
        } else {
            $responseData = [
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'No photos provided',
            ];

            return response()->json($responseData, Response::HTTP_BAD_REQUEST);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            $responseData = [
                'response_code' => Response::HTTP_NOT_FOUND,
                'message' => 'Product not found',
            ];
            return response()->json($responseData, Response::HTTP_NOT_FOUND);
        }

        $product->delete();

        $responseData = [
            'response_code' => Response::HTTP_OK,
            'message' => 'Product deleted successfully',
        ];

        return response()->json($responseData, Response::HTTP_OK);
    }


    public function deletePhoto(Request $request, $productId, $photoId)
    {
        // Trova il prodotto
        $product = Product::find($productId);

        if (!$product) {
            $responseData = [
                'response_code' => Response::HTTP_NOT_FOUND,
                'message' => 'Product not found',
            ];
            return response()->json($responseData, Response::HTTP_NOT_FOUND);
        }

        // Trova la foto
        $photo = ProductPhoto::find($photoId);

        if (!$photo) {
            $responseData = [
                'response_code' => Response::HTTP_NOT_FOUND,
                'message' => 'Photo not found',
            ];
            return response()->json($responseData, Response::HTTP_NOT_FOUND);
        }

        // Verifica che la foto appartenga al prodotto specificato
        if ($photo->product_id != $product->id) {
            $responseData = [
                'response_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'Photo does not belong to the specified product',
            ];
            return response()->json($responseData, Response::HTTP_BAD_REQUEST);
        }

        // Esegui la cancellazione fisica della foto
        $photo->delete();

        $responseData = [
            'response_code' => Response::HTTP_OK,
            'message' => 'Photo deleted successfully',
        ];

        return response()->json($responseData, Response::HTTP_OK);
    }

}
