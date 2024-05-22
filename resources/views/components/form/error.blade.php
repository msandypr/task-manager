@props(['inputName'])
@error($inputName)
    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
@enderror
