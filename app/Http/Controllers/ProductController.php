<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Project;

class ProductController extends Controller
{
    
    public function create(Request $req) {

        $bodyParams = $req -> only(
            "name",
            "description",
            "projectId"
        );

        $validation = validator($bodyParams, [
            "name"              =>          "required|string",
            "description"       =>          "required|string",
            "projectId"         =>          "required|integer",
        ]);

        if ($validation -> fails()) return response([
            "message"           =>              "invalid_params",
            "errors"            =>              $validation -> errors()
        ], 500);

        $newProduct = new Product($bodyParams);

        $newProduct -> project() -> associate(Project::find($bodyParams["projectId"]));

        if (!$newProduct -> save()) return response([
            "message"           =>              "create_error"
        ], 500);

        return response([
            "message"           =>              "created",
            "product"           =>              $newProduct
        ], 201);

    }

    public function findAll() {
        
        $products = Product::all();

        return response([
            "products"              =>          $products
        ]);

    }

    public function findOne(int $id) {

        $product = Product::find($id);

        return response([
            "product"               =>          $product
        ]);

    }

}
