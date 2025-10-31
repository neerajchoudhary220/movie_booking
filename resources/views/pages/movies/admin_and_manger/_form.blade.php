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

            <select id="category" name="category"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Category</option>
                @foreach ([
                'Action',
                'Adventure',
                'Animation',
                'Biography',
                'Comedy',
                'Documentary',
                'Drama',
                'Fantasy',
                'Historical',
                'Horror',
                'Mystery',
                'Romance',
                'Sci-Fi',
                'Thriller',
                ] as $category)
                <option value="{{ $category }}"
                    {{ old('category', $movie->category ?? '') === $category ? 'selected' : '' }}>
                    {{ $category }}
                </option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="language" :value="__('Language')" />

            <select id="language" name="language"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Select Language --</option>
                @foreach ($languages as $lang)
                <option value="{{ $lang }}" {{ old('language', $movie->language ?? '') === $lang ? 'selected' : '' }}>
                    {{ $lang }}
                </option>
                @endforeach
            </select>

            <x-input-error :messages="$errors->get('language')" class="mt-2" />
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
        <x-input-label for="poster" :value="__('Movie Poster')" />

        <input
            id="poster"
            type="file"
            name="poster"
            accept="image/*"
            class="block w-full mt-1 text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />

        @if (!empty($movie->poster_url))
        <div class="mt-3">
            <p class="text-sm text-gray-600 mb-1">Current Poster:</p>
            <img src="{{ asset('storage/' . $movie->poster_url) }}"
                alt="Current Poster"
                class="w-32 h-48 object-cover rounded-md border border-gray-200 shadow-sm">
        </div>
        @endif

        <x-input-error :messages="$errors->get('poster')" class="mt-2" />
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