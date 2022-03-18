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
        $products = Product::all(); 
        return response()->json($products, 201);   
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post (
     *     path="/api/product",
     *     tags={"Products"},
     *     security={ {"sanctum": {} }},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="array",
     *                       @OA\Items(
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="price",
     *                          type="decimal"
     *                      ),
     *                      @OA\Property(
     *                          property="quantity",
     *                          type="integer"
     *                      ),
     *                      ),
     *                 ),
     *                 example={
     *                     "name":"Bebe",
     *                     "description":"this is description",
     *                     "price":"101",
     *                     "quantity":"4",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Bebe"),
     *              @OA\Property(property="description", type="string", example="this is description"),
     *              @OA\Property(property="price", type="string", example="40"),
     *              @OA\Property(property="quantity", type="integer", example="8"),
    *               @OA\Property(property="updated_at", type="string", example="2022-02-23T07:07:54.000000Z"),
    *               @OA\Property(property="created_at", type="string", example="2022-02-23T07:07:54.000000Z"),
     *              @OA\Property(property="id", type="number", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      ),
   
     *      @OA\Response(
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
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::Create($request->all());

        return response()->json($product, 201);
        
        // return response()->json([
        //     'msg'=>'Product created',
        //     'product' => $product 
        // ]);
        
    }
    /**
     * Display the specified resource.
     * 
     * * @OA\Get (
     *     path="/api/product/{id}",
     *     tags={"Products"},
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="Bebe"),
     *              @OA\Property(property="description", type="string", example="this is description"),
     *              @OA\Property(property="price", type="string", example="40"),
     *              @OA\Property(property="quantity", type="integer", example="8"),
    *               @OA\Property(property="updated_at", type="string", example="2022-02-23T07:07:54.000000Z"),
    *               @OA\Property(property="created_at", type="string", example="2022-02-23T07:07:54.000000Z"),
     *              @OA\Property(property="id", type="number", example=1)
     *         )
     *     ),
     *  @OA\Response(
     *    response=404,
     *    description="NotFound",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Product  Not Found"),
     *    )
     * ),
     *      @OA\Response(
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
     * )   
     * )
     *
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
     * * @OA\Put (
     *     path="/api/product/{id}",
     *     tags={"Products"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="price",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="post",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="quantity",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "name":"laptop",
     *                     "description":"This is portable laptop",
     *                     "price":"101",
     *                     "quantity":"28",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="laptop"),
     *              @OA\Property(property="description", type="string", example="this is portable laptop"),
     *              @OA\Property(property="price", type="string", example="404"),
     *              @OA\Property(property="quantity", type="string", example="28"),
     *          )
     *      ),
     *   @OA\Response(
     *    response=404,
     *    description="NotFound",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Product Not Found"),
     *    )
     * ),
     *      @OA\Response(
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
     * )
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
     *  * @OA\Delete (
     *     path="/api/product/{id}",
     *     tags={"Products"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Employee deletion success")
     *         )
     *     ),
     *  @OA\Response(
     *    response=404,
     *    description="NotFound",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Product Not Found"),
     *    )
     * ),
     *      @OA\Response(
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
     * )
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

/**
      * Search for Related name in DataBase
    * @OA\Get (
     *     path="/api/product/search/{name}",
     *     tags={"Products"},
     *     security={ {"bearer": {} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="laptop"),
     *              @OA\Property(property="description", type="string", example="this is portable computer"),
     *              @OA\Property(property="price", type="string", example="808"),
     *              @OA\Property(property="quantity", type="string", example="38"),
     *         )
     *     ),
     *      @OA\Response(
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
     * )

     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
   public function search($name)
   {
       return Product::where('name', 'like', '%' . $name . '%')->get();
   }
}