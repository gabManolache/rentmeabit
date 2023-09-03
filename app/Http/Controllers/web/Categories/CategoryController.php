<?php

namespace App\Http\Controllers\Web\Categories;

use App\Http\Controllers\Controller;
use App\Http\Services\Categories\CategoryService;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    protected $categoryService;

    public function __construct(CategoryService $categoryService) {

        $this->categoryService = $categoryService;

    }

    public function show_categories() {

        $breadcrumbs = [
            ['link' => "/", 'name' => "Dashboard"], ['link' => "javascript:void(0)", 'name' => "Management"], ['name' => "Category List"]
        ];

        return view('/content/admin-management/category/category-list', [
            'breadcrumbs' => $breadcrumbs
        ]);

    }

    public function index(Request $request) {

        \Log::debug('recupero le categorie' );

        $response = $this->categoryService->index($request);
        return response()->json($response);

    }

    public function store(Request $request) {

        $response = $this->categoryService->store($request);
        return response()->json($response);

    }

    public function edit($id) {

        $response = $this->categoryService->edit($id);
        return response()->json($response);

    }

    public function update(Request $request, Category $category) {

        $response = $this->categoryService->update($request, $category);
        return response()->json($response);

    }

    public function destroy($id) {

        $response = $this->categoryService->destroy($id);
        return response()->json($response);

    }

}
