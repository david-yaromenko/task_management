<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class TaskController extends Controller
{

    public function __construct(protected TaskService $taskService) {}

    public function index(Request $request): JsonResponse
    {
        $user = auth('api')->user();
        $status = $request->query('status');

        $tasks = $this->taskService->getAllTasks($user, $status);

        return TaskResource::collection($tasks)->response()->setStatusCode(200);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $userId = auth('api')->id();
        $data = $this->taskService->create($request->validated(), $userId);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $data
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        $this->authorize('view', $task);
        $task = $this->taskService->getTask($task);

        return (new TaskResource($task))->response()->setStatusCode(200);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);
        $this->taskService->update($request->validated(), $task);

        return response()->json([
            'message' => "Task {$task->title} updated successfully",
        ], 200);
    }


    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);
        $this->taskService->delete($task);

        return response()->json([
            'message' => "Task {$task->title} deleted",
        ], 200);
    }
}
