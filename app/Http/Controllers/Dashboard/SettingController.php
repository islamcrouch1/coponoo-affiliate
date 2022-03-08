<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function social_links()
    {
        return view('dashboard.settings.settings');
    }


    public function store(Request $request)
    {



        setting($request->all())->save();
        session()->flash('success', 'data added successfully');

        return  redirect()->back();
    }
}
