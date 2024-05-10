<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
// use Illuminate\Support\Facades\Validator;
use Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use App\Traits\ApiResponse;


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
    public function create(ProductRequest $request)
    {
        return response()->json($request->validated());
        // try{
        //     $product= Product::create($request->all());
        //     return response()->json([
        //         "Product"=>$product,"message" => "Product enter sucessfully",
        //         'success' => true
        //       ]);
        // }catch  (Exception $e) {
        //     return response()->json([
        //         'error' => $e->getMessage()
        //     ], 401);

        //         }




    }
    public function index()
    {
        //  $product= Product::all();
        //  return response()->json($product);

        // $product = Product::with('category')->get();
        // $category = Category::with('product')->get();
        // return response()->json($product,$category);


        $product = DB::table('product')
            ->join('category', 'product.category_id', '=', 'category.id')
            ->select('product.*','category.catname')
            ->get();
            return response()->json($product);

     }


    public function archive_product()
    {

        $product= Product::onlyTrashed()->get();
        return response()->json($product);

    }

    public function create_product(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'productname' => 'required|max:25',
            'description' => 'required',
            'category_id' => 'required'

        ]);

        if ($validator->fails()){
             return response()->json([
                 'success' => false,
                 'errors' => $validator->errors()->toArray()
             ]);
        }

          $product= Product::create($request->all());
            return response()->json([
                "Product"=>$product,"message" => "Product enter sucessfully",
                'success' => true
              ]);


            //    $request-> validate([
            //      'name' => 'required|max:255',
            //      'description' => 'required',
            //    ]);

            //    try {
            //     $product= Product::create($request->all());
            //     return response()->json(["Product"=>$product,"message" => "Product enter sucessfully"]);
            //    } catch (\Throwable $th) {
            //     // throw $th->getMessage();
            //     throw $th;
            //    }





    }

    /**
     * Display the specified resource.
     */
    public function show_product($id)
    {
        $product= Product::find($id);
        if(!empty($product))
        {
            return response()->json($product);
        }
        else
        {
            return response()->json(["message" => "Product not found"]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_product(Request $request,$id)
    {
        // if(product::where('id',$id)->exists())
        // {
            // $product= Product::find($id);
            // $product->name= $request->name;
            // $product->description= $request->description;
            // $product->save();
            $validator = Validator::make($request->all(),[
                'name' => 'required|max:25',
                'description' => 'required'
            ]);


        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ]);
       }
            $product = Product::find($id);
            $product->update($request->all());
       return response()->json([
           "Product"=>$product,"message" => "Product updated sucessfully",
           'success' => true
         ]);
        //       $product = Product::find($id);
        //       $product->update($request->all());
        //       return response()->json(["message" => "Product updated sucessfully"]);
        // }
        // else
        // {
        //     return response()->json(["message" => "Product not found"]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_product($id)
    {
        if(product::where('id',$id)->exists())
        {
            $product= Product::find($id);

            $product->delete();

            return response()->json(["message" => "records deleted"]);
        }
        else
        {
            return response()->json(["message" => "Records not found"]);
        }
    }

    public function restore_product($id)
    {
        //  $product= Product::withTrashed()->findOrFail($id)->restore();

        //  if(Product::where('id',$id)->exists()){
                $product= Product::withTrashed()->find($id)->restore();
                if(Product::where('id',$id)->exists()){
                return ApiResponse::successResponse($id);
            }else{
                return ApiResponse::errorResponse();
            }


        // return response()->json(['message' => 'Record restored successfully']);
    }

}
