<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Models\OrderedProduct;

class CheckoutController extends Controller
{
    /**
     * Checkout Page
     * @return view
     */
    public function index()
    {
        if(Cart::where('user_id', auth()->user()->id)->exists()){
            return view('checkout', [
            'cart' => Cart::where('user_id', auth()->user()->id)->get()
            ]);
        }
        else{
            return back()->with('error', "Cart is empty!");
        }
    }

    /**
     * Stores Order Details in Orders and OrderDetails Table
     * @return redirect if paymeny mode is offline
     * @return view if paymeny mode is online
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required|min:2|max:100",
            'phone' => "required|min:10|max:12",
            'address' => "required",
            'state' => "required|min:2|max:100",
            'zip_code' => "required|min:6|max:12",
            'city' => "required|min:2|max:100",
            'paymentType' => "required|in:online,cod",
        ]);

        $cart = Cart::where('user_id', auth()->user()->id)->get();

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'amount' => $request->total_price,
            'status' => 'pending',
            'payment_mode' => 'offline'
        ]);

        foreach ($cart as $item) {
            OrderedProduct::create([
                'order_id' => $order->id,
                'product_image' => $item->product->image,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_price' => $item->product->price,
                'category' => $item->product->category->name,
                'quantity' => $item->quantity
            ]);
        }

        if ($request->paymentType === "online") {
            $api = new Api(env("RAZORPAY_API_KEY"), env("RAZORPAY_SECRET_KEY"));

            $order_id = 'O' . $order->id;

            $orderData = [
                'amount' => ($request->total_price * 100),
                'currency' => 'INR',
                'notes' => [
                    'order_id' => $order_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]
            ];

            $razorpayOrder = $api->order->create($orderData);

            return view('order_payment', [
                "order_id" => $order_id,
                "order" => $razorpayOrder
            ]);
        } else {
            Cart::where('user_id', auth()->user()->id)->delete();
            
            return redirect()->route('orders')->with('alert', 'Order Placed Successfully');
        }
    }

    /**
     * Checks Payment Status if payment mode is online
     * @return redirect
     */
    public function paymentVerification(Request $request)
    {
        try {
            // Validate request parameters
            if (!$request->payment_id || !$request->order_id) {
                return redirect()->route('cart')->with('error', 'Invalid payment information');
            }

            $api = new Api(env("RAZORPAY_API_KEY"), env("RAZORPAY_SECRET_KEY"));

            // Fetch and verify payment status
            $payment = $api->payment->fetch($request->payment_id);

            // Extract order ID (remove 'O' prefix)
            $id = substr($request->order_id, 1);

            // Find order or redirect if not found
            $order = Order::find($id);
            if (!$order) {
                return redirect()->route('cart')->with('error', 'Order not found');
            }

            if ($payment && $payment->status === 'captured') {
                // Clear user's cart
                if (auth()->check()) {
                    Cart::where('user_id', auth()->user()->id)->delete();
                }

                // Update order status
                $order->payment_mode = "online";
                $order->status = "confirmed"; // Add status update
                $order->save();

                return redirect()->route('orders')->with('success', 'Payment completed successfully!');
            } else {
                // Handle failed payment
                if ($order) {
                    $order->status = "failed";
                    $order->save();
                }

                return redirect()->route('cart')->with('error', 'Payment failed. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Payment verification error: ' . $e->getMessage());
            return redirect()->route('cart')->with('error', 'Payment verification failed. Please contact support.');
        }
    }
}