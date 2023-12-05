<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\DatabaseJob;
use Illuminate\Support\Facades\Queue;

/**
 * The QueueManagementController class is responsible for managing the queue jobs.
 */
class QueueManagementController extends Controller
{
    /**
     * Display a listing of the queue jobs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    // Retrieve all jobs from the database and order them by their ID in descending order
    $jobs = Jobs::orderBy('id', 'desc')->get();

    // Pass the retrieved jobs to the 'queue-management' view
    return view('queue-management', compact('jobs'));
}

    /**
     * Cancel a specific job from the queue.
     *
     * @param int $jobId The ID of the job to be cancelled.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function cancelJob($jobId)
{
    // Find the job with the given jobId
    $job = Jobs::find($jobId);

    // Check if the job exists
    if ($job) {
        // If the job exists, delete it from the database
        $job->delete();

        // Return a redirect response back to the previous page with a success message
        return back()->with('cancell','Successfully Cancelled');
    } else {
        // If the job does not exist, return a JSON response with a 404 status code and an error message
        return response()->json(['message' => 'Job not found'], 404);
    }
}

    /**
     * Re-execute a specific job from the queue after a delay.
     *
     * @param int $jobId The ID of the job to be re-executed.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reExecuteJob($jobId)
    {
        // Find the job with the given job ID
        $job = Jobs::find($jobId);
        
        if ($job) {
            // Set a delay of 5 minutes for re-executing the job
            $delayInMinutes = 5;
    
            // Re-queue the job with a delay using the specified connection
            Queue::connection($job->connection)->later(now()->addMinutes($delayInMinutes), $job);
    
            // Delete the original job from the queue
            $job->delete();
            
            // Redirect back to the previous page with a success message
            return back()->with('reExecute','Successfully Re-executed');
        } else {
            // If the job is not found, return a JSON response with a 404 status code
            return response()->json(['message' => 'Job not found'], 404);
        }
    }
}
