<?php

namespace App\Http\Services\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryService {


  public function index(Request $request) {

      $columns = [
          1 => 'id',
          2 => 'label', // Utilizziamo 'label' anziché 'title'
          3 => 'description',
      ];

      $search = [];

      \Log::debug('Order Column: ' . $request['length']);

      $totalData = Category::count();

      $totalFiltered = $totalData;
      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      $valueFilter = $request->input('valueFilter');

      $query = Category::query();

      if (!empty($valueFilter)) {
          $query->where('label', 'LIKE', "%{$valueFilter}%");
      }
           // Se c'è una ricerca generica o una ricerca per colonna
            if (!empty($request->input('search.value')) || !empty($request->input('columns'))) {

                $query->where(function($query) use ($request, $columns) {

                    // Ricerca generica
                    if (!empty($request->input('search.value'))) {
                        $search = $request->input('search.value');
                        $query->where('label', 'LIKE', "%{$search}%")
                            ->orWhere('description', 'LIKE', "%{$search}%");
                    }
                        foreach ($request->input('columns') as $column) {

                            \Log::debug('Colonna: ' .  $column['data']);
                            \Log::debug('Ricerca per colonna: ' .  $column['search']['value']);

                            $columnName = $column['data'] ?? null;
                            $searchValue = $column['search']['value'] ?? null;

                            \Log::debug('Colonna: ' .  $columnName . ' value: ' . $searchValue);

                            if ($columnName && $searchValue) {
                                $query->orWhere($columnName, 'LIKE', "%{$searchValue}%");
                            }
                        }

                });
            }

            $categories = $query->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $query->count();


      $data = [];

      if (!empty($categories)) {
          // providing a dummy id instead of database ids
          $ids = $start;

          foreach ($categories as $category) {
              $nestedData['id'] = $category->id;
              $nestedData['parent_id'] = $category->parent_id;
              $nestedData['fake_id'] = ++$ids;
              $nestedData['label'] = $category->label;
              $nestedData['description'] = $category->description;

              $data[] = $nestedData;
          }
      }

      if ($data) {
          $response = [
            'message' => 'Recupero riuscito',
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => Response::HTTP_OK,
            'data' => $data,
        ];
      } else {
          $response = [
            'message' => 'NoItemFound',
            'code' => Response::HTTP_NO_CONTENT,
            'data' => [],
        ];
      }

      return $response;
  }



    public function store(Request $request) {

        $categoriesData = $request->input('categories', []);

        $rootIds = [];

        // Itera attraverso ogni categoria "padre" nel payload della richiesta
        foreach ($categoriesData as $categoryData) {
            $rootCategory = $this->createCategory($categoryData);
            $rootIds[] = $rootCategory->id;
        }

        // Ritorna la risposta
        $response = [
            'code' => Response::HTTP_CREATED,
            'message' => 'Categories created successfully',
            'root_ids' => $rootIds,
        ];

        return $response;
    }

    // Funzione ausiliaria per creare una categoria e le sue sottocategorie
    private function createCategory($data, $parent_id = null) {


        \Log::debug('Order Column: ' . $data['code']);
        \Log::debug('Order Column: ' . $data['label']);
        \Log::debug('Order Column: ' . $data['description']);

        // Imposta l'ID del genitore
        $data['parent_id'] = $parent_id;

        // Crea la categoria
        $category = Category::create([
            'parent_id' => $data['parent_id'],
            'code' => $data['code'],
            'label' => $data['label'],
            'description' => $data['description'],
        ]);

        // Se ci sono sottocategorie, crea anche quelle
        if (isset($data['subcategories'])) {
            foreach ($data['subcategories'] as $subcat) {
                $this->createCategory($subcat, $category->id);
            }
        }

        return $category;
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $responseData = [
            'response_code' => Response::HTTP_OK,
            'message' => 'Edit category',
            'category' => $category,
        ];

        return response()->json($responseData, Response::HTTP_OK);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());

        $responseData = [
            'response_code' => Response::HTTP_OK,
            'message' => 'Category updated successfully',
            'category_id' => $category->id,
        ];

        return response()->json($responseData, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            $responseData = [
                'response_code' => Response::HTTP_NOT_FOUND,
                'message' => 'Category not found',
            ];
            return response()->json($responseData, Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        $responseData = [
            'response_code' => Response::HTTP_OK,
            'message' => 'Category deleted successfully',
        ];

        return response()->json($responseData, Response::HTTP_OK);
    }

}
