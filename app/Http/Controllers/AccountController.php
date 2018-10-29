<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Mailers\UserMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getVerifyEmail']]);

        $this->user = Auth::user();
    }

    public function postResendConfirmationEmail(UserMailer $mailer)
    {
        if ($this->user->verified_email) {
            return response(['message' => 'Looks like you already verify your email'], 422);
        }

        if (is_null($this->user->email_verification_token)) {
            $this->user->email_verification_token = str_random(60);
            $this->user->save();
        }

        $mailer->sendEmailConfirmation($this->user);

        return [
            'success_title' => 'Success',
            'success_body' => 'A new confirmation email was sent to '.$this->user->email.'.'
        ];
    }

    public function getVerifyEmail($token)
    {
        $user = User::whereVerifiedEmail(0)->whereEmailVerificationToken($token)->firstOrFail();

        $user->verifyEmail();

        Auth::login($user);

        flash()->success('Success', 'Congratulations! you have now full access to this site.');

        return redirect('');
    }

    public function postChangeEmail(Request $request)
    {
        $this->validate($request, [
            'new_email' => 'required|unique:users,email',
            'password' => 'required'
        ]);
        
        if (!$this->user->checkPassword($request->password)) {
            return response(['message' => 'Incorrect password'], 422);
        }

        $this->user->updateEmail($request->new_email);

        return [
            'success_title' => 'Success',
            'success_body' => 'New email was successfully saved and a new confirmation link was sent to '.$this->user->email,
        ];
    }

    public function getSettings()
    {
        return view('accounts.settings');
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $user = $request->user();
        $invalid_current_password = false;

        if (
            ($user->old_user && $user->password != md5($request->current_password.$user->salt)) ||
            (!$user->old_user && !Hash::check($request->current_password, $user->password))
        ) {
            $invalid_current_password = true;
        }

        if ($invalid_current_password) {
            return response(['message' => 'Current password is incorrect'], 422);
        }

        $user->changePassword($request->new_password);

        return [
            'success_title' => 'Success',
            'success_body' => 'Your password has been changed successfully'
        ];
    }
}
