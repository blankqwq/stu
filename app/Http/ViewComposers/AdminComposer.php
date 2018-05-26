<?php
/**
 * Created by PhpStorm.
 * User: 11365
 * Date: 2018/5/21
 * Time: 16:58
 */

namespace App\Http\ViewComposers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminComposer
{

    public function compose(View $view) {

        $userinfo = Cache::remember('userinfo'.Auth::id(), 10, function() {
            return Auth::user()->getinfo()->first();
        });
        $view->with(compact('userinfo'));//填充数据
    }
}