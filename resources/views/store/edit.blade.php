<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Store') }}
        </h2>
    </x-slot> 

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('stores.update', $store->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium">Store Name</label>
                        <input type="text" id="name" name="name" value="{{ $store->name }}" required 
                               class="w-full px-4 py-2 border rounded">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium">Description</label>
                        <textarea id="description" name="description" rows="4" 
                                  class="w-full px-4 py-2 border rounded">{{ $store->description }}</textarea>
                    </div>

                    {{-- <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">
                        Update Store
                    </button> --}}
                    <x-primary-button>Update Store</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


