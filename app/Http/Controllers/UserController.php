<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserFilter $filters, Request $request)
    {
        $users = \Cache::remember(
            $this->cacheResponse(),
            $this->cacheTime($request),
            fn() => User::where('admin', User::REGULAR_USER)->filter($filters)->get()
        );

        return $this->showAll($users, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = $user->with('customer')->get()->first();
        return $this->showOne($user, Response::HTTP_OK);
    }
}
