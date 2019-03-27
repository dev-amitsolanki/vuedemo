<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;
use Auth;
// use Zend\Diactoros\Request;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'messsage' => 'We can`t find a user with that e-mail address'
            ], 404);
        }
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]
        );

        if ($user && $passwordReset) {
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        }
        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }
    /**
     * Find token pasword reset
     *
     * @param [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {

        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset)
            return response()->json([
            'message' => 'This password reset token is invalid.'
        ], 404);

        if (Carbon::parse($passwordReset->update_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        // return redirect()->to('/#/ResetPassword');
        return view('resetPassword', compact('passwordReset'));
        // return response()->json([
        //     'body' => redirect()->to('/#/ResetPassword'),
        //     'data' => $passwordReset
        //     ]);
        // dd($passwordReset);
    }
    /**
     *
     * @param [string] email
     * @param [string] password
     * @param [string] password_confirmation
     * @param [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        // $this->validate($request, [
            //     'email' => 'required',
            //     'password' => 'required',
            //     'token' => 'required'
            // ]);
        $passwordReset = PasswordReset::where('token', $request->token)->where('email', $request->email)->first();
        // dd($passwordReset);

        if (!$passwordReset)
            return response()->json(['message' => 'This password reset token is invalid.']);

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user)
            return response()->json(['message' => 'This password reset token is invalid.']);

        $user->password = \Hash::make($request->password);
        $user->save();

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess($passwordReset));

        return redirect()->to('/#');
    }
}
