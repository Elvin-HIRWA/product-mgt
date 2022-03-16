<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

protected $product;

public function __construct(Product $product){
    $this->product = $product;
}

    /**
     * Display a listing of the resource.
     * @OA\Get(
     *   path="/api/product",
     *   tags={"Products"}, 
     *   security={ {"sanctum": {} }}, 
     *    @OA\Response(
     *    response=401,
     *    description="UnAuthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="UnAuthanticated"),
     *    )
     * ),
     *  @OA\Response(
     *    response=500,
     *    description="Returns when there is server problem",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Server Error"),
     *    )  
     * ),   
     *   @OA\Response(
     *     response="200",
     *     description="Success|Returns Products list",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Iphone 14"
     *                      ),
     *                      @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example="this is products"
     *                      ),
     *                      @OA\Property(
     *                         property="quantity",
     *                         type="integer",
     *                         example="6"
     *                      ),
     *                      @OA\Property(
     *                         property="price",
     *                         type="decimal",
     *                         example="65.5"
     *                      ),
     * )
     *     )
     *   )
     * )
     *
     * @return \Illuminate\Http\Response
     */    
    public function index()
    {
        return Product::all();    
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::Create($request->all());
        
        return response()->json([
            'msg'=>'Product created',
            'product' => $product 
        ]);
        
    }
    /**
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {

        $product = $this->product->getProduct($id);
        if($product){
            return response()->json($product);
        }
        return response()->json(["msg"=>"this Product not found"],404);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $product = $this->product->updateProduct($id,$request->all());
            return response()->json($product);
        }catch (ModelNotFoundException $exception){
            return response()->json(["msg"=>$exception->getMessage()],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = $this->product->deleteProduct($id);
            return response()->json(["msg"=>"Product Deleted successfully"]);
        }catch (ModelNotFoundException $exception){
            return response()->json(["msg"=>$exception->getMessage()],404);
        }
    }


    /* @param  str  $name
    * @return \Illuminate\Http\Response
    */
   public function search($name)
   {
       return Product::where('name', 'like', '%' . $name . '%')->get();
   }
}
