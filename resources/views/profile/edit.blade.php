<x-layout>
    <x-section-header sectionName="Edit Profile" />
    <div class="container mx-auto my-8">
        <div class="bg-white bg-opacity-60 backdrop-filter backdrop-blur-lg border border-gray-200 rounded-lg shadow-xl p-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Profile Information</h2>
            @if (session('success'))
                <div class="bg-green-500 text-white p-2 rounded my-4">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('user.update-profile') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm text-gray-600" for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" required>
                    @error('name')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" required>
                    @error('email')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save Changes</button>
            </form>
        </div>
    </div>
</x-layout>
