<?php

namespace App\Repositories;

use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use App\Traits\PaginationTrait;


use App\Interfaces\CategoryInterface;

class CategoryRepository implements CategoryInterface{
     use ApiResponse;
     use PaginationTrait;

    public function index($params)
    {
        try {
            $perPage = $params['page'] ;
            $perPage = $params['perPage'];
            $sortColumn = $params['sortColumn'];
            $sort = $params['sort'];
            $name = $params['name'];

            $offset = $this->get_pagination_offset($params->page, $params->perPage);

            $category =  Category::withTrashed()->select('name','id');

            $category =  $category->with('products');

            $category =  $category  ->where('name', 'like', "%$name%")
                                    ->orWhereHas('products', function($q) use ($name){
                                    $q->where('name','like',"%$name%");
                                    });

            $category =  $category->orderby($sortColumn,$sort);

            $category =  $category ->skip($offset)->take($perPage);

            $category =  $category->get();
            $categorys_count = $category->count();

            return static::successResponseIndex($category,'Data Fetch Successfully', $categorys_count);
        }catch (Exception $e) {
            Log::error('Error fetching products.', ['message' => $e->getMessage(), 'params' => $params]);

            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }

     

    public function createCategory($params)
    {
        try{
            $category =  Category::create($params->all());
            return static::successResponse($category,'Data added successfully',201);
        }catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function showCategory($id)
    {

        try{
            $category = Category::find($id);
            return static::successResponse($category,'Data fetch successfully',200);
        }catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }
    public function updateCategory($params)
    {

        try {
            $category =  Category::findOrFail($id);
            $category->update($params->all());
            return static::successResponse($category,'Data updated successfully');
        } catch (Exception $e) {
           return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }

    }

    public function deleteCategory($id)
    {
        try {
            Category::destroy($id);
            return static::successResponse('No data found','delete successfully');
        } catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }


}

