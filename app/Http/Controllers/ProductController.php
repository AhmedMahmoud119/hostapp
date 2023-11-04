<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    public function saveProducts(Request $request)
    {
        $request->validate([
            '*.item_id'         => 'required',
            '*.currency'        => 'required',
            '*.period_in_month' => 'required|numeric',
            '*.price'           => 'required|numeric',
            '*.category'        => 'required',
            '*.type'            => 'required',
            '*.status'          => ['required', Rule::in(['active', 'inactive'])],
        ]);


        foreach ($request->all() as $key => $item) {

            Product::updateOrCreate([
                'item_id'  => $item['item_id'],
                'currency' => $item['currency'],
            ], [
                'period_in_month' => $item['period_in_month'],
                'price'           => $item['price'],
                'category'        => $item['category'],
                'type'            => $item['type'],
                'status'          => $item['status'],
            ]);

        }

        return response()->json([
            'success' => 'تم الحفظ',
        ]);

    }

}
