<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{

    // Constants for days of the week
    private const DAYS_OF_WEEK = [
        'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
    ];

    // Show the details of a store along with its items
    public function show($id)
    {
        $store = Store::findOrFail($id);
        $items = Item::where('store_id', $id)->get();

        return view('store.show', compact('store', 'items'));
    }

    // Show the form to create a new store
    public function create()
    {
        $categories = Category::all(); // Fetch categories from the database
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('store.create', compact('categories', 'daysOfWeek'));
    }

    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'location' => 'nullable|string|max:255', // Optional location field
        'category_id' => 'required|exists:categories,id', // Validate the selected category exists
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        'items.*.name' => 'required|string|max:255',
        'items.*.description' => 'nullable|string|max:1000',
        'items.*.price' => 'required|numeric|min:0',
        'items.*.day_of_week' => 'required|in:' . implode(',', self::DAYS_OF_WEEK),
    ]);

    // Retrieve the merchant's ID
    $user = Auth::user();
    $merchant = $user->merchant;

    if (!$merchant) {
        return redirect()->back()->withErrors(['error' => 'You must have a merchant account to create a store.']);
    }

    // Prepare store data with a default image path
    $storeData = [
        'name' => $request->name,
        'description' => $request->description,
        'location' => $request->location,
        'merchant_id' => $merchant->id,
        'store_image' => 'images/default_store.jpeg', // Default image if no image is uploaded
    ];

    // Handle image upload (save in public/images)
    if ($request->hasFile('image')) {
        // Store the image in 'storage/app/public/images'
        $imagePath = $request->file('image')->store('images', 'public');

        // Update store data with the uploaded image's path
        $storeData['store_image'] = $imagePath; // Store relative path (e.g., 'images/store_image.jpg')
    }

    // Create the store in the database
    $store = Store::create($storeData);

    // Associate the store with the selected category (many-to-many relationship)
    $store->categories()->attach($request->category_id);

    // Add items to the store if provided
    if ($request->has('items')) {
        foreach ($request->items as $itemData) {
            $store->items()->create($itemData);
        }
    }

    return redirect()->route('merchant-dashboard')->with('success', 'Store created successfully!');
}

    public function edit($id)
    {
        // Retrieve the currently authenticated user
        $user = Auth::user();
        
        // Get the merchant associated with the user
        $merchant = $user->merchant; // Assuming a `merchant` relationship exists in the User model

        // Abort if the user does not have a merchant account
        if (!$merchant) {
            abort(403, 'Unauthorized action.');
        }

        // Retrieve the store with its associated items
        $store = Store::with('items')->findOrFail($id);

        // Ensure the authenticated merchant owns the store
        if ($store->merchant_id !== $merchant->id) {
            abort(403, 'Unauthorized action.');
        }

        // Pass data to the view, including days of the week
        $daysOfWeek = StoreController::DAYS_OF_WEEK;
        return view('merchant_store.edit', compact('store', 'daysOfWeek'));
    }

    // public function update(Request $request, $id)
    // {

    //     dd($request->all());
        
    //     $user = Auth::user();
    //     $merchant = $user->merchant;

    //     if (!$merchant) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $store = Store::with('items')->findOrFail($id);

    //     if ($store->merchant_id !== $merchant->id) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string|max:1000',
    //         'items.*.id' => 'nullable|exists:items,id',
    //         'items.*.name' => 'required|string|max:255',
    //         'items.*.price' => 'required|numeric|min:0',
    //         'items.*.day_of_week' => 'required|in:' . implode(',', self::DAYS_OF_WEEK),
    //         'new_items.*.name' => 'required|string|max:255',
    //         'new_items.*.price' => 'required|numeric|min:0',
    //         'new_items.*.day_of_week' => 'required|in:' . implode(',', self::DAYS_OF_WEEK),
    //     ]);

    //     $store->update([
    //         'name' => $request->name,
    //         'description' => $request->description,
    //     ]);

    //     // Update existing items
    //     foreach ($request->items as $itemId => $itemData) {
    //         if ($itemId !== 'new') {
    //             $item = $store->items()->find($itemId);
    //             if ($item) {
    //                 $item->update($itemData);
    //             }
    //         }
    //     }

    //     // Add new items
    //     if ($request->has('new_items')) {
    //         foreach ($request->new_items as $newItemData) {
    //             $store->items()->create($newItemData);
    //         }
    //     }

    //     return redirect()->route('merchant-dashboard')->with('success', 'Store updated successfully!');
    // }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $merchant = $user->merchant;

        if (!$merchant) {
            abort(403, 'Unauthorized action.');
        }

        $store = Store::with('items')->findOrFail($id);

        if ($store->merchant_id !== $merchant->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'items.*.name' => 'required|string|max:255',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.day_of_week' => 'required|in:' . implode(',', self::DAYS_OF_WEEK),
        ]);

        // Update store information
        $store->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Update existing items
        if ($request->has('items')) {
            foreach ($request->items as $itemId => $itemData) {
                $item = $store->items()->find($itemId);
                if ($item) {
                    $item->update($itemData);
                }
            }
        }

        // Add new items
        if ($request->has('new_items')) {
            foreach ($request->new_items as $newItemData) {
                $store->items()->create($newItemData);
            }
        }

        return redirect()->route('merchant-dashboard')->with('success', 'Store updated successfully!');
    }

    public function delete($itemId)
    {
        // Find the item by its ID
        $item = Item::find($itemId);
        // $user = Auth::user();

        // Check if the item exists
        if (!$item) {
            return redirect()->back()->with('error', 'Item not found.');
        }

        // Ensure the item belongs to the current merchant's store
        if ($item->store->merchant->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this item.');
        }

        // Delete the item
        $item->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    public function addItem(Request $request, $storeId)
    {
        $store = Store::findOrFail($storeId);

        // Ensure the authenticated user owns the store
        if ($store->merchant_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'day_of_week' => 'required|in:' . implode(',', self::DAYS_OF_WEEK),
        ]);

        // Create the new item with all fields
        $store->items()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'day_of_week' => $request->day_of_week,
        ]);

        return redirect()->route('merchant_store.edit', $storeId)->with('success', 'Item added successfully!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $merchant = $user->merchant;

        if (!$merchant) {
            return redirect()->route('merchant-dashboard')->with('error', 'Unauthorized action.');
        }

        // Find the store by ID
        $store = Store::findOrFail($id);

        // Ensure the store belongs to the current merchant
        if ($store->merchant_id !== $merchant->id) {
            return redirect()->route('merchant-dashboard')->with('error', 'You are not authorized to delete this store.');
        }

        // Delete the store and its associated items
        $store->delete();

        return redirect()->route('merchant-dashboard')->with('success', 'Store deleted successfully.');
    }
}
