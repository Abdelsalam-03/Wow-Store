<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Address Information
        </h2>

    </header>
    @if ($address)
        <p class="mt-1 text-sm text-gray-600">
            Update your account's address information
        </p>
        <form class="mt-6 space-y-6 address-form" onsubmit="createUserAddress()">
            <div>
                <x-input-label for="district" :value='"District / City"' />
                <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" :value="$address->district" required autofocus/>
            </div>
            <div>
                <x-input-label for="street" :value='"Street"' />
                <x-text-input id="street" name="street" type="text" class="mt-1 block w-full" :value="$address->street" required autofocus/>
            </div>
            <div>
                <x-input-label for="building" :value='"Building"' />
                <x-text-input id="building" name="building" type="text" class="mt-1 block w-full" :value="$address->building" required autofocus/>
            </div>
            <div>
                <x-input-label for="phone" :value='"Phone"' />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="$address->phone" required autofocus/>
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>Update</x-primary-button>
            </div>
        </form>
    @else
        <p class="mt-1 text-sm text-gray-600">
            Set your account's address information
        </p>
        <form class="mt-6 space-y-6 address-form" onsubmit="createUserAddress()">
            <div>
                <x-input-label for="district" :value='"District / City"' />
                <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" required/>
            </div>
            <div>
                <x-input-label for="street" :value='"Street"' />
                <x-text-input id="street" name="street" type="text" class="mt-1 block w-full" required/>
            </div>
            <div>
                <x-input-label for="building" :value='"Building"' />
                <x-text-input id="building" name="building" type="text" class="mt-1 block w-full" required/>
            </div>
            <div>
                <x-input-label for="phone" :value='"Phone"' />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" required/>
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>Save</x-primary-button>
            </div>
        </form>
    @endif
    {{-- <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form> --}}
</section>
