@props(['tableName', 'paginatorAttr'])

<x-layout>
    <x-section-header :sectionName="$tableName" />

    <div class="w-full mt-4 bg-white rounded-lg shadow-xl">
        <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200">
            <h2 class="text-xl font-semibold">{{ $tableName }}</h2>
            <a href="{{ route('task.create') }}" class="flex items-center justify-center px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                New Task
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                {{ $slot }}
            </table>
        </div>

        <div class="px-4 py-3 bg-white-100 border-t border-gray-200">
            {{ $paginatorAttr->links() }}
        </div>
    </div>
</x-layout>
