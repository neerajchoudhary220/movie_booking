<!-- resources/views/components/action/search-bar.blade.php -->
<form
    method="GET"
    action="{{ $route ?? request()->url() }}"
    class="mb-6 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
    <!-- Search Input -->
    <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        placeholder="{{ $placeholder }}"
        class="border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-72 focus:ring-indigo-500 focus:border-indigo-500 transition" />

    <!-- Search Button -->
    <button
        type="submit"
        class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-700 font-medium transition flex items-center gap-1">
        <i class="bi bi-search"></i> Search
    </button>

    <!-- Clear Button -->
    @if($showClear && request('q'))
    <a
        href="{{ $route ?? request()->url() }}"
        class="px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 text-gray-700 font-medium transition flex items-center gap-1">
        <i class="bi bi-x-circle"></i> Clear
    </a>
    @endif
</form>