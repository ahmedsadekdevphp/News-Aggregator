<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusEmail;

class UserController extends Controller
{
    public function showEmailForm($orderId)
    {
        $order = Order::with('user')->findOrFail($orderId);
        return view('admin.users.send-email', compact('order'));
    }

    public function sendEmail(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        Mail::to($order->user->email)->send(new OrderStatusEmail($order, $request->subject, $request->body));
        return redirect()->route('admin.orders.index')->with('success', trans('order.Email sent successfully'));
    }
}
