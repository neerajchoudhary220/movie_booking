<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 border border-gray-100">

            <!-- Heading -->
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-2">
                Forgot your password?
            </h2>
            <p class="text-sm text-gray-600 text-center mb-6">
                No problem — just enter your email address and we’ll send you a password reset link.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="mt-6 flex justify-center">
                    <x-primary-button class="w-full justify-center py-2 text-base">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>