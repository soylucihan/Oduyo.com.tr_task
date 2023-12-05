<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Display the registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('register');
    }

    /**
     * Display the password reset form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function reset()
    {
        return view('reset');
    }

    /**
     * Handle the registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3'],
        ]);

        // Create a new user record
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Prepare email details
        $details = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        // Dispatch a job to send the registration email
        dispatch(new SendEmailJob($details));

        // Redirect back with success message
        return back()->with('success','Successfully Registered');
    }

    /**
     * Handle the password reset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'oldpassword' => ['required', 'string', 'min:3'],
                'newpassword' => ['required', 'string', 'min:3'],
            ]);

            // Find the user by email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                throw ValidationException::withMessages(['email' => 'User not found']);
            }

            // Check if the old password is correct
            if (!Hash::check($request->oldpassword, $user->password)) {
                throw ValidationException::withMessages(['oldpassword' => 'Old password is incorrect']);
            }

            // Update the user's password
            $newPassword = $request->newpassword;
            $user->password = Hash::make($newPassword);
            $user->save();

            // Get the updated user details
            $updatedUser = User::where('email', $request->email)->first();

            // Prepare email details
            $details = [
                'name' => $updatedUser->name,
                'email' => $updatedUser->email,
                'newPassword' => $newPassword,
            ];

            // Dispatch a job to send the password reset email with a delay of 5 minutes
            dispatch(new SendEmailJob($details))->delay(now()->addMinutes(5));

            // Redirect back with success message
            return back()->with('success', 'Password has been reset and sent to your email');
        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Redirect back with error message
            return back()->with('error', $e->getMessage());
        }
    }
}
