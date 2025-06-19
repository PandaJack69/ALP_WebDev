<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Store') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('stores.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Store Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium">Store Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required 
                            class="w-full px-4 py-2 border rounded"
                        >
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium">Description</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4" 
                            class="w-full px-4 py-2 border rounded"
                        ></textarea>
                    </div>

                    <!-- Store Image -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium">Store Image</label>
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            accept="image/*" 
                            class="w-full px-4 py-2 border rounded"
                        >
                    </div>

                    <!-- Category Dropdown -->
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium">Store Category</label>
                        <select 
                            id="category" 
                            name="category_id" 
                            required 
                            class="w-full px-4 py-2 border rounded"
                        >
                            <option value="" disabled selected>Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Items Section -->
                    <div id="items">
                        <h3 class="text-lg font-semibold">Items</h3>
            
                        <div class="item-group mb-4">
                            <label for="items[0][name]" class="block text-sm font-medium">Item Name</label>
                            <input 
                                type="text" 
                                name="items[0][name]" 
                                required 
                                class="w-full px-4 py-2 border rounded"
                            >

                            <label for="items[0][description]" class="block text-sm font-medium mt-2">Description</label>
                            <input 
                                type="text" 
                                name="items[0][description]" 
                                class="w-full px-4 py-2 border rounded"
                            >

                            <label for="items[0][day_of_week]" class="block text-sm font-medium mt-2">Day of Week</label>
                            <select 
                                name="items[0][day_of_week]" 
                                required 
                                class="w-full px-4 py-2 border rounded"
                            >
                                <option value="" disabled selected>Select Day of Week</option>
                                @foreach($daysOfWeek as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
            
                            <label for="items[0][price]" class="block text-sm font-medium mt-2">Price</label>
                            <input 
                                type="number" 
                                name="items[0][price]" 
                                required 
                                class="w-full px-4 py-2 border rounded"
                            >
                        </div>
                    </div>

                    <!-- Add Item Button -->
                    <button type="button" onclick="addItem()" class="px-4 py-2 bg-gray-200 rounded">
                        Add Item
                    </button>

                    <!-- Submit Button -->
                    <x-primary-button class="mt-6">Create Store</x-primary-button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let itemCount = 1;

        function addItem() {
            const itemsSection = document.getElementById('items');
            const newItemGroup = document.createElement('div');
            newItemGroup.classList.add('item-group', 'mb-4');
            newItemGroup.innerHTML = `
                <label for="items[${itemCount}][name]" class="block text-sm font-medium">Item Name</label>
                <input type="text" name="items[${itemCount}][name]" required class="w-full px-4 py-2 border rounded">

                <label for="items[${itemCount}][description]" class="block text-sm font-medium mt-2">Description</label>
                <input type="text" name="items[${itemCount}][description]" class="w-full px-4 py-2 border rounded">

                <label for="items[${itemCount}][day_of_week]" class="block text-sm font-medium mt-2">Day of Week</label>
                <select name="items[${itemCount}][day_of_week]" required class="w-full px-4 py-2 border rounded">
                    <option value="" disabled selected>Select Day of Week</option>
                    @foreach($daysOfWeek as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>

                <label for="items[${itemCount}][price]" class="block text-sm font-medium mt-2">Price</label>
                <input type="number" name="items[${itemCount}][price]" required class="w-full px-4 py-2 border rounded">
            `;
            itemsSection.appendChild(newItemGroup);
            itemCount++;
        }
    </script>
</x-app-layout>
