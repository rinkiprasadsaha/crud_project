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


        $items = Item::get();
        return static::successResponse($items,'Data fetch successfully');
    }

    public function createItem(ItemRequest $request)
    {

        try {
            $item = Item::create($request->all());
            return static::successResponse($item,'Data addes successfully');
        } catch (Exception $e) {
            return static::errorResponse(['message' => $e->getMessage()], $e->getStatus());
        }

    }


    public function showItem($id)
    {

        try {
            $item = Item::findOrFail($id);
            return static::successResponse($item,'Data fetch successfully');
        } catch (Exception $e) {
            return static::errorResponse();
        }
    }


    public function updateItem(ItemRequest $request,$id)
    {

        try {
            $item = Item::findOrFail($id);
            $item->update($request->all());
            return static::successResponse($item,'Data updated successfully');
        } catch (Exception $e) {
           return static::errorResponse();
        }

    }


    public function deleteItem($id)
    {
        try {
            Item::destroy($id);
            return static::successResponse('No data found','delete successfully');
        } catch (Exception $e) {
            return static::errorResponse();
        }
    }



}
