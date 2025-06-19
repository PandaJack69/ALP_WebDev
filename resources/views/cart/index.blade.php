<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Cart') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4 pb-10">
        {{-- <h1 class="text-3xl font-extrabold mb-6 text-gray-800">{{ __('Your Cart') }}</h1> --}}

        <!-- Notice Section -->
        <div class="p-4 mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
            <p class="text-sm font-medium">
                {{ __('Note: To proceed with checkout, you must purchase at least two items from the same merchant.') }}
            </p>
        </div>

        @php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $totalAmount = 0;
        @endphp

        @foreach($days as $day)
            <div class="mt-8">
                <div class="relative inline-block">
                    <!-- Gradient background with updated height and width -->
                    <div 
                        class="absolute top-0 left-0 h-full w-[150%] bg-gradient-to-r from-amber-500 via-yellow-500 to-transparent shadow-lg border-b border-gray-100"
                        style="opacity: 1;">
                    </div>
                    <!-- Text on top of the gradient -->
                    <div class="relative flex items-center justify-center h-full">
                        <h2 class="text-xl font-semibold text-gray-100 px-10 pt-2 pb-2 drop-shadow-md">
                            {{ $day }}
                        </h2>
                    </div>
                </div>
                
                @if($cartItems->has($day) && $cartItems[$day]->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @php
                            $merchantItemsCount = $cartItems[$day]->groupBy(fn($cartItem) => $cartItem->item->store->merchant->id)->map->count();
                        @endphp

                        @foreach($cartItems[$day] as $cartItem)
                        @php
                            $price = $cartItem->item->price ?? 0;
                            $subtotal = $price * $cartItem->quantity;
                            $totalAmount += $subtotal;
                        @endphp
                        <div class="bg-white p-6 border border-gray-200 rounded-lg shadow hover:shadow-lg transition duration-300">
                            <a href="{{ route('store.show', $cartItem->item->store_id) }}" class="block">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $cartItem->item->name ?? 'N/A' }}</h3>
                                <p class="text-gray-600 mt-2">{{ __('Price: $') . number_format($price, 2) }}</p>
                                <p class="text-gray-600">{{ __('Quantity: ') . $cartItem->quantity }}</p>
                                <p class="text-gray-800 font-bold mt-2">{{ __('Subtotal: $') . number_format($subtotal, 2) }}</p>
                            </a>
                            <div class="flex items-center justify-between mt-4 space-x-2">
                                <form action="{{ route('cart.update', $cartItem->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">
                                        -
                                    </button>
                                </form>
                                <form action="{{ route('cart.update', $cartItem->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        +
                                    </button>
                                </form>
                                <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        {{ __('Remove') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Display warning if insufficient items per merchant -->
                    @foreach($merchantItemsCount as $merchantId => $count)
                        @if($count < 2)
                            <p class="text-red-600 mt-2 text-sm">
                                {{ __('You need to add at least ') . (2 - $count) . __(' more item(s) from ') . ($cartItems[$day]->first()->item->store->merchant->name ?? 'this merchant') . __(' to proceed with checkout.') }}
                            </p>
                        @endif
                    @endforeach
                @else
                    <p class="text-gray-500 mt-2">{{ __('No items for ') }} {{ $day }}</p>
                @endif
                {{-- @if($cartItems->has($day) && $cartItems[$day]->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach($cartItems[$day] as $cartItem)
                            @php
                                $price = $cartItem->item->price ?? 0;
                                $subtotal = $price * $cartItem->quantity;
                                $totalAmount += $subtotal;
                            @endphp
                            <div class="bg-white p-6 border border-gray-200 rounded-lg shadow hover:shadow-lg transition duration-300">
                                <a href="{{ route('store.show', $cartItem->item->store_id) }}" class="block">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $cartItem->item->name ?? 'N/A' }}</h3>
                                    <p class="text-gray-600 mt-2">{{ __('Price: $') . number_format($price, 2) }}</p>
                                    <p class="text-gray-600">{{ __('Quantity: ') . $cartItem->quantity }}</p>
                                    <p class="text-gray-800 font-bold mt-2">{{ __('Subtotal: $') . number_format($subtotal, 2) }}</p>
                                </a>
                                <div class="flex items-center justify-between mt-4 space-x-2">
                                    <form action="{{ route('cart.update', $cartItem->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="decrease">
                                        <button type="submit" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">
                                            -
                                        </button>
                                    </form>
                                    <form action="{{ route('cart.update', $cartItem->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            +
                                        </button>
                                    </form>
                                    <form action="{{ route('cart.destroy', $cartItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                            {{ __('Remove') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 mt-2">{{ __('No items for ') }} {{ $day }}</p>
                @endif --}}
            </div>
        @endforeach

        <div class="mt-8 p-6 bg-gray-100 border border-gray-200 rounded-lg">
            <h2 class="text-2xl font-bold text-gray-700">{{ __('Total Amount: $') . number_format($totalAmount, 2) }}</h2>
            <div class="mt-4">
                @if(!$cartItems->isEmpty())
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="store_id" value="{{ $store->id }}">
                        <input type="hidden" name="amount" value="{{ $totalAmount }}">
                        <button type="submit" class="px-6 py-3 bg-green-500 text-white font-bold rounded hover:bg-green-600">
                            {{ __('Proceed to Checkout') }}
                        </button>
                    </form>
                @else
                    <p class="text-gray-500">{{ __('Your cart is empty.') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
