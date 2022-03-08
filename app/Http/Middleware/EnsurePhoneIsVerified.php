<?php

namespace App\Http\Middleware;

use Closure;

class EnsurePhoneIsVerified
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




        if (! $request->user()->hasVerifiedPhone()) {
            return redirect()->route('phoneverification.notice', ['lang' => app()->getLocale() , 'country' => $request->user()->country_id , 'user'=> $request->user()->id]);
        }

        return $next($request);
    }
}
