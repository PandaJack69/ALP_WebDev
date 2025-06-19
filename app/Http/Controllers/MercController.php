<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MercController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $user = Auth::user();

        // Ensure the user has an associated merchant record
        $merchant = $user->merchant;

        if (!$merchant) {
            dd('No merchant found for this user.', $user);
        }

        // Calculate the merchant's revenue
         $merchantRevenue = \DB::table('items')
        ->join('stores', 'items.store_id', '=', 'stores.id')
        ->join('carts', 'carts.user_id', '=', 'stores.merchant_id') // Linking carts to users, then to merchants
        ->where('stores.merchant_id', $merchant->id)
        ->sum('items.price');

        // Fetch stores for the logged-in merchant with search functionality
        $merchant_store = $merchant->stores()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate(10);

        // Pass revenue and other data to the view
        return view('merchant-dashboard', compact('merchant_store', 'search', 'merchantRevenue'));
    }
}
