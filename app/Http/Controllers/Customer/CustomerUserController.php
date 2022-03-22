<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomerUserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $users = $customer->users;

        return $this->showAll($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request, Customer $customer)
    {
        $userData = $request->safe()->only('first_name', 'last_name', 'email', 'purchase_role');
        $userData['password'] = \Hash::make($request->input('password'));
        $userData['verified'] = User::UNVERIFIED_USER;
        $userData['verification_token'] = User::generateVerificationToken();
        $userData['admin'] = User::REGULAR_USER;
        $userData['customer_id'] = $customer->id;


        $user = User::create($userData);

        //TODO Закомментировано на будущее. Нужен будет вызов событи event(new Registered($user));

        return $this->showOne($user, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer, User $user)
    {
        $request->validate([
            'email' => ['email', Rule::unique('users')->ignore($user->id)],
            'password' => 'min:6|confirmed',
            'admin' => Rule::in([User::ADMIN_USER, User::REGULAR_USER]),
        ]);

        $this->checkCustomer($customer, $user);

        if ($request->has('first_name')) {
            $user->first_name = $request->input('first_name');
        }

        if ($request->has('last_name')) {
            $user->last_name = $request->input('last_name');
        }

        if ($request->has('email') && $user->email != $request->input('email')) {
            $user->email = $request->input('email');
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationToken();

            // TODO: Реализовать отправку события - Email Update, event(new Registered($user));
        }

        if ($request->has('password')) {
            $user->password = \Hash::make($request->input('password'));
        }

        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify an admin field', Response::HTTP_CONFLICT);
            }

            $user->admin = $request->input('admin');
        }

        if ($user->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->showOne($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, User $user)
    {
        $this->checkCustomer($customer, $user);

        $user->delete();

        return $this->showOne($user, Response::HTTP_OK);
    }

    public function checkCustomer(Customer $customer, User $user)
    {
        if ($user->customer_id != $customer->id) {
            throw new HttpException(422, 'The specified customer is not the actual owner of the user');
        }
    }
}
