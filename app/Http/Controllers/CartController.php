<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Merchant;
use App\Models\Store;

class CartController extends Controller
{
    // Method to add an item to the cart
    public function add(Request $request)
    {
        // Validate request data
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'quantity' => 'nullable|integer|min:1'
        ]);

        // Ensure the user is authenticated
        $userId = auth()->id();
        if (!$userId) {
            // Redirect unauthenticated user to the login page
            return redirect()->route('login');
        }

        // Find or create a cart for the user
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        // Add the item to the cart
        $cart->cartItems()->create([
            'item_id' => $request->item_id,
            'day_of_week' => $request->day_of_week,
            'quantity' => $request->quantity ?? 1,
        ]);

        // Redirect back with a success message
        return back()->with('success', 'Item added to cart.');
    }

    // Method to view the cart
    public function view()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('cartItems.item') // Eager-load the item relationship
            ->first();

        $cartItems = $cart ? $cart->cartItems : collect(); // Ensure it's a collection even if the cart is null

        return view('cart.index', compact('cartItems'));
    }
    public function index()
    {
        $userId = Auth::id();

        // Fetch or create the user's cart
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $userId]);
        }

        // Retrieve cart items grouped by day of the week
        $cartItems = CartItem::with('item.store') // Eager load the item and its store
            ->where('cart_id', $cart->id)
            ->get()
            ->groupBy('day_of_week');

        // Check if there are any cart items
        $store = null;
        if ($cartItems->isNotEmpty()) {
            // Get the store from the first cart item
            $store = $cartItems->first()->first()->item->store ?? null;
        }

        // Pass both $cartItems and $store to the view
        return view('cart.index', compact('cartItems', 'store'));
    }

    public function update(Request $request, $cartItemId)
    {
        // Validate input
        $request->validate([
            'action' => 'required|in:increase,decrease',
        ]);

        // Find the cart item
        $cartItem = CartItem::findOrFail($cartItemId);

        // Adjust quantity based on action
        if ($request->action === 'increase') {
            $cartItem->increment('quantity');
        } elseif ($request->action === 'decrease' && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }

        // Redirect back with a success message
        return back()->with('success', 'Cart updated.');
    }

    public function destroy($cartItemId)
    {
        // Find and delete the cart item
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();

        // Redirect back with a success message
        return back()->with('success', 'Item removed from cart.');
    }

    // public function checkout(Request $request)
    // {

    //     $user = Auth::user();
    //     $cart = Cart::where('user_id', $user->id)->with('cartItems.item.store.merchant')->first();

    //     // Validate request
    //     $request->validate([
    //         'store_id' => 'required|exists:stores,id',
    //         'amount' => 'required|numeric|min:0',
    //     ]);

    //     $storeId = $request->store_id;
    //     $amount = $request->amount;

    //     $store = Store::findOrFail($storeId);

    //     // Find the store and its merchant
    //     $store = Store::with('merchant')->findOrFail($storeId);

    //     if (!$store->merchant) {
    //         return redirect()->back()->with('error', 'Merchant not found for this store.');
    //     }

    //     // Update the merchant's revenue
    //     $merchant = $store->merchant;
    //     $merchant->revenue += $amount;
    //     $merchant->save();

    //     $cart->cartItems()->delete();

    //     return redirect()->route('checkout.success')->with('success', 'Checkout completed successfully!');
    // }

    // public function checkout(Request $request)
    // {
    //     $user = Auth::user();
    //     $cart = Cart::where('user_id', $user->id)
    //         ->with('cartItems.item.store.merchant') // Load related merchant and store data
    //         ->first();

    //     if (!$cart || $cart->cartItems->isEmpty()) {
    //         return redirect()->back()->with('error', 'Your cart is empty.');
    //     }

    //     // Group cart items by merchant_id
    //     $groupedCartItems = $cart->cartItems->groupBy(function ($cartItem) {
    //         return $cartItem->item->store->merchant->id ?? null;
    //     });

    //     // Validate that all items belong to a merchant
    //     foreach ($groupedCartItems as $merchantId => $items) {
    //         if (is_null($merchantId)) {
    //             return redirect()->back()->with('error', 'Some items in your cart do not have an associated merchant.');
    //         }
    //     }

    //     // Calculate total for each merchant and update their revenue
    //     foreach ($groupedCartItems as $merchantId => $items) {
    //         $totalAmount = $items->sum(function ($cartItem) {
    //             return $cartItem->item->price * $cartItem->quantity;
    //         });

    //         $merchant = Merchant::find($merchantId);
    //         if ($merchant) {
    //             $merchant->revenue += $totalAmount;
    //             $merchant->save();
    //         }
    //     }

    //     // Clear the user's cart after successful checkout
    //     $cart->cartItems()->delete();

    //     return redirect()->route('checkout.success')->with('success', 'Checkout completed successfully for all merchants!');
    // }

    public function checkout(Request $request)
{
    $user = Auth::user();
    $cart = Cart::where('user_id', $user->id)
        ->with('cartItems.item.store.merchant') // Load related merchant and store data
        ->first();

    if (!$cart || $cart->cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your cart is empty.');
    }

    // Group cart items by merchant_id
    $groupedCartItems = $cart->cartItems->groupBy(function ($cartItem) {
        return $cartItem->item->store->merchant->id ?? null;
    });

    // Validate that each merchant has at least two items
    foreach ($groupedCartItems as $merchantId => $items) {
        if (is_null($merchantId)) {
            return redirect()->back()->with('error', 'Some items in your cart do not have an associated merchant.');
        }

        if ($items->count() < 2) {
            $merchantName = $items->first()->item->store->merchant->name ?? 'Unknown Merchant';
            return redirect()->back()->with('error', "You must purchase at least two items from $merchantName to proceed with checkout.");
        }
    }

    // Calculate total for each merchant and update their revenue
    foreach ($groupedCartItems as $merchantId => $items) {
        $totalAmount = $items->sum(function ($cartItem) {
            return $cartItem->item->price * $cartItem->quantity;
        });

        $merchant = Merchant::find($merchantId);
        if ($merchant) {
            $merchant->revenue += $totalAmount;
            $merchant->save();
        }
    }

    // Clear the user's cart after successful checkout
    $cart->cartItems()->delete();

    return redirect()->route('checkout.success')->with('success', 'Checkout completed successfully for all merchants!');
}



}
