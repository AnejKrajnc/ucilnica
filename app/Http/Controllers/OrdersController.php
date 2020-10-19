<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use DB;

class OrdersController extends Controller
{
    public function showOrders() {
        $orders = DB::table('orders')
        ->join('customers', 'customers.id', '=', 'orders.customer_id')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->select('customers.*', 'orders.order_status', 'orders.order_date')->get();
        return view('admin.orders')->withOrders($orders);
    }
    public function showOrderDetails(Request $request) {
        $orderDetails = Order::find($request->id); // Show Order Details
        return view('admin.orderdetails')->withOrderDetails($orderDetails);
    }
    public function updateOrderDetail(Request $request) {
        $order = Order::find($request->id);
        /* Update data about order in database */
        $order->status = "plačano";

        $order->save(); //Update a row in database
        return redirect('/dashboard/orders/'.$request->id);
    }
}
