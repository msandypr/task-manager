@props(['sectionName'])

<x-layout>
    <x-section-header :sectionName="$sectionName"/>

    <div class="mt-4 bg-white rounded-lg shadow-xl bg-opacity-30 backdrop-filter backdrop-blur-lg border border-gray-200">
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</x-layout>
