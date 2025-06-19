<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Switch Account Role') }}
        </h2>
    
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Switch between your current roles to access user or merchant features.') }}
        </p>
    </header>

    @if(is_null(Auth::user()->merchant_password))
        {{-- User does not have a merchant account --}}
        <x-primary-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'create-merchant-account')"
        >
            {{ __('Make Merchant Account') }}
        </x-primary-button>

        <x-modal name="create-merchant-account" focusable>
            <form method="POST" action="{{ route('profile.create-merchant') }}" class="p-6">
                @csrf

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Create Merchant Account') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Create a merchant password to secure your merchant account.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="merchant_password" value="{{ __('Merchant Password') }}" />
                    <x-text-input id="merchant_password" name="merchant_password" type="password" class="mt-1 block w-3/4" />
                    <x-input-error :messages="$errors->get('merchant_password')" class="mt-2" />
                </div>

                <div class="mt-6">
                    <x-input-label for="merchant_password_confirmation" value="{{ __('Confirm Merchant Password') }}" />
                    <x-text-input id="merchant_password_confirmation" name="merchant_password_confirmation" type="password" class="mt-1 block w-3/4" />
                    <x-input-error :messages="$errors->get('merchant_password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3">
                        {{ __('Create Merchant Account') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    @else
        {{-- User has a merchant account --}}
        @if(Auth::user()->refresh()->current_role === 'user')
        {{-- @if(Auth::user()->current_role === 'user') --}}
            {{-- Switch to Merchant --}}
            <x-primary-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-merchant-switch')"
            >
                {{ __('Switch to Merchant') }}
            </x-primary-button>

            <x-modal name="confirm-merchant-switch" focusable>
                <form method="POST" action="{{ route('profile.switch-role-merchant') }}" class="p-6">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Switch to Merchant') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Please confirm your merchant password to switch to the merchant dashboard.') }}
                    </p>

                    <div class="mt-6">
                        <x-input-label for="merchant_password" value="{{ __('Merchant Password') }}" />
                        <x-text-input id="merchant_password" name="merchant_password" type="password" class="mt-1 block w-3/4" />
                        <x-input-error :messages="$errors->get('merchant_password')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button class="ms-3">
                            {{ __('Confirm') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-modal>
        @else
            {{-- Switch to User --}}
            <x-primary-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-switch')"
            >
                {{ __('Switch to User') }}
            </x-primary-button>

            <x-modal name="confirm-user-switch" focusable>
                <form method="POST" action="{{ route('profile.switch-role-user') }}" class="p-6">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Switch to User') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Are you sure you want to switch back to the user dashboard?') }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button class="ms-3">
                            {{ __('Confirm') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-modal>
        @endif
    @endif

</section>
