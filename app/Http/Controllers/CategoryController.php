<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
 use Illuminate\Support\Facades\Validator;
// use Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class CategoryController extends Controller
{
    /**
     * Validate the class instance.
     *
     * @return void
     * @throws AuthorizationException
     * @throws ValidationException
     */

    public function index()
    {
        $category= Category::all();
        return response()->json($category);

    }



    public function create_category(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'catname' => 'required|max:255'
        ]);

        if ($validator->fails()){
             return response()->json([
                 'success' => false,
                 'errors' => $validator->errors()
             ]);
        }

          $category= Category::create($request->all());
            return response()->json([
                "Category"=>$category,"message" => "Category enter sucessfully",
                'success' => true
              ]);



    }


    public function show_category($id)
    {
        $category= Category::find($id);
        if(!empty($category))
        {
            return response()->json([
                "Category"=>$category
              ]);
        }
        else
        {
            return response()->json(["message" => "Category not found"]);
        }
    }


    public function update_category(Request $request,$id)
    {

            $validator = Validator::make($request->all(),[
                'cat_name' => 'required|max:255'
            ]);


        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ]);
       }
            $category = Category::find($id);
            $category->update($request->all());
       return response()->json([
           "Category"=>$category,"message" => "Category updated sucessfully",
           'success' => true
         ]);

    }


    public function delete_category($id)
    {
        if(category::where('id',$id)->exists())
        {
            $category= Category::find($id);

            $category->delete();

            return response()->json(["message" => "records deleted"]);
        }
        else
        {
            return response()->json(["message" => "Records not found"]);
        }
    }


}
