<?php

namespace Repositories;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

abstract class OrderRepository
{
    public static function getUserOrders(string $userId): array
    {
        $result = [];
        $orders = Order::all(Order::ORDER_FIELDS)
            ->where('user_id', '=', $userId)
            ->sortBy('created_at');

        foreach ($orders as $order){
            $result[$order->id] = [
                'email' => $order->email,
                'name' => $order->name,
                'address' => $order->address,
                'comment' => $order->comment,
                'sum' => $order->sum,
                'currency' => $order->currency,
                'paid_delivery' => $order->paid_delivery,
                'items' => []
            ];

            foreach ($order->items() as $item){
                $result[$order->id]['items'][] = [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ];
            }
        }

        return $result;
    }

    public static function create(OrderRequest $orderRequest, User $user)
    {
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

        if ($order->paid_delivery) {
            if ($order->currency === Order::CURRENCY_USD) {
                $orderSum += env('deliveryUSD');
            } else {
                $orderSum += env('deliveryEUR');
            }
        }

        $sort = 0;
        foreach ($orderRequest['items'] as $item){
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
    }
}
