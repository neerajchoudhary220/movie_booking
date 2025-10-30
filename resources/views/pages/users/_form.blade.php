<form method="POST"
    action="{{ isset($user->id) ? route('admin.users.update', $user) : route('admin.users.store') }}">
    @csrf
    @if(isset($user->id))
    @method('PUT')
    @endif

    {{-- Name --}}
    <div class="mb-4">
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input
            id="name"
            type="text"
            name="name"
            class="block w-full mt-1"
            :value="old('name', $user->name ?? '')"
            required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    {{-- Email --}}
    <div class="mb-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input
            id="email"
            type="email"
            name="email"
            class="block w-full mt-1"
            :value="old('email', $user->email ?? '')"
            required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    {{-- Password --}}
    <div class="mb-4">
        <x-input-label
            for="password"
            :value="isset($user->id) ? __('New Password') : __('Password')" />

        <input
            id="password"
            name="password"
            type="password"
            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="{{ isset($user->id) ? 'Leave blank to keep current password' : 'Enter password' }}"
            {{ isset($user->id) ? '' : 'required' }} />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    {{-- Confirm Password --}}
    <div class="mb-6">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="{{ isset($user->id) ? 'Leave blank if not changing password' : 'Re-enter password' }}"
            {{ isset($user->id) ? '' : 'required' }} />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    {{-- Submit --}}
    <div class="flex justify-end">
        <x-primary-button>
            {{ isset($user->id) ? __('Update Manager') : __('Create Manager') }}
        </x-primary-button>
    </div>
</form>