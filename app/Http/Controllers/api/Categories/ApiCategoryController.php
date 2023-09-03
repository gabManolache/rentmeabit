<?php

namespace App\Http\Controllers\Api\Categories;

use App\Http\Services\Categories\CategoryService;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiCategoryController extends Controller {


    protected $categoryService;

    public function __construct(CategoryService $categoryService) {

        $this->categoryService = $categoryService;

    }

    public function index(Request $request) {

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
