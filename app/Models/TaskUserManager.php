<?php

namespace App\Models;

use App\Models\User;
use App\Models\Task;

trait TaskUserManager
{
    public function getAssignedUser()
    {
        $assignedUser = User::find($this->assigneduser_id);
        return $assignedUser ? ucwords($assignedUser->name) : null;
    }

    public function getTaskCreatorUser()
    {
        $taskcreator = User::find($this->taskcreator_id);
        return $taskcreator ? ucwords($taskcreator->name) : null;
    }

    public function getTasksCreated()
    {
        return Task::where('taskcreator_id', $this->id)->get();
    }

    public function noOfTaskCreated()
    {
        return $this->getTasksCreated()->count();
    }

    public function getTasksAssigned()
    {
        return Task::where('assigneduser_id', $this->id)->get();
    }

    public function noOfTaskAssigned()
    {
        return $this->getTasksAssigned()->count();
    }

    public function totalTasks()
    {
        return $this->noOfTaskCreated() + $this->noOfTaskAssigned();
    }

    public function getAllUserTasks()
    {
        return $this->getTasksCreated()->merge($this->getTasksAssigned());
    }

    public function noOfTaskDue()
    {
        return Task::where(function ($query) {
            $query->where('taskcreator_id', $this->id)
                ->orWhere('assigneduser_id', $this->id);
        })->count();
    }

    public function noOfTaskCompleted()
    {
        return Task::where(function ($query) {
            $query->where('taskcreator_id', $this->id)
                ->orWhere('assigneduser_id', $this->id);
        })->where('status', 'completed')->count();
    }
}
