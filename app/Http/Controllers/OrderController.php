<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Cart;


class OrderController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    public function checkout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $cart = Cart::where('user_id', auth()->id())->with('cartItems.item')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $cart->cartItems->items->sum(fn($cartItems) => $cartItems->item->price * $cartItems->quantity),
            'status' => 'Pending',
        ]);

        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'item_id' => $cartItem->item_id,
                'day_of_week' => $cartItem->day_of_week,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->item->price,
            ]);
        }

        $cart->items()->delete();

        return redirect()->route('dashboard')->with('success', 'Order placed successfully.');
    }
}
