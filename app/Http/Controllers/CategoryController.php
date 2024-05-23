<?php

namespace App\Http\Controllers;
use App\Http\Requests\CategoryRequest;

use App\Http\Requests\ProductIndexRequest;
use Illuminate\Http\Request;
use App\Models\Category;
 use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

use App\Traits\ApiResponse;
use App\Interfaces\CategoryInterface;

class CategoryController extends Controller
{
    use ApiResponse;
    /**
     * Validate the class instance.
     *
     * @return void
     * @throws AuthorizationException
     * @throws ValidationException
     */


    protected $categoryInterface;

    public function __construct(CategoryInterface $categoryInterface)
    {
        $this->categoryInterface = $categoryInterface;
    }

    public function index(ProductIndexRequest $request)

    {

        return $this->categoryInterface->index($request);

    }



    public function createCategory(CategoryRequest $request)
    {
        // $role = $request->role;
        // if ($role == 'user') {
        //     return static::errorResponse([ "This role has no permission"]);
        // }
        return $this->categoryInterface->createCategory($request);

    }


    public function showCategory($id)
    {
        return $this->categoryInterface->showCategory($id);
    }


    public function updateCategory(CategoryRequest $request,$id)
    {
        return $this->categoryInterface->updateCategory($request);
    }


    public function deleteCategory($id)
    {
        return $this->categoryInterface->deleteCategory($id);
    }




}
