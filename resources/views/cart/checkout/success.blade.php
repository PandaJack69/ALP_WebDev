<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Checkout Success') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-16">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
            <h1 class="text-3xl font-extrabold text-green-600 mb-4">
                {{ __('Thank You for Your Purchase!') }}
            </h1>
            <p class="text-lg text-gray-700 mb-6">
                {{ __('Your order has been successfully processed.') }}
            </p>
            <a href="{{ route('cart.index') }}" 
               class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded transition duration-300">
                {{ __('Back to Cart') }}
            </a>
        </div>
    </div>
</x-app-layout>



