<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile picture.") }}
        </p>
    </header>

    <!-- Display Current Profile Picture -->
    <div class="mb-4">
        @if(Auth::user()->profile_picture)
            <img src="{{ asset('images/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="w-32 h-32 rounded-full border border-gray-300">
        @else
            <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Picture" class="w-32 h-32 rounded-full border border-gray-300">
        @endif
    </div>

    <!-- Form to Upload New Profile Picture -->
    <form action="{{ route('profile.updatePicture') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- File Input for Profile Picture -->
        <div class="mb-4">
            <label for="profile_picture" class="block text-sm font-medium text-gray-700">{{ __('Choose a New Profile Picture') }}</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:font-semibold file:bg-gray-50 hover:file:bg-gray-100" required>
            @error('profile_picture')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">
                {{ __('Update Profile Picture') }}
            </button>
        </div>
    </form>
</section>