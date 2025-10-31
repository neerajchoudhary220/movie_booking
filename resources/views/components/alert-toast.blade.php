@props([
'type' => 'success', // success | error
'message' => '',
'timeout' => 4000, // milliseconds
])

@php
$colors = [
'success' => 'bg-green-50 border-green-200 text-green-700',
'error' => 'bg-red-50 border-red-200 text-red-700',
];

$icon = $type === 'success' ? 'bi-check-circle-fill text-green-600' : 'bi-exclamation-triangle-fill text-red-600';
$barColor = $type === 'success' ? 'bg-green-500' : 'bg-red-500';
@endphp

<div class="toast-container fixed top-5 right-5 z-50 animate-fadeIn">
    <div class="toast-item relative mb-3 p-4 border rounded-lg shadow-sm {{ $colors[$type] }}"
        data-timeout="{{ $timeout }}">
        <div class="flex justify-between items-start">
            <div class="flex items-center gap-2">
                <i class="bi {{ $icon }}"></i>
                <p class="font-medium text-sm">{{ $message }}</p>
            </div>
            <button type="button" class="close-toast text-gray-400 hover:text-gray-600 text-lg leading-none">
                &times;
            </button>
        </div>
        <div class="toast-progress absolute bottom-0 left-0 h-1 {{ $barColor }}"></div>
    </div>
</div>