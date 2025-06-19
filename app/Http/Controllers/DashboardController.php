<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function index(Request $request)
    // {
    //     $search = $request->input('search', '');  // Default to empty string if not provided

    //     $search = $request->query('search');
    //     $stores = Store::when($search, function ($query, $search) {
    //         return $query->where('name', 'like', "%{$search}%");
    //     })->paginate(10);

    //     // dd($stores);




    //     // Fetch stores for each category
    // $recentStores = Store::whereHas('categories', function ($query) {
    //     $query->where('category_id', 1); // Recent
    // })->get();

    // $highestRatedStores = Store::whereHas('categories', function ($query) {
    //     $query->where('category_id', 2); // Highest Rated
    // })->get();

    // $mostPopularStores = Store::whereHas('categories', function ($query) {
    //     $query->where('category_id', 3); // Most Popular
    // })->get();

    // return view('dashboard', compact('recentStores', 'highestRatedStores', 'mostPopularStores'));

    //     // return view('dashboard', compact('stores', 'search'));
    // }

    public function index(Request $request)
    {
        // Get the search query, defaulting to an empty string if not provided
        $search = $request->input('search', ''); 

        // Fetch stores for each category, applying search filters if needed
        $recentStores = Store::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->whereHas('categories', function ($query) {
                            $query->where('category_id', 1); // Recent
                        });
        }, function ($query) {
            return $query->whereHas('categories', function ($query) {
                $query->where('category_id', 1); // Recent
            });
        })->paginate(10);

        $highestRatedStores = Store::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->whereHas('categories', function ($query) {
                            $query->where('category_id', 2); // Highest Rated
                        });
        }, function ($query) {
            return $query->whereHas('categories', function ($query) {
                $query->where('category_id', 2); // Highest Rated
            });
        })->paginate(10);

        $mostPopularStores = Store::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->whereHas('categories', function ($query) {
                            $query->where('category_id', 3); // Most Popular
                        });
        }, function ($query) {
            return $query->whereHas('categories', function ($query) {
                $query->where('category_id', 3); // Most Popular
            });
        })->paginate(10);

        return view('dashboard', compact('recentStores', 'highestRatedStores', 'mostPopularStores', 'search'));
    }

    public function showCategory($id)
    {
        // Fetch stores based on category
        $stores = Store::whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->get();

        // Pass the stores to a view or return the response
        return view('category', compact('stores')); // category.blade.php should handle this view
    }

    // Method to handle "View All" functionality for a specific category
    public function viewAll($categoryId)
    {
        // Fetch stores based on the selected category and paginate
        $stores = Store::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->paginate(10); // Paginate the stores

        $category = Category::find($categoryId); // Fetch the category name to pass to the view

        return view('view-all', compact('stores', 'category'));
    }
}
