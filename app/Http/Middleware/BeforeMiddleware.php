<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;

use Closure;
use App;
use Auth;
use App\CmsPage;
use App\User;
use App\UserBusiness;

class BeforeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $cmsPages = CmsPage::get();
        if (Auth::check() and Auth::user()->user_role_id!=1  and Auth::user()->user_role_id!=4)
        {
            $Authuser = User::where('id',Auth::user()->id)->first();
            view()->share('category_check', $Authuser->business->bussiness_category_id);
        }
        view()->share('cmsPages', $cmsPages);
        view()->share('ip', $ip);
        return $next($request);
    }
}