<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanController extends Controller
{
    public function ban()
    {


        $user = Auth::user();
        if ($user->status == 'blocked'){

            if(App()->getLocale() == 'en'){

                $status = 'Your account has been banned for violating our usage policy. Please check with technical support to find out the reason for the ban';
                Auth::logout();
                return view('auth.login' ,  compact('status' ));
            }
            else{
                $status = 'تم حظر حسابك لمخالفة سياسية الاستخدام لدينا يرجى مراجعة الدعم الفني لمعرفة سبب الحظر';
                Auth::logout();
                return view('auth.login' ,  compact('status' ));
            }
        }


    }
}
