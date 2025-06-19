<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductApiController extends Controller
{
    public function index()
    {
        return response()->json(Product::all(), 200);
    }
}
