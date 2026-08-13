<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Log::info('Admin logged in', [
                'admin_id' => $admin->id,
                'email' => $admin->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            session(['admin_id' => $admin->id, 'admin_name' => $admin->name]);
            return redirect()->route('admin.dashboard');
        }

        Log::warning('Admin login failed', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request)
    {
        Log::info('Admin logged out', [
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);
        session()->forget(['admin_id', 'admin_name']);
        return redirect()->route('admin.login');
    }

    /**
     * Change admin password - auto logout on success
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Admin::find(session('admin_id'));

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found.',
            ], 404);
        }

        // ─── VERIFY CURRENT PASSWORD ───
        if (!Hash::check($request->current_password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        // ─── UPDATE PASSWORD ───
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        Log::info('Admin password changed', [
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'ip' => $request->ip(),
        ]);

        // ─── CLEAR SESSION AND LOGOUT ───
        session()->forget(['admin_id', 'admin_name']);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully! You will be redirected to login.',
            'logout' => true,
        ]);
    }
    
    /**
     * Send password reset link
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        
        // ─── GENERATE RESET TOKEN ───
        $token = \Illuminate\Support\Str::random(64);
        
        // ─── STORE TOKEN IN DATABASE ───
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // ─── SEND RESET EMAIL ───
        try {
            \Mail::send('emails.admin.password-reset', [
                'token' => $token,
                'email' => $request->email,
                'adminName' => $admin->name,
            ], function($message) use ($request) {
                $message->to($request->email)
                        ->subject('Reset Your Admin Password - ' . env('PROJECT_NAME', 'The Collective'));
            });

            Log::info('Password reset link sent', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password reset link has been sent to your email.',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send password reset email', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send reset link. Please try again.',
            ], 500);
        }
    }
}