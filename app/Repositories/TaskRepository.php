<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{

    public function create(array $data, int $userId): Task
    {
        return Task::create([
            'title' => $data["title"],
            'user_id' => $userId
        ]);
    }

    public function update(array $data, Task $task): Task
    {

        $task->update([
            'title' => $data['title'],
            'status' => $data['status']
        ]);

        return $task;
    }

    public function getAllTasks(User $user, ?string $status): LengthAwarePaginator
    {
        $query = Task::query();

        if ($user->role->name !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->with('user')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getTask(Task $task): Task
    {
        return Task::findOrFail($task->id);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}
