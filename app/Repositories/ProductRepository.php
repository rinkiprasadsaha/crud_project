<?php

namespace App\Repositories;

use App\Models\Product;
use App\Traits\ApiResponse;

use App\Traits\PaginationTrait;

use App\Interfaces\ProductInterface;

class ProductRepository implements ProductInterface{
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
            $product =  Product::select('name','description','category_id');

            $product =  $product ->with('category');

            $product =  $product  ->orderBy($sortColumn, $sort);

            $product =  $product ->skip($offset)->take($perPage);

            $product =  $product ->where('name', 'like', "%$name%")
                                 ->orWhereHas('category', function($q) use ($name){
                                $q->where('name','like',"%$name%");
                                });

            $product =  $product->get();
            $product_count = $product->count();



            return static::successResponseIndex($product,'Data Fetch Successfully', $product_count);
        } catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function createProduct($params)
    {
        try {
            $product =  Product::create($params->all());
            return static::successResponse($product,'Data added successfully',201);
        } catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function showProduct($id)
    {

        try {
            $product = Product::find($id);
            return static::successResponse($product,'Data fetch successfully',200);
        } catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }
    public function updateProduct($params,$id)
    {

        try {
            $product =  Product::findOrFail($id);
            $product->update($params->all());
            return static::successResponse($product,'Data updated successfully');
        } catch (Exception $e) {
           return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }

    }

    public function deleteProduct($id)
    {
        try {
            Product::destroy($id);
            return static::successResponse('No data found','delete successfully');
        } catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function archiveProduct()
    {
        $product= Product::onlyTrashed()->get();

        try {

        // $product= Product::onlyTrashed()->get();
        return static::successResponse($product,'Archive Data');
        }catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }
    }

    public function restoreProduct($id)
    {

            try {
                $product =  Product::withTrashed()->restore($id);
                // $product= Product::$product->restore();
                // $product=$this->repository->show($id);
                return static::successResponse($product,'restore successfully');
            } catch (Exception $e) {
                return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
            }

    }


}

