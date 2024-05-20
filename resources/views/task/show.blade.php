<x-sub-section-panel sectionName="Task: {{ $task->title }}">
    {{-- show task section --}}
    <section>
        <div class="container">
            {{-- Action section --}}
            <div class="flex flex-row-reverse space-x-reverse">
                @auth <!-- Tampilkan tombol hanya jika pengguna login -->
                    <form method="post" action="/task/{{ $task->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 h-10 w-10 rounded"><i class="fas fa-trash-alt fa-inverse"></i></button>
                    </form>
                    @if (!$task->completed)
                        <button class="bg-green-500 h-10 w-10 rounded"><a href="/task/{{ $task->id }}/notify"><i class="fas fa-envelope fa-inverse"></i></a></button>
                        <button class="bg-blue-500 h-10 w-10"><a href="/task/{{ $task->id }}/edit"> <i class="fas fa-edit fa-inverse"></i></a></button>
                        <form method="post" action="/task/{{ $task->id }}/completed">
                            @csrf
                            @method('PATCH')
                            <button class="bg-blue-300 h-10 w-auto rounded">Mark Complete</button>
                        </form>
                    @else
                        <button class="bg-blue-500 h-10 w-10"><a href="/task/{{ $task->id }}/edit"> <i class="fas fa-edit fa-inverse"></i></a></button>
                        <button class="bg-green-500 h-10 w-10 rounded"><a href="/task/{{ $task->id }}/notify"><i class="fas fa-envelope fa-inverse"></i></a></button>
                    @endif
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
    <hr class="bg-gray-500 my-5">
    {{-- task comment section --}}
    <div class="row flex mt-2">
        <div class="bg-gray-500 border border-blue-100 w-1/3">
            <form action="/task/{{ $task->id }}/comment" method="post"
                class="bg-gray-100 border border-gray-200 p-2 rounded-xl">
                @csrf
                <header class="flex item-center">
                    <h2 class="ml-3">
                        Task Comments
                    </h2>
                </header>
                <div>
                    <textarea name="body" class="w-full mt-3 rounded-xl" cols="30" rows="3"
                        placeholder="Quick Updates...." required></textarea>
                    <x-form.error inputName="body" />
                </div>
                @auth
                    <x-form.button buttonName="post" />
                @else
                    <p class="text-bold "><a href="/login" class="underline">Sign in</a> to post a comment on this
                        Task</p>
                @endauth
            </form>
        </div>
        <div class="bg-gray-100 border border-gray-200 p-2 rounded-xl w-2/3">
            @if ($task->comments->count())
                @foreach ($task->comments as $comment)
                    <div class="row flex">
                        <span class="">{{ $comment->created_at }}, </span>
                        <span class="font-bold">{{ $comment->user->name }} : </span>
                        <p>{{ $comment->body }}</p>
                    </div>
                @endforeach
            @else
                <p class="text-bold justify self-center">No Comments on this task......</p>
            @endif
        </div>
    </div>
</x-sub-section-panel>
