<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

   /**
    * Users Registration
    * @OA\Post (
    *     path="/api/register",
    *     tags={"Users"},
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
    *                          property="email",
    *                          type="string"
    *                      ),
    *                      @OA\Property(
    *                          property="password",
    *                          type="string"
    *                      ),
    *                      @OA\Property(
    *                          property="password_confirmation",
    *                          type="string"
    *                      )
    *                     
    *                     
    *                     ),
    *                 ),
    *                 example={
    *                     "name":"Bebe",
    *                     "email":"example@content.com",
    *                     "password":"ishyamba123",
    *                     "password_confirmation":"ishyamba123",
    *                     
    *                }
    *             )
    *         )
    *      ),
    *      @OA\Response(
    *          response=201,
    *          description="success",
    *          @OA\JsonContent(
    *              @OA\Property(property="Token", type="string", example="2|aAUDFJ8GbMcvrFH2PnDvDZ2GM8cbklBijDqMX9Dw"),
    *          )
    *      ),
    *      @OA\Response(
    *          response=422,
    *          description="Email has been Taken",
    *          @OA\JsonContent(
    *              @OA\Property(property="msg", type="string", example="fail"),
    *          )
    *      ),
*  @OA\Response(
*    response=500,
*    description="Returns when there is server problem",
*    @OA\JsonContent(
*       @OA\Property(property="message", type="string", example="Server Error"),
*    )  
* ),   
    * )
    */ 

    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;


        return response()->json($user, 201);
    }


    /**
     * User Login
     *
     * @OA\Post (
     *     path="/api/login",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="array",
     *                       @OA\Items(
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                     
     *                     
     *                     
     *                     ),
     *                 ),
     *                 example={
     *                     "email":"example@content.com",
     *                     "password":"ishyamba123",
     *                     
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="successfully Logged In",
     *          @OA\JsonContent(
     *              @OA\Property(property="Token", type="string", example="2|aAUDFJ8GbMcvrFH2PnDvDZ2GM8cbklBijDqMX9Dw"),
     *          )
     *   
     *      ),
     * 
     *      @OA\Response(
     *          response=401,
     *          description="invalid Credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      ),
 *  @OA\Response(
 *    response=500,
 *    description="Returns when there is server problem",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Server Error"),
 *    )  
 * ),   
     * )
     */


    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            // 'user' => $user,
            'token' => 'string'
        ];

        return response($response, 201);
    }

         /**
 * @OA\Post(
 * path="/api/logout",
 * summary="Logout",
 * description="Logout user and invalidate token",
 * tags={"Users"},
 * security={ {"sanctum": {} }},
 * @OA\Response(
 *    response=200,
 *    description="Success",
 
 *     ),
 * @OA\Response(
 *    response=401,
 *    description="Returns when user is not authenticated",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Not authorized"),
 *    )
 * ),
 * @OA\Response(
 *    response=500,
 *    description="Returns when there is server error",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Server Error"),
 *    )
 * )
 * )
 */

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }


}