<?php

namespace App\Http\Middleware;

use Closure;

use App\User;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->status == 'blocked'){

            if(App()->getLocale() == 'en'){
                $request->merge(['status' => 'Your account has been banned for violating our usage policy. Please check with technical support to find out the reason for the ban']);
                return redirect()->route('ban' , app()->getLocale());
            }
            else{
                $request->merge(['status' => 'تم حظر حسابك لمخالفة سياسية الاستخدام لدينا يرجى مراجعة الدعم الفني لمعرفة سبب الحظر']);
                return redirect()->route('ban' , app()->getLocale());
            }
        }
        return $next($request);
    }
}
