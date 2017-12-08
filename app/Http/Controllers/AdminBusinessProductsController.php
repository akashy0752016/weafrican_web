<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BusinessProduct;

class AdminBusinessProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Products';
        $products = BusinessProduct::select('business_products.*', 'user_businesses.business_id as businessId', 'user_businesses.title as business_name')->leftJoin('user_businesses','business_products.user_id' , '=', 'user_businesses.user_id')->orderBy('business_products.created_at', 'DESC')->get();
        return view('admin.products.index', compact('pageTitle', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = BusinessProduct::findOrFail($id);

        if($product->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Product deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Product can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function block($id)
    {
        $product = BusinessProduct::find($id);
        $product->is_blocked = !$product->is_blocked;
        $product->save();

        if ($product->is_blocked) {
            return redirect('admin/product')->with('success', 'Product has been blocked successfully');
        } else {
            return redirect('admin/product')->with('success', 'Product has been unblocked');
        }
    }
}