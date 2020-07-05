<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        //Get products
        if (isset($request->properties) && !empty($request->properties)) {
            $query = DB::table('products')
                ->join('product_property', 'product_property.product_id', '=', 'products.id')
                ->join('properties', 'product_property.property_id', '=', 'properties.id');
            foreach ($request->properties as $property) {
                $query->where(function ($query) use ($property) {
                    $query->where('properties.value', '=', $property[0]);

                });
                if (count($property) > 1) {
                    for ($i = 1; $i < count($property); ++$i) {
                        $item = $property[$i];
                        $query->orWhere(function ($query) use ($item) {
                            $query->where('properties.value', '=', $item);
                        });
                    }
                }
            }
            $products = $query->select('products.*')->groupBy('id')->paginate(40);
        } else {
            $products = Product::paginate(40);
        }

        return ProductResource::collection($products);
    }
}
