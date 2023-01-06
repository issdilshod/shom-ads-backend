<?php

namespace App\Services\Ad;

use App\Http\Resources\Ad\CategoryResource;
use App\Models\Ad\Category;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class CategoryService extends Service{

    public function all()
    {
        $categories = Category::where('deleted_at', null)
                    ->orderBy('name', 'asc')
                    ->paginate(Config::get('pagination.per_page'));

        return CategoryResource::collection($categories);
    }

    public function get($categoryId)
    {
        $category = Category::where('deleted_at', null)
                    ->where('id', $categoryId)
                    ->first();

        if ($category==null){
            return response()->json(['msg' => 'not found'], 404);
        }
        
        return new CategoryResource($category);
    }

    public function create($category)
    {
        $exist = $this->exist($category);
        if ($exist){ return response()->json(['msg'=> 'conflict'], 409); }

        $category = Category::create($category);

        return new CategoryResource($category);
    }

    public function update($category, $categoryId)
    {
        $exist = $this->exist($category, $categoryId);
        if ($exist){ return response()->json(['msg'=> 'conflict'], 409); }

        $categoryOriginal = Category::where('deleted_at', null)
                                ->where('id', $categoryId)
                                ->first();

        if ($categoryOriginal==null){
            return response()->json(['msg' => 'not found'], 404);
        }

        $categoryOriginal->update($category);
        
        return new CategoryResource($categoryOriginal);
    }

    public function delete($categoryId)
    {
        Category::where('deleted_at', null)
            ->where('id', $categoryId)
            ->update(['deleted_at' => Carbon::now()]);
    }

    public function exist($category, $categoryId = '')
    {
        $category = Category::where('deleted_at', null)
                    ->when(isset($category['name']), function($q) use($category){
                        $q->where('name', $category['name']);
                    })
                    ->when($categoryId!='', function ($q) use($categoryId){
                        $q->where('id', '!=', $categoryId);
                    })
                    ->where('belong_id', '!=', $category['current_user_id'])
                    ->first();
        if ($category==null){
            return false;
        }
        return true;
    }

    public function validate($category)
    {
        $category = $category->validate([
            'name' => 'required',
            'parent_id' => '',
            'current_user_id' => '' // to set belong
        ]);

        return $category;
    }

}