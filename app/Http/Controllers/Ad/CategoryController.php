<?php

namespace App\Http\Controllers\Ad;

use App\Http\Controllers\Controller;
use App\Services\Ad\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }
    
    public function index(Request $request)
    {
        // permission

        $categories = $this->categoryService->all();

        return $categories;
    }

    public function show(Request $request, $categoryId)
    {
        // permission

        $category = $this->categoryService->get($categoryId);

        return $category;
    }

    public function store(Request $request)
    {
        // permission

        $validatedCategory = $this->categoryService->validate($request);

        $category = $this->categoryService->create($validatedCategory);

        return $category;
    }

    public function update(Request $request, $categoryId)
    {
        // permission

        $validatedCategory = $this->categoryService->validate($request);

        $category = $this->categoryService->update($validatedCategory, $categoryId);

        return $category;
    }

    public function destroy(Request $request, $categoryId)
    {
        // permission

        $this->categoryService->delete($categoryId);

        return response()->json(['msg' => 'success'], 200);
    }

}
