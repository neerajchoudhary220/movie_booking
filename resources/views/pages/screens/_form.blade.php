@php($editing = isset($screen))
<div class="space-y-4">
    <div>
        <x-input-label for="theatre_id" value="Theatre" />
        <select id="theatre_id" name="theatre_id" class="block w-full mt-1 border-gray-300 rounded-md">
            <option value="">-- Select Theatre --</option>
            @foreach($theatres as $theatre)
            <option value="{{ $theatre->id }}" {{ old('theatre_id', $screen->theatre_id ?? '') == $theatre->id ? 'selected' : '' }}>
                {{ $theatre->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
        <x-input-label for="name" value="Screen Name" />
        <x-text-input id="name" name="name" type="text" class="block w-full mt-1"
            value="{{ old('name', $screen->name ?? '') }}" required />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <x-input-label for="capacity" value="Capacity" />
            <x-text-input id="capacity" name="capacity" type="number" class="block w-full mt-1"
                value="{{ old('capacity', $screen->capacity ?? '') }}" required />
        </div>

        <div>
            <x-input-label for="rows" value="Rows" />
            <x-text-input id="rows" name="rows" type="number" class="block w-full mt-1"
                value="{{ old('rows', $screen->rows ?? '') }}" required />
        </div>

        <div>
            <x-input-label for="cols" value="Columns" />
            <x-text-input id="cols" name="cols" type="number" class="block w-full mt-1"
                value="{{ old('cols', $screen->cols ?? '') }}" required />
        </div>
    </div>

    <div>
        <x-input-label for="status" value="Status" />
        <select id="status" name="status" class="block w-full mt-1 border-gray-300 rounded-md">
            @foreach(['active', 'inactive'] as $status)
            <option value="{{ $status }}" {{ old('status', $screen->status ?? '') == $status ? 'selected' : '' }}>
                {{ ucfirst($status) }}
            </option>
            @endforeach
        </select>
    </div>
</div>