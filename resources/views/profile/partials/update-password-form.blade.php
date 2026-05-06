<section>
    <header>
        <h2 class="text-xl font-bold text-emerald-950 font-outfit">
            {{ __('Security Credentials') }}
        </h2>

        <p class="mt-1 text-sm text-emerald-700/60 font-medium">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-emerald-900 font-bold" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-emerald-900 font-bold" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-emerald-900 font-bold" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-emerald-900 hover:bg-emerald-950 px-8 py-3 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-bold"
                >{{ __('Password Updated.') }}</p>
            @endif
        </div>
    </form>
</section>
