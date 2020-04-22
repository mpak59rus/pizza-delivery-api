<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function index (Request $request)
    {
        if (!$request->user()) {
            throw new AuthenticationException();
        }

        $result = OrderRepository::getUserOrders($request->user());

        return new Response($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param OrderRequest $orderRequest
     * @return Response
     */
    public function create (OrderRequest $orderRequest)
    {
        $user = $orderRequest->user();

        if (!$user) {
            $user = User::where('email', $orderRequest['email'])->first();
        }

        OrderRepository::create($orderRequest, $user);

        return response(['message' => 'Your order is accepted'], 200);
    }
}
