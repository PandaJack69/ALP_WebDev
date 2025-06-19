<div class="py-12 px-6 sm:px-8 lg:px-16 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            {{ __('Stores in ') }} {{ $category->name }} {{ __(' Category') }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($stores as $store)
            <a 
                href="{{ route('store.show', $store->id) }}" 
                class="block bg-white rounded-xl shadow-md overflow-hidden transition transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <div class="relative">
                    <img 
                        src="{{ asset('images/' . $store->store_image) }}" 
                        alt="Store Image" 
                        class="w-full h-48 object-cover rounded-t-xl"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $store->name }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ Str::limit($store->description, 80, '...') }}</p>
                    <div class="mt-3 flex items-center text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 13.125A4.125 4.125 0 1112 6.375a4.125 4.125 0 010 8.25z" />
                        </svg>
                        {{ $store->location }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $stores->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
