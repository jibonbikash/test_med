<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $products= Product::whereHas('variantprices', function($query) use ($request) {
            $query->with(['product_variantone', 'product_varianttwo', 'product_variantthree'])
                ->when($request->input('price_from'), function ($q1) use ($request) {
                    $q1->where('price', '>=', $request->input('price_from'));
                })
            ->when($request->input('price_to'), function ($q) use ($request) {
                $q->where('price', '<=',$request->input('price_to'));
            });
        })
            ->whereHas('product_variants', function($query) use ($request){
                $query->with(['variant'])
                    ->when($request->input('variant'), function ($q) use ($request) {
                    $q->where('variant','=',$request->input('variant'));
                });
            })
            ->when($request->has('title'), function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->input('title') . '%');
            })
            ->when($request->get('cdate'), function ($q) use ($request) {
                $q->whereDate('created_at','=', date("Y-m-d", strtotime($request->get('cdate'))));
            })
            ->with(['variantprices'=>function($query){
                $query->with(['product_variantone', 'product_varianttwo', 'product_variantthree']);
            },'images', 'product_variants' => function ($query) {
                $query->with(['variant']);
            }])
            ->paginate(2);
       $variants= Variant::with(['ProductVariants'=>function($query){
          return $query->groupBy('variant');
       }])->get();
        return view('products.index',['products'=>$products, 'variants'=>$variants]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
