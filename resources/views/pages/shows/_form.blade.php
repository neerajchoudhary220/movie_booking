@php($editing = isset($show))
<div class="space-y-4">

    <div>
        <x-input-label for="movie_id" value="Movie" />
        <select id="movie_id" name="movie_id" class="block w-full mt-1 border-gray-300 rounded-md">
            <option value="">-- Select Movie --</option>
            @foreach($movies as $movie)
            <option value="{{ $movie->id }}" {{ old('movie_id', $show->movie_id ?? '') == $movie->id ? 'selected' : '' }}>
                {{ $movie->title }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('movie_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="screen_id" value="Screen" />
        <select id="screen_id" name="screen_id" class="block w-full mt-1 border-gray-300 rounded-md">
            <option value="">-- Select Screen --</option>
            @foreach($screens as $screen)
            <option value="{{ $screen->id }}" {{ old('screen_id', $show->screen_id ?? '') == $screen->id ? 'selected' : '' }}>
                {{ $screen->name }} — {{ $screen->theatre->name }}
            </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('screen_id')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="starts_at" value="Start Time" />
            <x-text-input id="starts_at" name="starts_at" type="datetime-local"
                value="{{ old('starts_at', isset($show) && $show->starts_at ? $show->starts_at->format('Y-m-d\TH:i') : '') }}"
                class="block w-full mt-1" />
            <x-input-error :messages="$errors->get('starts_at')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="ends_at" value="End Time" />
            <x-text-input id="ends_at" name="ends_at" type="datetime-local"
                value="{{ old('ends_at', isset($show) && $show->ends_at ? $show->ends_at->format('Y-m-d\TH:i') : '') }}"
                class="block w-full mt-1" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <x-input-label for="base_price" value="Base Price" />
            <x-text-input id="base_price" name="base_price" type="number" step="0.01"
                value="{{ old('base_price', $show->base_price ?? 150.00) }}"
                class="block w-full mt-1" />
        </div>

        <div>
            <x-input-label for="lock_minutes" value="Lock Minutes" />
            <x-text-input id="lock_minutes" name="lock_minutes" type="number"
                value="{{ old('lock_minutes', $show->lock_minutes ?? 5) }}"
                class="block w-full mt-1" />
        </div>

        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status" class="block w-full mt-1 border-gray-300 rounded-md">
                @foreach(['scheduled', 'running', 'completed', 'cancelled'] as $status)
                <option value="{{ $status }}" {{ old('status', $show->status ?? '') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <x-input-label for="price_map" value="Price Map (JSON)" />
        <textarea id="price_map" name="price_map" rows="3" class="block w-full mt-1 border-gray-300 rounded-md"
            placeholder='{"regular":120,"premium":180,"vip":240}'>{{ old('price_map', isset($show) ? json_encode($show->price_map, JSON_PRETTY_PRINT) : '') }}</textarea>
        <x-input-error :messages="$errors->get('price_map')" class="mt-2" />
    </div>
    {{ logger()->info($errors) }}
</div>