<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-600 font-outfit">
            {{ __('Danger Zone') }}
        </h2>

        <p class="mt-1 text-sm text-red-700/60 font-medium">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-50 text-red-600 border border-red-100 hover:bg-red-600 hover:text-white px-8 py-3 rounded-xl transition shadow-sm"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-bold text-emerald-950 font-outfit">
                {{ __('Final Confirmation') }}
            </h2>

            <p class="mt-2 text-sm text-emerald-700/60 font-medium leading-relaxed">
                {{ __('To ensure security, please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-8">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl"
                    placeholder="{{ __('Confirm with Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close')" class="px-6 py-3 border-emerald-100 text-emerald-700 rounded-xl">
                    {{ __('Go Back') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl shadow-lg transition">
                    {{ __('Delete Permanently') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
