<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Merchant Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your merchant account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('merchant-password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="current_merchant_password" :value="__('Current Merchant Password')" />
            <x-text-input id="current_merchant_password" name="current_merchant_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updateMerchantPassword->get('current_merchant_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="new_merchant_password" :value="__('New Merchant Password')" />
            <x-text-input id="new_merchant_password" name="new_merchant_password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updateMerchantPassword->get('new_merchant_password')" class="mt-2" />
        </div>

        <!-- Confirm New Password -->
        <div>
            <x-input-label for="new_merchant_password_confirmation" :value="__('Confirm New Merchant Password')" />
            <x-text-input id="new_merchant_password_confirmation" name="new_merchant_password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updateMerchantPassword->get('new_merchant_password_confirmation')" class="mt-2" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'merchant-password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>