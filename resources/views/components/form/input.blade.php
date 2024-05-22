@props(['inputName', 'type' => 'text'])

<div class="mt-2 flex flex-col">
    <label class="block text-sm text-gray-600" for="{{ $inputName }}">{{ ucwords($inputName) }}</label>
    <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" type="{{ $type }}" name="{{ $inputName }}" id="{{ $inputName }}" {{ $attributes }}>

    <x-form.error inputName="{{ $inputName }}" />
</div>
