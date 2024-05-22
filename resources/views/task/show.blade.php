<x-sub-section-panel sectionName="Task: {{ $task->title }}">
    {{-- show task section --}}
    <section class="flex justify-center">
        <div class="container">
            {{-- Action section --}}
            <div class="flex justify-end space-x-4">
                @auth
                    @if (!$task->completed)
                        <form method="post" action="/task/{{ $task->id }}/completed">
                            @csrf
                            @method('PATCH')
                            <button
                                class="bg-blue-500 text-white rounded-full p-2 hover:bg-blue-600 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                Task Completed
                            </button>
                        </form>
                    @endif
                    <a href="/task/{{ $task->id }}/edit"
                        class="bg-blue-500 text-white rounded-full p-2 hover:bg-blue-600 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="/task/{{ $task->id }}/notify"
                        class="bg-green-500 text-white rounded-full p-2 hover:bg-green-600 transition duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <form method="post" action="/task/{{ $task->id }}">
                        @csrf
                        @method('DELETE')
                        <button
                            class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                @endauth
            </div>
            <x-content-layout contentName="Date Created" contents="{{ date('d/m/Y', strtotime($task->created_at)) }}" />
            <x-content-layout contentName="Due Date" contents="{{ date('d/m/Y', strtotime($task->due)) }}" />
            <x-content-layout contentName="Created by" contents="{{ $task->getTaskCreatorUser() }}" />
            <x-content-layout contentName="Assigned to" contents="{{ $task->getAssignedUser() }}" />
            <x-content-layout contentName="Description" contents="{{ $task->description }}" />
            <x-content-layout contentName="Status" contents="{{ $task->status }}" /> <!-- Menampilkan status -->
        </div>
    </section>
    <hr class="my-5 border-500">
    {{-- Task comment section --}}
    <div class="flex justify-center space-x-8">
        <div class="w-1/3 bg-gray-100 border border-gray-200 rounded-lg p-4">
            <form action="/task/{{ $task->id }}/comment" method="post">
                @csrf
                <header>
                    <h2 class="text-lg font-semibold mb-4">Task Comments</h2>
                </header>
                <div class="mt-2">
                    <textarea name="body"
                        class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        rows="3" placeholder="Quick Updates...." required>{{ old('body') }}</textarea>
                    <x-form.error inputName="body" />
                </div>
                @auth
                    <div class="mt-4">
                        <x-form.button buttonName="Post"
                            class="w-full bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50" />
                    </div>
                @else
                    <p class="mt-4 text-sm">Please <a href="/login" class="underline">sign in</a> to post a comment on this
                        Task.</p>
                @endauth
            </form>
        </div>
        <div class="w-2/3 bg-white rounded-lg shadow-md p-4">
            @if ($task->comments->count())
                @foreach ($task->comments as $comment)
                    <div class="mb-4">
                        <div class="flex items-center mb-1">
                            <span class="text-sm text-gray-500">{{ $comment->created_at->format('d/m/Y') }}</span>
                            <span class="ml-2 font-semibold">{{ $comment->user->name }}:</span>
                        </div>
                        <p class="text-sm">{{ $comment->body }}</p>
                    </div>
                @endforeach
            @else
                <p class="text-sm font-semibold">No Comments on this task...</p>
            @endif
        </div>
    </div>

</x-sub-section-panel>
