<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



/**
 * @OA\Info(
 *      title="Products API",
 *      version="1.0.0",
 *      description="Products API for CRUD operations ",
 *      @OA\Contact(
 *          email="innotuyi81@gmail.com"
 *      )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
