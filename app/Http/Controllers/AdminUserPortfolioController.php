<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserPortfolioImage;

class AdminUserPortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Portfolio';
        $portfolios = UserPortfolioImage::select('user_portfolio_images.*', 'user_businesses.id as businessId','user_businesses.business_id', 'user_businesses.title as business_name')->leftJoin('user_businesses','user_portfolio_images.user_id' , '=', 'user_businesses.user_id')->orderBy('user_portfolio_images.created_at', 'DESC')->get();
        return view('admin.portfolio.index', compact('pageTitle', 'portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        $portfolio = UserPortfolioImage::findOrFail($id);

        if($portfolio->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Portfolio deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Portfolio can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }
}
