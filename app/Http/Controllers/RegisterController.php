<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }
    public function reset()
    {
        return view('reset');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $details = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        
        dispatch(new SendEmailJob($details));
        
        return back()->with('success','Succesfully Registered');
    }
    public function resetPassword(Request $request)
{
    try {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'oldpassword' => ['required', 'string', 'min:3'],
            'newpassword' => ['required', 'string', 'min:3'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'User not found']);
        }

        if (!Hash::check($request->oldpassword, $user->password)) {
            throw ValidationException::withMessages(['oldpassword' => 'Old password is incorrect']);
        }

        $newPassword = $request->newpassword;

        $user->password = Hash::make($newPassword);
        $user->save();

        $updatedUser = User::where('email', $request->email)->first();

        $details = [
            'name' => $updatedUser->name,
            'email' => $updatedUser->email,
            'newPassword' => $newPassword,
        ];

        dispatch(new SendEmailJob($details))->delay(now()->addMinutes(5));

        return back()->with('success', 'Password has been reset and sent to your email');
    } catch (ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

}
