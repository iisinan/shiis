<section>
    <header>
        <h2 class="text-xl font-bold text-emerald-950 font-outfit">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-emerald-700/60 font-medium">
            {{ __("Complete your profile to help your classmates find and connect with you.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" class="text-emerald-900 font-bold" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Nickname -->
            <div>
                <x-input-label for="nickname" :value="__('Nickname (Known as)')" class="text-emerald-900 font-bold" />
                <x-text-input id="nickname" name="nickname" type="text" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" :value="old('nickname', $user->nickname)" placeholder="e.g. Sharp-One" />
                <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" class="text-emerald-900 font-bold" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-emerald-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-emerald-600 hover:text-emerald-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-emerald-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone_number" :value="__('WhatsApp / Phone Number')" class="text-emerald-900 font-bold" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" :value="old('phone_number', $user->phone_number)" placeholder="+234..." />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>

            <!-- Occupation -->
            <div>
                <x-input-label for="occupation" :value="__('Current Occupation')" class="text-emerald-900 font-bold" />
                <x-text-input id="occupation" name="occupation" type="text" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" :value="old('occupation', $user->occupation)" placeholder="e.g. Software Engineer" />
                <x-input-error class="mt-2" :messages="$errors->get('occupation')" />
            </div>

            <!-- State/Country -->
            <div>
                <x-input-label for="state_country" :value="__('Current Location')" class="text-emerald-900 font-bold" />
                <x-text-input id="state_country" name="state_country" type="text" class="mt-1 block w-full border-emerald-100 focus:ring-emerald-500 rounded-xl shadow-sm" :value="old('state_country', $user->state_country)" placeholder="e.g. Kaduna, Nigeria" />
                <x-input-error class="mt-2" :messages="$errors->get('state_country')" />
            </div>
        </div>

        <!-- Biography -->
        <div>
            <x-input-label for="biography" :value="__('Short Bio / About Me')" class="text-emerald-900 font-bold" />
            <textarea id="biography" name="biography" rows="4" class="mt-1 block w-full border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl text-emerald-900 shadow-sm" placeholder="Tell your classmates what you've been up to since 2005...">{{ old('biography', $user->biography) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('biography')" />
        </div>

        <!-- Profile Photo -->
        <div x-data="{ photoName: null, photoPreview: null }">
            <x-input-label for="profile_photo" :value="__('Profile Picture')" class="text-emerald-900 font-bold" />
            
            <div class="mt-2 flex items-center gap-6">
                <!-- Current / Preview Photo -->
                <div class="relative w-24 h-24">
                    <template x-if="!photoPreview">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover rounded-2xl border-2 border-emerald-100">
                        @else
                            <div class="w-full h-full bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-900 text-2xl font-bold border-2 border-dashed border-emerald-100">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </template>
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="w-full h-full object-cover rounded-2xl border-2 border-emerald-500">
                    </template>
                </div>

                <!-- Upload Trigger -->
                <div class="flex-1">
                    <input type="file" id="profile_photo" name="profile_photo" class="hidden" 
                           accept="image/*"
                           x-ref="photo"
                           @change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                           ">
                    <button type="button" @click="$refs.photo.click()" class="px-6 py-2 bg-emerald-50 text-emerald-900 font-bold text-xs rounded-xl border border-emerald-100 hover:bg-emerald-100 transition">
                        Select New Photo
                    </button>
                    <p class="mt-1 text-[10px] text-emerald-600/50 font-bold uppercase tracking-widest">JPG, PNG or WEBP. Max 2MB.</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-emerald-50">
            <x-primary-button class="bg-emerald-900 hover:bg-emerald-950 px-10 py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-1">
                {{ __('Update Profile') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-black uppercase tracking-widest"
                >{{ __('Changes Saved!') }}</p>
            @endif
        </div>
    </form>
</section>
