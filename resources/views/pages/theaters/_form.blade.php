@php($editing = isset($theatre))

<div class="space-y-4">
    <!-- Name -->
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text"
            value="{{ old('name', $theatre->name ?? '') }}"
            class="mt-1 block w-full" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <!-- Location & City -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" name="location" type="text"
                value="{{ old('location', $theatre->location ?? '') }}"
                class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" name="city" type="text"
                value="{{ old('city', $theatre->city ?? '') }}"
                class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>
    </div>

    <!-- State & Pincode -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="state" :value="__('State')" />
            <x-text-input id="state" name="state" type="text"
                value="{{ old('state', $theatre->state ?? '') }}"
                class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('state')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="pincode" :value="__('Pincode')" />
            <x-text-input id="pincode" name="pincode" type="text"
                value="{{ old('pincode', $theatre->pincode ?? '') }}"
                class="mt-1 block w-full" maxlength="10" />
            <x-input-error :messages="$errors->get('pincode')" class="mt-2" />
        </div>
    </div>

    <!-- Manager & Status -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="manager_id" :value="__('Manager')" />
            <select id="manager_id" name="manager_id" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">-- Select Manager --</option>
                @foreach($managers as $manager)
                <option value="{{ $manager->id }}" {{ (old('manager_id', $theatre->manager_id ?? '') == $manager->id) ? 'selected' : '' }}>
                    {{ $manager->name }} ({{ $manager->email }})
                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('manager_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="active" {{ old('status', $theatre->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $theatre->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>
    </div>
</div>