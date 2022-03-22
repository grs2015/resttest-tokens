<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\UserCreatedMail;
use App\Http\Controllers\ApiController;
use App\Http\Requests\VerifyRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerifyController extends ApiController
{
    /**
     * DONE: Реализовать функционал функций Laravel hasVerifiedEmail, markEmailAsVerified
     *       для реализации подключения MW 'verified'
     *
     *
     * @param Request $request
     * @return void
     */
    public function verify(Request $request)
    {
        if (!$user = User::where('verification_token', $request->input('token'))->first()) {
            throw new NotFoundHttpException('User not found!');
        }

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        $user->save();

        return response([
            'message' => 'The account has been verified successfully'
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function resend(Request $request)
    {
        if (!$user = User::where('email', $request->input('email'))->first()) {
            throw new NotFoundHttpException('User not found!');
        }

        if ($user->isVerified()) {
            return response([
                'message' => 'This user is already verified'
            ], 409);
        }

        $user->sendEmailVerificationNotification();

        return response([
            'message' => 'Verification mail has been sent!',
        ]);
    }
}
