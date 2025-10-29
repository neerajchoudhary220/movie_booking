@php($editing = isset($movie))
<div class="space-y-4">
    <div>
        <x-input-label for="title" :value="__('Title')" />
        <x-text-input id="title" name="title" value="{{ old('title', $movie->title ?? '') }}" class="block w-full mt-1" required />
        <x-input-error :messages="$errors->get('title')" class="mt-1" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="category" :value="__('Category')" />
            <x-text-input id="category" name="category" value="{{ old('category', $movie->category ?? '') }}" class="block w-full mt-1" />
        </div>
        <div>
            <x-input-label for="language" :value="__('Language')" />
            <x-text-input id="language" name="language" value="{{ old('language', $movie->language ?? '') }}" class="block w-full mt-1" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="duration" :value="__('Duration (minutes)')" />
            <x-text-input id="duration" name="duration" type="number" value="{{ old('duration', $movie->duration ?? '') }}" class="block w-full mt-1" />
        </div>
        <div>
            <x-input-label for="release_date" :value="__('Release Date')" />
            <x-text-input
                id="release_date"
                name="release_date"
                type="date"
                value="{{ old('release_date', isset($movie) && $movie->release_date ? $movie->release_date->format('Y-m-d') : '') }}"
                class="block w-full mt-1" />

        </div>
    </div>

    <div>
        <x-input-label for="poster_url" :value="__('Poster URL')" />
        <x-text-input id="poster_url" name="poster_url" value="{{ old('poster_url', $movie->poster_url ?? '') }}" class="block w-full mt-1" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="3" class="block w-full mt-1 border-gray-300 rounded-md">{{ old('description', $movie->description ?? '') }}</textarea>
    </div>

    <div>
        <x-input-label for="status" :value="__('Status')" />
        <select id="status" name="status" class="block w-full mt-1 border-gray-300 rounded-md">
            <option value="active" {{ old('status', $movie->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $movie->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
</div>