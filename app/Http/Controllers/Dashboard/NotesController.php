<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:notes-read')->only('index' , 'show');
        $this->middleware('permission:notes-create')->only('create' , 'store');
        $this->middleware('permission:notes-update')->only('edit' , 'update');
        $this->middleware('permission:notes-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:notes-restore')->only('restore');
    }


    public function add(Request $request)
    {
        $request->validate([

            'note' => "required|string",

            ]);


            $user = Auth::user();


            $note = Note::create([

                'note' => $request['note'],
                'user_id' => $request['user'],
                'profile' => $user->profile,
                'admin_id' => $user->id,

            ]);


            session()->flash('success' , 'note created successfully');

            return redirect()->route('users.show' , [app()->getLocale() , $request['user']]);
    }
}
