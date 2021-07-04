<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function productsList(Request $request)
    {
        try {
            return response()->json(["result" => true, "data" => Product::all()]);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['result' => false, "msg" => "server error"]);
        }
    }
    public function getProduct(Request $request, $id)
    {
        try {
            return response()->json(["result" => true, "data" => Product::find($id)]);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['result' => false, "msg" => "server error"]);
        }
    }
    public function saveProduct(AddProductRequest $request)
    {
        try {
            $product = null;
            if ($request->has("id")) {
                $product = Product::findOrFail((int)$request->id);
            } else {
                $product = new Product();
            }

            $product->name = $request->name;
            $product->price = $request->price * 100;
            $product->quantity = $request->quantity;
            $product->save();
            return response()->json(["result" => true,]);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['result' => false, "msg" => "server error"]);
        }
    }
}