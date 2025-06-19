<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">{{ $store->name }}</h1>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="mb-6 text-gray-700 text-lg">{{ $store->description }}</p>

        @php
            // Group items by day of the week
            $groupedItems = $items->groupBy('day_of_week');
        @endphp

        @foreach($groupedItems as $day => $dayItems)
            <div class="mb-10">
                <!-- Day Header -->
                <h2 class="text-xl font-semibold text-gray-900 border-b pb-2 mb-4">{{ $day }}</h2>

                <!-- Items Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($dayItems as $item)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            <div class="p-4">
                                <!-- Item Name -->
                                <h3 class="text-lg font-bold text-gray-800">{{ $item->name }}</h3>

                                <!-- Item Price -->
                                <p class="text-gray-600 mt-2 text-sm">Price: ${{ number_format($item->price, 2) }}</p>

                                <!-- Add to Cart Button -->
                                <form method="POST" action="{{ route('cart.add') }}" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="day_of_week" value="{{ $day }}">
                                    <button 
                                        type="submit" 
                                        class="w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>