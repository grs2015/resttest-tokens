<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\ResetMail;
use Illuminate\Http\Request;
use App\Http\Requests\ResetRequest;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends ApiController
{
    /**
     * TODO: Доделать проверку существования поля email в request
     * NOTE: Применяется класс Mailer с Markdown (ResetMail)
     *
     *
     * @param Request $request
     * @return void
     */
    public function forgot(Request $request)
    {
        $email = $request->input('email');
        $token = \Str::random(12);

        \DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
        ]);

        \Mail::to($email)->send(new ResetMail($token));

        return response([
            'message' => 'Check your email!',
        ]);
    }

    /**
     * Reset password function
     *
     * @param ResetRequest $request
     * @return void
     */
    public function reset(ResetRequest $request)
    {
        $passwordReset = \DB::table('password_resets')
            ->where('token', $request->input('token'))
            ->first();

        if (!$user = User::where('email', $passwordReset->email)->first()) {
            throw new NotFoundHttpException('User not found!');
        }

        $user->password = \Hash::make($request->input('password'));
        $user->save();

        return response([
            'message' => 'Password successfully changed!'
        ]);
    }
}
