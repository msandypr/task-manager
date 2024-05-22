@props(['contentName', 'contents'])

<div class="flex items-center py-3 border-b border-gray-200">
    <div class="w-1/3 text-right pr-4">
        <p class="text-sm font-medium text-gray-600">{{ $contentName }}</p>
    </div>
    <div class="w-2/3 border border-gray-300 rounded-md shadow-md">
        <p class="text-sm text-gray-900 p-2">{{ $contents }}</p>
    </div>
</div>
