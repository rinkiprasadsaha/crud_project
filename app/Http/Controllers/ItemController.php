<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Traits\ApiResponse;
use App\Repositories\ItemRepository;
class ItemController extends Controller
{
    use ApiResponse;

    protected $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {

        // $product = DB::table('product')
        //     ->join('category', 'product.category_id', '=', 'category.id')
        //     ->select('product.*','category.catname')
        //     ->get();

        // $product = Product::withTrashed()->select('name','description','category_id')->with('categories')->get();
        // $items = $this->repository->paginate();
        $items = $this->repository->get();
        return static::successResponse($items,'Data fetch successfully');
    }

    public function createItem(ItemRequest $request)
    {

        try {
            $item = $this->repository->store($request);
            return static::successResponse($item,'Data addes successfully');
        } catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }

    }


    public function showItem($id)
    {

        try {
            $item = $this->repository->show($id);
            return static::successResponse($item,'Data fetch successfully');
        } catch (Exception $e) {
            return static::errorResponse();
        }
    }


    public function updateItem(ItemRequest $request,$id)
    {

        try {
            $item = $this->repository->update($id, $request);
            return static::successResponse($item,'Data updated successfully');
        } catch (Exception $e) {
           return static::errorResponse();
        }

    }


    public function deleteItem($id)
    {
        try {
            $this->repository->delete($id);
            return static::successResponse('No data found','delete successfully');
        } catch (Exception $e) {
            return static::errorResponse();
        }
    }

    public function restoreItem($id)
    {
        try {
            $item = $this->repository->restore($id);
            $item=$this->repository->show($id);
            return static::successResponse($item,'restore successfully');
        } catch (Exception $e) {
            return static::errorResponse();
        }
    }

}
