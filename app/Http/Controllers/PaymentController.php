<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function show() {
        return view('payment');
    }

    public function process(Request $request) {
        $request->validate([
            'stripeToken' => 'required'
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        Charge::create([
            'amount' => 1000, // $10.00
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Test Charge',
        ]);

        return back()->with('status', 'Payment successful!');
    }
}
