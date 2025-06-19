<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Stores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold text-gray-800">{{ ucfirst($category->name) }} Stores</h3>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($stores as $store)
                            <a 
                                href="{{ route('store.show', $store->id) }}" 
                                class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            >
                                <h3 class="text-lg font-semibold text-gray-800">{{ $store->name }}</h3>
                                <p class="mt-2 text-sm text-gray-600">{{ $store->description }}</p>
                                <p class="mt-2 text-sm text-gray-600">
                                    <svg 
                                        xmlns="http://www.w3.org/2000/svg" 
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke-width="1.5" 
                                        stroke="currentColor" 
                                        class="inline-block w-5 h-5 text-blue-400 mr-1"
                                    >
                                        <path 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            d="M12 2.25c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 13.125A4.125 4.125 0 1112 6.375a4.125 4.125 0 010 8.25z"
                                        />
                                    </svg>
                                    {{ $store->location }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
