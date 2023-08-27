<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestRequest;
use App\Http\Requests\RequestStatusRequest;
use App\Repositories\RequestRepositoryContract;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct(
        protected RequestRepositoryContract $repository,
        protected RequestService $service,
    ) {
    }

    /**
     * Display a listing of requests
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->repository->getByFilters($request->all()),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the request
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->repository->find($id),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created request
     *
     * @return JsonResponse
     */
    public function store(RequestRequest $request)
    {

        try {
            $this->service->store($request->validated());

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

    }

    /**
     * Update the request.
     *
     * @return JsonResponse
     */
    public function update(RequestRequest $request, int $id)
    {
        try {
            $this->service->update($id, $request->validated());

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Change status
     *
     * @return JsonResponse
     */
    public function changeStatus(RequestStatusRequest $request, int $id)
    {
        try {
            $this->service->changeStatus($id, $request->get('status'), $request->get('comment'));

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->service->destroy($id);

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
