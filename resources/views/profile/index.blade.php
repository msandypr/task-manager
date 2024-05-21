<x-layout>
    <x-section-header sectionName="Profile" />
    <div class="container mx-auto my-8">
        <div class="bg-white bg-opacity-60 backdrop-filter backdrop-blur-lg border border-gray-200 rounded-lg shadow-xl p-6">
            <h2 class="text-xl font-bold text-gray-800">Profile Information</h2>
            <p class="mt-4 text-gray-600"><strong>Name:</strong> {{ $user->name }}</p>
            <p class="mt-2 text-gray-600"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mt-2 text-gray-600"><strong>Password:</strong> **********</p>
            <a href="{{ route('user.edit-profile') }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded">Edit Profile</a>
        </div>
    </div>
</x-layout>
