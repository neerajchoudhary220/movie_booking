@php($editing = isset($seat))
<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <x-input-label for="row_label" value="Row Label" />
            <x-text-input id="row_label" name="row_label" type="text"
                value="{{ old('row_label', $seat->row_label ?? '') }}" class="block w-full mt-1" required />
            <x-input-error :messages="$errors->get('row_label')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="col_number" value="Column Number" />
            <x-text-input id="col_number" name="col_number" type="number"
                value="{{ old('col_number', $seat->col_number ?? '') }}" class="block w-full mt-1" required />
            <x-input-error :messages="$errors->get('col_number')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="seat_number" value="Seat Number" />
            <x-text-input id="seat_number" name="seat_number" type="text"
                value="{{ old('seat_number', $seat->seat_number ?? '') }}" class="block w-full mt-1" required />
            <x-input-error :messages="$errors->get('seat_number')" class="mt-2" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <x-input-label for="type" value="Type" />
            <select id="type" name="type" class="block w-full mt-1 border-gray-300 rounded-md">
                @foreach(['regular', 'premium', 'vip'] as $type)
                <option value="{{ $type }}" {{ old('type', $seat->type ?? '') == $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="block w-full mt-1 border-gray-300 rounded-md">
                @foreach(['available', 'pending', 'booked', 'blocked'] as $status)
                <option value="{{ $status }}" {{ old('status', $seat->status ?? '') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="price_override" value="Price Override (₹)" />
            <x-text-input id="price_override" name="price_override" type="number" step="0.01"
                value="{{ old('price_override', $seat->price_override ?? '') }}" class="block w-full mt-1" />
        </div>
    </div>
</div>