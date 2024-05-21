@props(['sectionName'])
<x-layout>
    <x-section-header :sectionName="$sectionName"/>
    <div class="w-auto mt-4 bg-white rounded-lg shadow-xl p-4 backdrop-filter backdrop-blur-lg bg-opacity-30 border border-gray-200">
        <div class="overflow-hidden rounded-lg">
           {{$slot}}
        </div>
    </div>
</x-layout>
