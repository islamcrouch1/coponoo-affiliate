<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:logs-read')->only('index', 'show');
        $this->middleware('permission:logs-create')->only('create', 'store');
        $this->middleware('permission:logs-update')->only('edit', 'update');
        $this->middleware('permission:logs-delete')->only('destroy', 'trashed');
        $this->middleware('permission:logs-restore')->only('restore');
    }

    public function index()
    {


        $logs = Log::whenSearch(request()->search)
            ->whenUserType(request()->user_type)
            ->whenLogType(request()->log_type)
            ->latest()
            ->paginate(100);
        return view('dashboard.logs.index')->with('logs', $logs);
    }
}
