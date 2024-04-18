<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;


use App\Enum\DeleteStatus;
use App\Utilities\DeleteMessage;
use Illuminate\Http\Request;
use App\Http\Requests\TeacherRequest;
use App\Services\TeacherService;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends BaseController
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/teachers",
     *     tags={"Teachers"},
     *     summary="Get Teachers list as array",
     *     description="",
     *     @OA\Parameter(name="deleted", description="Delete type, Not Deleted=0, Soft=1, Hard=9", example="0", required=false, in="query", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Teachers list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $courses = $this->teacherService->getPaginatedData(
                null,
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $status = Response::HTTP_OK;
            $total = $courses['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('teachers', $total) . ' found.';
            return $this->responseJson($courses, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/teachers/all",
     *     tags={"Teachers"},
     *     summary="Get teachers list as array",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get teachers list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function all(): JsonResponse
    {
        try {
            $courses = $this->teacherService->all(
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $status = Response::HTTP_OK;
            $total = count($courses) ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('teachers', $total) . ' found.';
            return $this->responseJson($courses, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/teachers/{id}",
     *     tags={"Teachers"},
     *     summary="Get a Teacher",
     *     description="Get a Teacher",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get a Teacher"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $employee = $this->teacherService->getById($id);
            return $this->responseJson(
                $employee,
                Response::HTTP_OK,
                __('Teacher found')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/backend/teachers",
     *     tags={"Teachers"},
     *     summary="Insert new Teachers",
     *     description="Implement an API endpoint for administrators to effortlessly add new Teachers entries.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"t_id", "reg", "department_id", "faculty_id", "website", "email", "password", "name", "phone", "blood", "address", "image_url", "cv_link", "bio", "linkedin", "facebook"},
     *                 @OA\Property(property="t_id", type="integer", example="1802043", description="Teacher ID"),
     *                 @OA\Property(property="reg", type="string", example="08453", description="Teacher reg no"),
     *                 @OA\Property(property="department_id", type="integer", example=1, description="Department id"),
     *                 @OA\Property(property="faculty_id", type="integer", example=1, description="Faculty ID"),
     *                 @OA\Property(property="website", type="integer", example="https://www.facebook.com/Engg.Shishir/", description="Website"),
     *                 @OA\Property(property="email", type="string", example="shishir.cse.pstu@gmail.com", description="Teacher email address"),
     *                 @OA\Property(property="password", type="string", example="password", description="Account password"),
     *                 @OA\Property(property="name", type="string", example="Engg.Shishir", description="Name of the Teacher"),
     *                 @OA\Property(property="phone", type="string", example="1234567890", description="Phone number"),
     *                 @OA\Property(property="blood", type="string", example="B+", description="Blood group"),
     *                 @OA\Property(property="address", type="string", example="123 Main St, City, State, ZIP", description="Address of the Teacher"),
     *                 @OA\Property(property="image_url", type="string", example="https://pstuian.com/uploads/Teacher/1802043.jpeg", description="Image URL of the Teacher"),
     *                 @OA\Property(property="cv_link", type="string", example="https://cv.pstuian.com/cv_1802043.pdf", description="Teacher CV URL"),
     *                 @OA\Property(property="bio", type="string", example="Teacher details", description="Teacher details"),
     *                 @OA\Property(property="linkedin", type="string", example="https://www.linkedin.com/in/engg-shishir/", description="LinkedIn account URL"),
     *                 @OA\Property(property="facebook", type="string", example="https://www.facebook.com/Engg.Shishir/", description="Facebook account URL")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Teacher created successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function store(TeacherRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->teacherService->create($request->all()),
                Response::HTTP_CREATED,
                __('Teacher created successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/teachers/{id}",
     *     tags={"Teachers"},
     *     summary="Update teacher",
     *     description="Teacher update api",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"t_id", "reg", "department_id", "faculty_id", "website", "email", "password", "name", "phone", "blood", "address", "image_url", "cv_link", "bio", "linkedin", "facebook"},
     *                 @OA\Property(property="t_id", type="integer", example="1802043", description="Teacher ID"),
     *                 @OA\Property(property="reg", type="string", example="08453", description="Teacher reg no"),
     *                 @OA\Property(property="department_id", type="integer", example=1, description="Department id"),
     *                 @OA\Property(property="faculty_id", type="integer", example=1, description="Faculty ID"),
     *                 @OA\Property(property="website", type="integer", example="https://www.facebook.com/Engg.Shishir/", description="Website"),
     *                 @OA\Property(property="email", type="string", example="shishir.cse.pstu@gmail.com", description="Teacher email address"),
     *                 @OA\Property(property="password", type="string", example="password", description="Account password"),
     *                 @OA\Property(property="name", type="string", example="Engg.Shishir", description="Name of the Teacher"),
     *                 @OA\Property(property="phone", type="string", example="1234567890", description="Phone number"),
     *                 @OA\Property(property="blood", type="string", example="B+", description="Blood group"),
     *                 @OA\Property(property="address", type="string", example="123 Main St, City, State, ZIP", description="Address of the Teacher"),
     *                 @OA\Property(property="image_url", type="string", example="https://pstuian.com/uploads/Teacher/1802043.jpeg", description="Image URL of the Teacher"),
     *                 @OA\Property(property="cv_link", type="string", example="https://cv.pstuian.com/cv_1802043.pdf", description="Teacher CV URL"),
     *                 @OA\Property(property="bio", type="string", example="Teacher details", description="Teacher details"),
     *                 @OA\Property(property="linkedin", type="string", example="https://www.linkedin.com/in/engg-shishir/", description="LinkedIn account URL"),
     *                 @OA\Property(property="facebook", type="string", example="https://www.facebook.com/Engg.Shishir/", description="Facebook account URL")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Teacher updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function update(TeacherRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->teacherService->update($id, $request->all()),
                Response::HTTP_OK,
                __('Teacher updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/backend/teachers/{id}",
     *      tags={"Teachers"},
     *      summary="Delete a Teacher",
     *      description="Delete a Teacher by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the Teacher to delete",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(name="deleted", description="Delete type, Soft=1, Hard=9, Keep empty for permanent delete", example="1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(
     *          response=200,
     *          description="Teacher deleted successful",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Teacher not found"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        try {
            $deleteStatusInt = (int) $request->deleted ?? DeleteStatus::SOFT_DELETE;
            $deleteMessage = new DeleteMessage($deleteStatusInt, 'Teacher');

            return $this->responseJson(
                $this->teacherService->delete(
                    $id,
                    $deleteStatusInt
                ),
                Response::HTTP_OK,
                __($deleteMessage->format())
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PATCH(
     *     path="/api/v1/backend/teachers/{id}",
     *     tags={"Teachers"},
     *     summary="Update teacher",
     *     description="Teacher update api",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PATCH / POST", example="PATCH", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"t_id", "reg", "department_id", "faculty_id", "website", "email", "password", "name", "phone", "blood", "address", "image_url", "cv_link", "bio", "linkedin", "facebook"},
     *                 @OA\Property(property="t_id", type="integer", example="1802043", description="Teacher ID"),
     *                 @OA\Property(property="reg", type="string", example="08453", description="Teacher reg no"),
     *                 @OA\Property(property="department_id", type="integer", example=1, description="Department id"),
     *                 @OA\Property(property="faculty_id", type="integer", example=1, description="Faculty ID"),
     *                 @OA\Property(property="website", type="integer", example="https://www.facebook.com/Engg.Shishir/", description="Website"),
     *                 @OA\Property(property="email", type="string", example="shishir.cse.pstu@gmail.com", description="Teacher email address"),
     *                 @OA\Property(property="password", type="string", example="password", description="Account password"),
     *                 @OA\Property(property="name", type="string", example="Engg.Shishir", description="Name of the Teacher"),
     *                 @OA\Property(property="phone", type="string", example="1234567890", description="Phone number"),
     *                 @OA\Property(property="blood", type="string", example="B+", description="Blood group"),
     *                 @OA\Property(property="address", type="string", example="123 Main St, City, State, ZIP", description="Address of the Teacher"),
     *                 @OA\Property(property="image_url", type="string", example="https://pstuian.com/uploads/Teacher/1802043.jpeg", description="Image URL of the Teacher"),
     *                 @OA\Property(property="cv_link", type="string", example="https://cv.pstuian.com/cv_1802043.pdf", description="Teacher CV URL"),
     *                 @OA\Property(property="bio", type="string", example="Teacher details", description="Teacher details"),
     *                 @OA\Property(property="linkedin", type="string", example="https://www.linkedin.com/in/engg-shishir/", description="LinkedIn account URL"),
     *                 @OA\Property(property="facebook", type="string", example="https://www.facebook.com/Engg.Shishir/", description="Facebook account URL")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Teacher updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     */

    public function patch(TeacherRequest $request, int $id)
    {
        $user = $this->teacherService->getById($id);

        if (!$user) {
            return response()->json(['message' => 'Teacher not found'], 404);
        }

        $fieldsToUpdate = $request->all();

        if (!empty($fieldsToUpdate)) {
            foreach ($fieldsToUpdate as $field => $value) {
                if (!in_array($field, $user->getFillable())) {
                    return response()->json(['message' => "Field '$field' is not fillable in the Teacher model"], 422);
                }
            }
            return $this->responseJson(
                $this->teacherService->update($id, $fieldsToUpdate),
                Response::HTTP_OK,
                __('Teacher updated successfully.')
            );

        } else {
            return response()->json(['message' => 'At least one field is required for update'], 422);
        }
    }
}
