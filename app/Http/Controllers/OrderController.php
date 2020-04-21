<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index (Request $request)
    {
        if (!$request->user()) {
            return response(['errors' => 'Unauthenticated'], 401);
        }

        $userId = $request->user();
        $result = [];
        $orders = Order::all(Order::ORDER_FIELDS)->where('user_id','=', $userId)->sortBy('created_at');
        foreach ($orders as $order) {
            $result[$order->id] = [
                'email' => $order->email,
                'name' => $order->name,
                'address' => $order->address,
                'comment' => $order->comment,
                'sum' => $order->sum,
                'currency' => $order->currency,
                'paid_delivery'  => $order->paid_delivery,
                'items' => []
            ];
            foreach ($order->items() as $item) {
                $result[$order->id]['items'][] = [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ];
            }
        }
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
        if (!$orderRequest['items']) {
            return response(['message' => 'No products', 'errors' => ['items' => "Order can't be empty"]], 422);
        }

        $user = $orderRequest->user();
        if (!$user) {
            $user = User::where('email', $orderRequest['email'])->first();
        }
        $order = new Order([
            'user_id' => isset($user) ? $user->id : null,
            'email' => isset($user) ? $user->email : $orderRequest['email'],
            'name' => $orderRequest['name'],
            'address' => $orderRequest['address'],
            'comment' => $orderRequest['comment'],
            'currency' => $orderRequest['currency'],
            'paid_delivery' => $orderRequest['paid_delivery']
        ]);
        $order->save();

        $orderSum = 0;
        if  ($order->paid_delivery) {
            if ($order->currency === Order::CURRENCY_USD) {
                $orderSum += env('deliveryUSD');
            } else {
                $orderSum += env('deliveryEUR');
            }
        }

        $sort = 0;
        foreach ($orderRequest['items'] as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'sort' => $sort++
                ]);
                $orderItem->save();

                if ($order->currency === Order::CURRENCY_USD) {
                    $orderSum += $product->price_usd * $item['quantity'];
                } else {
                    $orderSum += $product->price_eur * $item['quantity'];
                }
            }
        }
        $order->sum = $orderSum;
        $order->save();

        return response(['message' => 'Your order is accepted'], 200);
    }
}
