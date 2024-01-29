<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::with(['loggable', 'user'])->paginate(20);

        return view('admin.logs.list', ['list' => $logs]);
    }

    public function getLog(Request $request)
    {
        $id = $request->id;
        $dataType = $request->data_type;

        $log = Log::query()->with('loggable')->findOrFail($id);

        $logtype = $log->loggable_type;

        $data = json_decode($log->data);
        $data = ($log->data);

        if ($dataType == 'data') {
            return view('admin.logs.data-log-view', compact('data', 'logtype'));
        }

        dd('dur');
        $data = $log->loggable;
        return view('admin.logs.model-log-view', compact('data', 'logtype'));
    }
}