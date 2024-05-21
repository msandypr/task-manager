<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskCompleted;
use Illuminate\Support\Facades\Notification;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'searchbody', 'status']);

        return view('task.index', [
            'tasks' => Task::latest()->filter($filters)->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create', [
            'users' => User::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->validateTask($request);
        $attributes['taskcreator_id'] = auth()->id();
        $attributes['status'] = 'ongoing'; // Default status
        $attributes['slug'] = Str::slug($request->title);
        $task = Task::create($attributes);

        $this->notifyUser($task->assigneduser_id);

        return redirect('/task')->with('success', 'Task created and assigned user notified by email');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('task.show', [
            'task' => Task::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $users = User::all();
        return view('task.edit', [
            'task' => $task,
            'users' => $users
        ]);
    }

    public function completed($id)
    {
        $task = Task::findOrFail($id);

        // Set status to completed
        $task->status = 'completed';
        $task->save();

        // Notify users
        $users = User::whereIn('id', [$task->assigneduser_id, $task->taskcreator_id])->get();
        Notification::send($users, new TaskCompleted($task)); // Menggunakan notifikasi TaskCompleted

        return redirect('/task')->with('success', 'Task marked as completed');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due' => 'required|date',
            'assigneduser_id' => 'required|integer|exists:users,id',
            'status' => 'required|string|in:ongoing,fixing,delay'
        ]);

        $task->update($validatedData);

        return redirect()->route('task.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return redirect('/task')->with('success', 'Task Deleted');
    }

    public function validateTask(Request $request)
    {
        return $request->validate([
            'title' => 'required',
            'due' => 'required',
            'description' => 'required',
            'assigneduser_id' => ['required', Rule::exists('users', 'id')],
            'status' => ['required', Rule::in(['ongoing', 'fixing', 'delay'])], // Validate status
        ]);
    }

    public function notifyUser($assignedUserId)
    {
        $task = Task::where('assigneduser_id', $assignedUserId)->first();
        $user = User::find($assignedUserId);
        Notification::send($user, new TaskAssigned($task));

        return back()->with('success', 'Task notification email has been sent to the assigned user');
    }

}
