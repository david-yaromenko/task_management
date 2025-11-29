<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{

    public function __construct(protected TaskRepository $taskRepository) {}

    public function getAllTasks(User $user, ?string $status): LengthAwarePaginator
    {

        return $this->taskRepository->getAllTasks($user, $status);
    }

    public function create(array $data, int $userId): Task
    {

        return $this->taskRepository->create($data, $userId);
    }

    public function getTask(Task $task): Task
    {

        return $this->taskRepository->getTask($task);
    }

    public function update(array $data, Task $task): Task
    {

        return $this->taskRepository->update($data, $task);
    }

    public function delete(Task $task): bool
    {

        return $this->taskRepository->delete($task);
    }
}
