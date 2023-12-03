<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\DatabaseJob;
use Illuminate\Support\Facades\Queue;

class QueueManagementController extends Controller
{
    public function index()
    {
        $jobs = Jobs::orderBy('id', 'desc')->get();
        return view('queue-management', compact('jobs'));
    }
  public function cancelJob($jobId)
{
    $job = Jobs::find($jobId);
    if ($job) {
        $job->delete();
        return back()->with('cancell','Succesfully Cancelled');
    } else {
        return response()->json(['message' => 'Job not found'], 404);
    }
}

public function reExecuteJob($jobId)
{
    $job = Jobs::find($jobId);
    if ($job) {
        $delayInMinutes = 5;

        Queue::connection($job->connection)->later(now()->addMinutes($delayInMinutes), $job);

$job->delete();
        
        return back()->with('reExecute','Succesfully Re Executed');
    } 
    else {
        return response()->json(['message' => 'Job not found'], 404);
    }
}
}
