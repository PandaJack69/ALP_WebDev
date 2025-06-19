<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Store') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 bg-gradient-to-br from-amber-50 to-white text-gray-900">
                    <h3 class="text-2xl font-bold text-amber-700 mb-6">Edit Store: {{ $store->name }}</h3>

                    <!-- Add New Item Button -->
                    <div class="mb-6">
                        <button 
                            id="addItemButton" 
                            class="px-6 py-2 bg-green-500 text-white text-sm font-semibold rounded-full shadow-md hover:bg-green-600 transition-transform transform hover:scale-105"
                        >
                            + Add New Item
                        </button>
                    </div>

                    <!-- Store Edit Form -->
                    
                    <form method="POST" action="{{ route('merchant_store.update', $store->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Store Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-amber-700">Store Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $store->name) }}" 
                                class="w-full px-4 py-2 mt-1 border border-amber-200 rounded-lg shadow-sm focus:ring focus:ring-amber-300"
                                placeholder="Enter store name"
                            >
                        </div>

                        <!-- Store Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-amber-700">Store Description</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                class="w-full px-4 py-2 mt-1 border border-amber-200 rounded-lg shadow-sm focus:ring focus:ring-amber-300"
                                placeholder="Enter store description"
                            >{{ old('description', $store->description) }}</textarea>
                        </div>

                        <!-- Existing Items -->
                        {{-- <div>
                            <h4 class="text-lg font-semibold text-amber-700 mb-4">Store Items</h4>
                            <ul class="space-y-4">
                                @foreach ($store->items as $item)
                                    <li class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                        <div class="flex space-x-4">
                                            <input 
                                                type="text" 
                                                name="items[{{ $item->id }}][name]" 
                                                value="{{ $item->name }}" 
                                                class="flex-1 px-4 py-2 border border-amber-200 rounded-lg focus:ring focus:ring-amber-300"
                                                placeholder="Item Name"
                                            >
                                            <input 
                                                type="text" 
                                                name="items[{{ $item->id }}][price]" 
                                                value="{{ $item->price }}" 
                                                class="w-32 px-4 py-2 border border-amber-200 rounded-lg focus:ring focus:ring-amber-300"
                                                placeholder="Price"
                                            >
                                            <select 
                                                name="items[{{ $item->id }}][day_of_week]" 
                                                class="w-40 px-4 py-2 border border-amber-200 rounded-lg focus:ring focus:ring-amber-300"
                                            >
                                                @foreach($daysOfWeek as $day)
                                                    <option value="{{ $day }}" {{ $item->day_of_week === $day ? 'selected' : '' }}>{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <form method="POST" action="{{ route('merchant_store.delete_item', $item->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="px-4 py-2 bg-red-500 text-white text-sm rounded-lg shadow-md hover:bg-red-600 transition-transform transform hover:scale-105"
                                                    onclick="return confirm('Are you sure you want to delete this item?');"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div> --}}
                        <div>
                            <h4 class="text-lg font-semibold text-amber-700 mb-4">Store Items</h4>
                            <ul class="space-y-4">
                                @foreach ($store->items as $item)
                                    <li class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                        <div class="flex space-x-4">
                                            <input 
                                                type="text" 
                                                name="items[{{ $item->id }}][name]" 
                                                value="{{ $item->name }}" 
                                                class="flex-1 px-4 py-2 border border-amber-200 rounded-lg focus:ring focus:ring-amber-300"
                                                placeholder="Item Name"
                                            >
                                            <input 
                                                type="text" 
                                                name="items[{{ $item->id }}][price]" 
                                                value="{{ $item->price }}" 
                                                class="w-32 px-4 py-2 border border-amber-200 rounded-lg focus:ring focus:ring-amber-300"
                                                placeholder="Price"
                                            >
                                            <select 
                                                name="items[{{ $item->id }}][day_of_week]" 
                                                class="w-40 px-4 py-2 border border-amber-200 rounded-lg focus:ring focus:ring-amber-300"
                                            >
                                                @foreach($daysOfWeek as $day)
                                                    <option value="{{ $day }}" {{ $item->day_of_week === $day ? 'selected' : '' }}>{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <button 
                                                type="button" 
                                                onclick="deleteItem({{ $item->id }})" 
                                                class="px-4 py-2 bg-red-500 text-white text-sm rounded-lg shadow-md hover:bg-red-600 transition-transform transform hover:scale-105"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <script>
                            function deleteItem(itemId) {
                                if (confirm('Are you sure you want to delete this item?')) {
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = `{{ route('merchant_store.delete_item', '') }}/${itemId}`;
                                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        
                                    const csrfInput = document.createElement('input');
                                    csrfInput.type = 'hidden';
                                    csrfInput.name = '_token';
                                    csrfInput.value = csrfToken;
                        
                                    const methodInput = document.createElement('input');
                                    methodInput.type = 'hidden';
                                    methodInput.name = '_method';
                                    methodInput.value = 'DELETE';
                        
                                    form.appendChild(csrfInput);
                                    form.appendChild(methodInput);
                        
                                    document.body.appendChild(form);
                                    form.submit();
                                }
                            }
                        </script>

                        <!-- Submit Button for Updating Store -->
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-amber-500 text-white text-sm font-semibold rounded-full shadow-md hover:bg-amber-600 transition-transform transform hover:scale-105"
                        >
                            Update Store
                        </button>

                        <!-- Delete Store Button -->
                        <form method="POST" action="{{ route('merchant_store.delete', $store->id) }}">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-red-500 text-white text-sm font-semibold rounded-full shadow-md hover:bg-red-600 transition-transform transform hover:scale-105"
                                onclick="return confirm('Are you sure you want to delete this store? This action cannot be undone.');"
                            >
                                Delete Store
                            </button>
                        </form>
                        
                    </form>

                    <!-- New Item Form Template -->
                    <div id="newItemFormTemplate" class="hidden mt-6">
                        <form method="POST" action="{{ route('merchant_store.add_item', $store->id) }}" class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Item Name</label>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        class="w-full px-4 py-2 mt-1 border border-gray-200 rounded-lg focus:ring focus:ring-amber-300"
                                        placeholder="Enter item name"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Item Price</label>
                                    <input 
                                        type="text" 
                                        name="price" 
                                        class="w-full px-4 py-2 mt-1 border border-gray-200 rounded-lg focus:ring focus:ring-amber-300"
                                        placeholder="Enter item price"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700">Available Day</label>
                                    <select 
                                        name="day_of_week" 
                                        class="w-full px-4 py-2 mt-1 border border-gray-200 rounded-lg focus:ring focus:ring-amber-300"
                                    >
                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                            <option value="{{ $day }}">{{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button 
                                    type="submit" 
                                    class="px-6 py-2 bg-green-500 text-white text-sm font-semibold rounded-full shadow-md hover:bg-green-600 transition-transform transform hover:scale-105"
                                >
                                    Add Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Adding Item -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addItemButton = document.getElementById('addItemButton');
            const template = document.getElementById('newItemFormTemplate');
            addItemButton.addEventListener('click', () => {
                const clone = template.cloneNode(true);
                clone.classList.remove('hidden');
                template.parentNode.appendChild(clone);
            });
        });
    </script>
</x-app-layout>
