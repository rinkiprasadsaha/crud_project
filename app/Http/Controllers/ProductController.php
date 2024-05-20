<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductIndexRequest;

use Illuminate\Http\Request;
use App\Models\Product;
// use App\Models\Product;
// use Illuminate\Support\Facades\Validator;
use Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use App\Traits\ApiResponse;
// use App\Repositories\ProductRepository;
use App\Interfaces\ProductInterface;


class ProductController extends Controller
{

    use ApiResponse;
    /**
     * Validate the class instance.
     *
     * @return void
     * @throws AuthorizationException
     * @throws ValidationException
     */


    protected $repository;

    public function __construct(ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;
    }

    public function index(ProductIndexRequest $request)
    {

        return $this->productInterface->index($request);

     }




    public function createProduct(ProductRequest $request)
    {
        return $this->productInterface->createProduct($request);

    }


    public function showProduct($id)
    {
        return $this->productInterface->showProduct($id);
    }


    public function updateProduct(ProductRequest $request,$id)
    {
        return $this->productInterface->updateProduct($request,$id);

    }


    public function deleteProduct($id)
    {
        return $this->productInterface->deleteProduct($id);
    }
    public function archiveProduct()
    {

        return $this->productInterface->archiveProduct();

    }
    public function restoreProduct($id)
    {

        return $this->productInterface->restoreProduct($id);

    }

}
