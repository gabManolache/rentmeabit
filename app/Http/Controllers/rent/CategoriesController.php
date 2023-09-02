<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
  public function index(Request $request)
  {
      $columns = [
          1 => 'id',
          2 => 'label', // Utilizziamo 'label' anziché 'title'
          3 => 'description',
      ];

      $search = [];

      $totalData = Categories::count();

      $totalFiltered = $totalData;
      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      $valueFilter = $request->input('valueFilter');

      $query = Categories::query();

      if (!empty($valueFilter)) {
          $query->where('label', 'LIKE', "%{$valueFilter}%");
      }

      if (empty($request->input('search.value'))) {
          $categories = $query->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();
      } else {
          $search = $request->input('search.value');

          $query->where(function ($q) use ($search) {
              $q->where('label', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
          });
          $categories = $query->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();
          $totalFiltered = $query->count();
      }

      $data = [];

      if (!empty($categories)) {
          // providing a dummy id instead of database ids
          $ids = $start;

          foreach ($categories as $category) {
              $nestedData['id'] = $category->id;
              $nestedData['fake_id'] = ++$ids;
              $nestedData['label'] = $category->label;
              $nestedData['description'] = $category->description;

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

  public function store(Request $request)
    {
        $categoryData = $request->only([
            'id_parent',
            'code',
            'label',
            'description',
        ]);

        $category = Categories::create($categoryData);

        $responseData = [
            'response_code' => Response::HTTP_CREATED,
            'message' => 'Category created successfully',
            'new_id' => $category->id,
        ];

        return response()->json($responseData, Response::HTTP_CREATED);
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);

        $responseData = [
            'response_code' => Response::HTTP_OK,
            'message' => 'Edit category',
            'category' => $category,
        ];

        return response()->json($responseData, Response::HTTP_OK);
    }

    public function update(Request $request, Categories $category)
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
        $category = Categories::find($id);

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