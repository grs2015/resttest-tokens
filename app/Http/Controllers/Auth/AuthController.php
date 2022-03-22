<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController
{
    public function register(RegisterRequest $request) {

        $userData = $request->safe()->only('first_name', 'last_name', 'email');
        $userData['password'] = \Hash::make($request->input('password'));
        $userData['verified'] = User::UNVERIFIED_USER;
        $userData['verification_token'] = User::generateVerificationToken();
        $userData['admin'] = $request->path() === 'api/admin/register' ? User::ADMIN_USER : User::REGULAR_USER;
        $userData['customer_id'] = $request->input('customer_id'); // Убрать потом! Только для тестирования

        $user = User::create($userData);
        // event(new Registered($user));

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request) {
        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $user = \Auth::user();

        $adminLogin = $request->path() === 'api/admin/login';

        if ($adminLogin && !$user->isAdmin()) {
            return response(['error' => 'Access Denied!'], Response::HTTP_UNAUTHORIZED);
        }

        $scope = $adminLogin ? 'admin' : 'user';

        $jwt = $user->createToken('token', [$scope])->plainTextToken;        
        $cookie = cookie('jwt', $jwt, 60 * 24);

        return response(['message' => 'success'])->withCookie($cookie);
    }

    public function logout() {
        $cookie = \Cookie::forget('jwt');

        return response(['message' => 'success'])->withCookie($cookie);
    }

    public function user(Request $request) {        
        $user = $request->user();

        return new UserResource($user);
    }
}
