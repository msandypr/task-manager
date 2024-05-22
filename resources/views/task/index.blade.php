<x-table.table-panel tableName="Tasks" :paginatorAttr="$tasks">
    <div class="container flex flex-col md:flex-row items-center mb-4">
        <form method="GET" action="/task" class="mb-3 md:mb-0 md:mr-3 flex items-center">
            <x-form.input inputName="search" type="date" value="{{ request('search') }}" class="mr-2 md:mr-0" />
            <x-form.button buttonName="search" class="md:w-auto" />
        </form>

        <form method="GET" action="/task" class="mb-3 md:mb-0 md:mr-3 flex items-center">
            <x-form.input inputName="searchbody" value="{{ request('searchbody') }}" class="mr-2 md:mr-0" />
            <x-form.button buttonName="search" class="md:w-auto" />
        </form>

        <form method="GET" action="/task" class="flex items-center">
            <select name="status" class="form-select mr-2 md:mr-0 mb-2 md:mb-0">
                <option value="">Filter Task Status</option>
                @foreach (App\Models\Task::getStatusOptions() as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            <x-form.button buttonName="Filter" class="md:w-auto" />
        </form>
    </div>

    <thead>
        <tr>
            <x-table.table-head thName="Date Created" />
            <x-table.table-head thName="Task Name" />
            <x-table.table-head thName="Created By" />
            <x-table.table-head thName="Assigned to" />
            <x-table.table-head thName="Due" />
            <x-table.table-head thName="Status" />
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr class="hover:bg-grey-lighter">
                <x-table.table-data tdName="{{ date_format($task->created_at, 'd/m/Y') }}" />
                <td class="py-4 px-6 border-b border-grey-light">
                    <a href="/task/{{ $task->id }}" class="underline"> {{ ucwords($task->title) }}</a>
                </td>
                <x-table.table-data tdName="{{ $task->getTaskCreatorUser() }}" />
                <x-table.table-data tdName="{{ $task->getAssignedUser() }}" />
                <x-table.table-data tdName="{{ date('d/m/Y', strtotime($task->due)) }}" />
                <x-table.table-data tdName="{{ $task->status }}" />
            </tr>
        @endforeach
    </tbody>
</x-table.table-panel>
