<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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

        $response = [
            // 'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
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
 *  @OA\Response(
     *          response=419,
     *          description="CSRF Token mismatch",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      ),   
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
            'token' => $token
        ];

        return response($response, 201);
    }

         /**
 * @OA\Post(
 * path="/api/logout",
 * summary="Logout",
 * description="Logout user and invalidate token",
 * tags={"Users"},
 * security={ {"bearer": {} }},
 * @OA\Response(
 *    response=200,
 *    description="Success"
 *     ),
 * @OA\Response(
 *    response=401,
 *    description="Returns when user is not authenticated",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Not authorized"),
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