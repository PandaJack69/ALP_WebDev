<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Logged In! Welcome') }}
        </h2>
    </x-slot>
    
        {{-- categories --}}
        <div>

        </div>

        <!-- Search Form -->
        <div class="py-6">
            <form method="GET" action="{{ route('dashboard') }}" class="max-w-4xl mx-auto flex items-center space-x-4">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search stores"
                    class="w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
                <button 
                    type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
                    Search
                </button>
            </form>
        </div>

        <!-- Categories Section -->
        <div class="py-6 max-w-7xl mx-auto">
            
            <!-- Italian Cuisine Stores -->
            <div class="mb-12">
                
                <div class="flex justify-between items-center mb-4">
                    <div class="relative">
                        <!-- Gradient background with updated height and width -->
                        <div 
                            class="absolute h-[100%] w-[150%] bg-gradient-to-r from-amber-500 via-yellow-500 to-transparent shadow-lg border-b border-gray-100"
                            style="opacity: 1;">
                        </div>
                        <!-- Text on top of the gradient -->
                        <div class="relative flex items-center justify-center h-full">
                            <h3 class="text-xl font-semibold text-gray-100 px-10 pt-2 pb-2 drop-shadow-md">
                                Italian Cuisine
                            </h3>
                        </div>
                    </div>
                    
                    {{-- <a href="{{ route('view.all', 1) }}" class="text-blue-500 hover:text-blue-600">View All &rarr;</a> --}}
                </div>
                
                <div class="relative flex items-center space-x-4 flex-wrap">
                    <div class="flex flex-wrap justify-start px-10 space-x-10">
                        @foreach($recentStores as $store)
                            <a 
                                href="{{ route('store.show', $store->id) }}" 
                                class="block w-64 bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-6"
                            >
                                <!-- Store Image with Gradient -->
                                <div class="relative">
                                    <img 
                                        src="{{ asset('images/' . $store->store_image) }}" 
                                        alt="Store Image" 
                                        class="w-full h-48 object-cover"
                                    />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-50"></div>
                                </div>
                                
                                <!-- Store Details -->
                                <div class="p-4 bg-white text-gray-900">
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
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- Japanese Cuisine Stores -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-4">
                    <div class="relative">
                        <!-- Gradient background with updated height and width -->
                        <div 
                            class="absolute h-[100%] w-[150%] bg-gradient-to-r from-amber-500 via-yellow-500 to-transparent shadow-lg border-b border-gray-100"
                            style="opacity: 1;">
                        </div>
                        <!-- Text on top of the gradient -->
                        <div class="relative flex items-center justify-center h-full">
                            <h3 class="text-xl font-semibold text-gray-100 px-10 pt-2 pb-2 drop-shadow-md">
                                Japanese Cuisine
                            </h3>
                        </div>
                    </div>

                    {{-- <a href="{{ route('view.all', 2) }}" class="text-blue-500 hover:text-blue-600">View All &rarr;</a> --}}
                </div>
                <div class="relative flex items-center space-x-4">
                    <div class="flex space-x-10 px-10">
                        @foreach($highestRatedStores as $store)
                            <a 
                                href="{{ route('store.show', $store->id) }}" 
                                class="block w-64 bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            >
                                <!-- Store Image with Gradient -->
                                <div class="relative">
                                    <img 
                                        src="{{ asset('images/' . $store->store_image) }}" 
                                        alt="Store Image" 
                                        class="w-full h-48 object-cover"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-50"></div>
                                </div>
                                
                                <!-- Store Details -->
                                <div class="p-4 bg-white text-gray-900">
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
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Turkish Cuisine Stores -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-4">
                    <div class="relative">
                        <!-- Gradient background with updated height and width -->
                        <div 
                            class="absolute h-[100%] w-[150%] bg-gradient-to-r from-amber-500 via-yellow-500 to-transparent shadow-lg border-b border-gray-100"
                            style="opacity: 1;">
                        </div>
                        <!-- Text on top of the gradient -->
                        <div class="relative flex items-center justify-center h-full">
                            <h3 class="text-xl font-semibold text-gray-100 px-10 pt-2 pb-2 drop-shadow-md">
                                Turkish Cuisine
                            </h3>
                        </div>
                    </div>

                    {{-- <a href="{{ route('view.all', 3) }}" class="text-blue-500 hover:text-blue-600">View All &rarr;</a> --}}
                </div>
                <div class="relative flex items-center space-x-4">
                    <div class="flex space-x-10 px-10">
                        @foreach($mostPopularStores as $store)
                            <a 
                                href="{{ route('store.show', $store->id) }}" 
                                class="block w-64 bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            >
                                <!-- Store Image with Gradient -->
                                <div class="relative">
                                    <img 
                                        src="{{ asset('images/' . $store->store_image) }}" 
                                        alt="Store Image" 
                                        class="w-full h-48 object-cover"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-50"></div>
                                </div>
                                
                                <!-- Store Details -->
                                <div class="p-4 bg-white text-gray-900">
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
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Mexican Cuisine Stores -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-4">
                    <div class="relative">
                        <!-- Gradient background with updated height and width -->
                        <div 
                            class="absolute h-[100%] w-[150%] bg-gradient-to-r from-amber-500 via-yellow-500 to-transparent shadow-lg border-b border-gray-100"
                            style="opacity: 1;">
                        </div>
                        <!-- Text on top of the gradient -->
                        <div class="relative flex items-center justify-center h-full">
                            <h3 class="text-xl font-semibold text-gray-100 px-10 pt-2 pb-2 drop-shadow-md">
                                Mexican Cuisine
                            </h3>
                        </div>
                    </div>

                    {{-- <a href="{{ route('view.all', 2) }}" class="text-blue-500 hover:text-blue-600">View All &rarr;</a> --}}
                </div>
                <div class="relative flex items-center space-x-4">
                    <div class="flex space-x-10 px-10">
                        @foreach($highestRatedStores as $store)
                            <a 
                                href="{{ route('store.show', $store->id) }}" 
                                class="block w-64 bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:-translate-y-1 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            >
                                <!-- Store Image with Gradient -->
                                <div class="relative">
                                    <img 
                                        src="{{ asset('images/' . $store->store_image) }}" 
                                        alt="Store Image" 
                                        class="w-full h-48 object-cover"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-50"></div>
                                </div>
                                
                                <!-- Store Details -->
                                <div class="p-4 bg-white text-gray-900">
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
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
