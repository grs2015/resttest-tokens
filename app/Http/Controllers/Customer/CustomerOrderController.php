<?php

namespace App\Http\Controllers\Customer;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class CustomerOrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $orders = $customer->orders;

        return $this->showAll($orders, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Customer $customer)
    {
        $request->validate([
            'order_number' => ['required', 'regex:/\d{4}\/\d{2}/i', 'unique:orders']
        ]);

        $orderData = $request->only(['order_number']);

        $orderData['order_date'] = now()->toDateString();
        $orderData['customer_id'] = $customer->id;

        $order = Order::create($orderData);

        return $this->showOne($order, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer, Order $order)
    {
        $minDate = Carbon::now()->subYears(Order::ORDER_NUMBER_PERIOD)->toDateString();

        $request->validate([
            'order_number' => ['regex:/\d{4}\/\d{2}/i', 'unique:orders'],
            'order_date' => 'date|before_or_equal:now|after:'.$minDate,
        ]);

        $this->checkCustomer($customer, $order);

        $order->fill($request->only(['order_number', 'order_date']));

        if ($order->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $order->save();

        return $this->showOne($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, Order $order)
    {
        $this->checkCustomer($customer, $order);

        $order->delete();

        return $this->showOne($order, Response::HTTP_OK);
    }

    public function checkCustomer(Customer $customer, Order $order)
    {
        if ($customer->id != $order->customer_id) {
            throw new HttpException(422, 'The specified customer is not the actual owner of the order');
        }
    }
}
