<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request\StatusRequest;
use App\Http\Requests\Request\StoreRequest;
use App\Http\Requests\Request\UpdateRequest;
use App\Repositories\RequestRepositoryContract;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *    title="My Cool API",
 *    description="An API of cool stuffs",
 *    version="1.0.0",
 * )
 */
class RequestController extends Controller
{
    /**
     * @param  RequestRepositoryContract<\App\Models\Request>  $repository
     */
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
     * @OA\Post  (
     *      path="/api/v1/requests",
     *
     *      @OA\RequestBody(
     *
     *          @OA\MediaType(
     *              mediaType="application/json",
     *
     *              @OA\Schema(
     *
     *                  @OA\Property(
     *                       type="object",
     *                       @OA\Property(
     *                           property="name",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="email",
     *                           type="string"
     *                       ),
     *                       @OA\Property(
     *                           property="message",
     *                           type="string"
     *                       )
     *                  ),
     *                  example={
     *                      "name":"John",
     *                      "email":"john@test.com",
     *                      "message":"Help me!"
     *                 }
     *              )
     *          )
     *       ),
     *
     *       @OA\Response(
     *           response=200,
     *           description="Success",
     *
     *           @OA\JsonContent(
     *
     *               @OA\Property(property="status", type="string", example="success|validation"),
     *               @OA\Property(property="errors", type="object", example={  }),
     *           )
     *       ),
     *  )
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request)
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
    public function update(UpdateRequest $request, int $id)
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
    public function changeStatus(StatusRequest $request, int $id)
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
