<x-layout>
    <x-section-header sectionName="Updating Task: {{$task->title}}" />
    <div class="flex justify-center">
        <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
            <span class="mb-3">
                <x-content-layout contentName="Created by" contents="{{ $task->getTaskCreatorUser() }}" />
                <x-content-layout contentName="Assigned to" contents="{{ $task->getAssignedUser() }}" />
            </span>
            <div class="leading-loose">
                <form class="p-10 bg-white rounded shadow-xl mt-2" method="post" action="{{ route('task.update', $task) }}">
                    @csrf
                    @method('PATCH')
                    <x-form.input inputName="title" value="{{$task->title}}"/>
                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="description">Task Details</label>
                        <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" id="description" name="description" rows="6" placeholder="Task Details...." required>{{$task->description}}</textarea>
                    </div>
                    <x-form.input inputName="due" type="date" value="{{$task->due}}"/>
                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="user">Assign new user</label>
                        <select name="assigneduser_id" id="assigneduser_id" class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if($user->id == $task->assigneduser_id) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="status">Status</label>
                        <select name="status" id="status" class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded">
                            <option value="ongoing" @if($task->status === 'ongoing') selected @endif>Ongoing</option>
                            <option value="fixing" @if($task->status === 'fixing') selected @endif>Fixing</option>
                            <option value="delay" @if($task->status === 'delay') selected @endif>Delay</option>
                        </select>
                    </div>
                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('task.index') }}" class="px-4 py-1 text-white font-light tracking-wider bg-blue-300 rounded">Cancel</a>
                        <button class="px-4 py-1 text-white font-light tracking-wider bg-blue-600 rounded" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
