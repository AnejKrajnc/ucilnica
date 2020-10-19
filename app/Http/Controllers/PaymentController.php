<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\NewUser;
use App\User;
use App\Item;
use App\OrderProcess;
use App\Order;
use App\Customer;
use App\CourseEnrolled;
use App\Http\Controllers\Payment\Paypal;

class PaymentController extends Controller
{
    function index() {
        return view('nakup', ['items' => Item::all()]);
    }
    function orderStepOne(Request $request) {
        $input = $request->all();
        $validated = $request->validate([
            'ime' => 'required|max:255',
            'priimek' => 'required|max:255',
            'telefon' => 'required|max:25',
            'email' => 'required|email|unique:order_process',
            'naslov' => 'required|max:255',
            'kraj' => 'required|max:255',
            'postal' => 'required|integer',
            'izdelek' => 'required|integer',
        ]);
        $orderprocess = OrderProcess::create([
            'first_name' => $input['ime'],
            'last_name' => $input['priimek'],
            'phone' => $input['telefon'],
            'email' => $input['email'],
            'naslov' => $input['naslov'],
            'kraj' => $input['kraj'],
            'postal' => $input['postal'],
            'izdelek' => $input['izdelek'],
            'payment' => '',
            'status' => 0,
            'process_token' => Str::random(60),
        ]);
        return redirect('/nakup/'.$orderprocess->process_token.'?step=2');
    }
    function orderProcess(Request $request) {
        $token = $request->token;
        $input = $request->all();
        $orderprocess = OrderProcess::where('process_token', $token)->first();
        if ($request->isMethod('post')) {
            if ($input['step'] == 2) {
                $request->validate([
                    'nacin-placila' => 'required',
                ]);
                $orderprocess->payment = $input['nacin-placila'];

                $orderprocess->save();

                if ($orderprocess->payment == 'paypal') {
                    return view('nakup', ['step' => 'paypal']);
                }
            }
        }
        else {
            if(isset($input['step'])) {
                if ($input['step'] == 2) {
                    return view('nakup', ['step' => 2]);
                }
            }
            if (!empty($input['paymentID']) && !empty($input['token']) && !empty($input['payerID']) && !empty($input['pid'])) {
                $this->orderProcess();
            }
        }
    }
    function orderProcessValidate(Request $request) {
        $input = $request->all();

        $paypal = new Paypal;

        $orderProcess = OrderProcess::where('process_token', $request->token)->first();

        $paymentCheck = $paypal->validate($input['paymentID'], $input['token'], $input['payerID'], $input['pid']);

        if ($paymentCheck && $paymentCheck->state == 'approved') {
            $customer = Customer::firstOrCreate([
                'first_name' => $orderProcess->first_name,
                'last_name' => $orderProcess->last_name,
                'phone' => $orderProcess->phone,
                'email' => $orderProcess->email,
                'naslov' => $orderProcess->naslov,
                'kraj' => $orderProcess->kraj,
                'postal' => $orderProcess->postal
            ]);
            $order = Order::create([
                'customer_id' => $customer->id,
                'order_status' => 'paid (active)',
                'order_date' => NOW(),
                'payment_type' => 'paypal'
            ]);

            $item = Item::where('id', $orderProcess->izdelek)->first();

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $orderProcess->izdelek,
                'quantity' => 1.00,
                'totalprice' => $item->price,
                'discount' => 0.00
            ]);

            $orderProcess->delete();

            $newUser = User::firstOrCreate([
                'name' => $customer->first_name,
                'email' => $customer->email,
                'avatar' => 'users/default-png',
                'usertype' => 'student',
                'password' => Hash::make($password = Str::random(12)),
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'customer_id' => $customer->id
            ]);

            CourseEnrolled::create([
                'user_id' => $newUser,
                'course_id' => $item->course_id
            ]);

            Mail::to($customer->email)->send(new User($newUser, $password)); //Ob potrditvi paypal-a pošlji email novemu uporabniku

            return view('nakup', ['step' => 3, 'data' => $paymentCheck, 'payment' => 'paypal']); //Ob potrjenem plačilu 
        }
        else {
            return view('nakup', ['napaka' => true]);
        }
    }
}
