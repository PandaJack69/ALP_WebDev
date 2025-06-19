<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('You are now logged in as Merchant!') }}
        </h2>
    </x-slot>

    <!-- Merchant Info Section -->
    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
            <div class="text-center">
                <p class="text-lg text-gray-600 mt-2">Welcome back, {{ Auth::user()->name }}</p>
                <p class="text-xl font-medium text-gray-800 mt-4">
                    Revenue: ${{ number_format($merchantRevenue, 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="py-6">
        <form method="GET" action="{{ route('merchant-dashboard') }}" class="max-w-4xl mx-auto flex items-center space-x-4">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}" 
                placeholder="Search stores" 
                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300"
            >
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Search
            </button>
        </form>
    </div>

    <!-- List of Stores -->
    <div class="container mx-auto mt-8 px-4 max-w-4xl">
        @if ($merchant_store->isEmpty())
            <p class="text-center text-gray-600">You currently have no stores. <a href="{{ route('merchant_store.create') }}" class="text-blue-500 hover:underline">Create one</a> to get started!</p>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($merchant_store as $store)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $store->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('merchant_store.edit', $store->id) }}" class="text-yellow-500 hover:underline">Edit</a> |
                                    <a href="{{ route('merchant_store.show', $store->id) }}" class="text-blue-500 hover:underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $merchant_store->links() }}
            </div>
        @endif
    </div>

    <!-- Add Store Button -->
    <div class="mt-8 text-center pb-10">
        <a 
            href="{{ route('merchant_store.create') }}" 
            class="inline-block px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 shadow-md">
            Add New Store
        </a> 
    </div>
</x-app-layout>
