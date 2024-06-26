<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;


use App\Utilities\DeleteMessage;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;
use App\Services\StudentService;
use Exception;
use App\Enum\DeleteStatus;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends BaseController
{
    public function __construct(private readonly StudentService $studentService)
    {
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/students",
     *     tags={"Students"},
     *     summary="Get Students list as array",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Students list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $courses = $this->studentService->getPaginatedData();
            $status = Response::HTTP_OK;
            $total = $courses['total'] ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('students', $total) . ' found.';
            return $this->responseJson($courses, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/v1/backend/students/all",
     *     tags={"Students"},
     *     summary="Get Students list as array",
     *     description="",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Students list as array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function all(): JsonResponse
    {
        try {
            $courses = $this->studentService->all(
                ['deleted' => request()->deleted ?? DeleteStatus::NOT_DELETED]
            );
            $status = Response::HTTP_OK;
            $total = count($courses) ?? 0;
            $message = 'Total ' . $total . ' ' . Str::plural('students', $total) . ' found.';
            return $this->responseJson($courses, $status, $message);
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }


    /**
     * @OA\GET(
     *     path="/api/v1/backend/students/{id}",
     *     tags={"Students"},
     *     summary="Get a Student",
     *     description="Get a Student",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get a Student"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $employee = $this->studentService->getById($id);
            return $this->responseJson(
                $employee,
                Response::HTTP_OK,
                __('Student found')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/backend/students",
     *     tags={"Students"},
     *     summary="Insert new Student",
     *     description="Implement an API endpoint for administrators to effortlessly add new Student entries.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"s_id", "reg", "academicyear_id", "faculty_id", "batche_id", "email", "password", "name", "phone", "blood", "address", "image_url", "cv_link", "bio", "linkedin", "facebook"},
     *                 @OA\Property(property="s_id", type="string", example="1802043", description="Student ID"),
     *                 @OA\Property(property="reg", type="string", example="08453", description="Student reg no"),
     *                 @OA\Property(property="academicyear_id", type="integer", example=1, description="Academic session id"),
     *                 @OA\Property(property="faculty_id", type="integer", example=1, description="Faculty ID"),
     *                 @OA\Property(property="batche_id", type="integer", example=1, description="Batch ID"),
     *                 @OA\Property(property="email", type="string", example="shishir.cse.pstu@gmail.com", description="Student email address"),
     *                 @OA\Property(property="password", type="string", example="password", description="Account password"),
     *                 @OA\Property(property="name", type="string", example="John Doe", description="Name of the student"),
     *                 @OA\Property(property="phone", type="string", example="123-456-7890", description="Phone number"),
     *                 @OA\Property(property="blood", type="string", example="B+", description="Blood group"),
     *                 @OA\Property(property="address", type="string", example="123 Main St, City, State, ZIP", description="Address of the student"),
     *                 @OA\Property(property="image_url", type="string", example="https://pstuian.com/uploads/student/1802043.jpeg", description="Image URL of the student"),
     *                 @OA\Property(property="cv_link", type="string", example="https://cv.pstuian.com/cv_1802043.pdf", description="Student CV URL"),
     *                 @OA\Property(property="bio", type="string", example="student details", description="Student details"),
     *                 @OA\Property(property="linkedin", type="string", example="https://www.linkedin.com/in/engg-shishir/", description="LinkedIn account URL"),
     *                 @OA\Property(property="facebook", type="string", example="https://www.facebook.com/Engg.Shishir/", description="Facebook account URL")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Student created successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function store(StudentRequest $request): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->studentService->create($request->all()),
                Response::HTTP_CREATED,
                __('Student created successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/backend/students/{id}",
     *     tags={"Students"},
     *     summary="Update Student",
     *     description="Student update api",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="_method", description="PUT / POST", example="PUT", required=true, in="query", @OA\Schema(type="string")),
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"s_id", "reg", "academicyear_id", "faculty_id", "batche_id", "email", "password", "name", "phone", "blood", "address", "image_url", "cv_link", "bio", "linkedin", "facebook"},
     *                 @OA\Property(property="s_id", type="string", example="1802043", description="Student ID"),
     *                 @OA\Property(property="reg", type="string", example="08453", description="Student reg no"),
     *                 @OA\Property(property="academicyear_id", type="integer", example=1, description="Academic session id"),
     *                 @OA\Property(property="faculty_id", type="integer", example=1, description="Faculty ID"),
     *                 @OA\Property(property="batche_id", type="integer", example=1, description="Batch ID"),
     *                 @OA\Property(property="email", type="string", example="shishir.cse.pstu@gmail.com", description="Student email address"),
     *                 @OA\Property(property="password", type="string", example="password", description="Account password"),
     *                 @OA\Property(property="name", type="string", example="John Doe", description="Name of the student"),
     *                 @OA\Property(property="phone", type="string", example="123-456-7890", description="Phone number"),
     *                 @OA\Property(property="blood", type="string", example="B+", description="Blood group"),
     *                 @OA\Property(property="address", type="string", example="123 Main St, City, State, ZIP", description="Address of the student"),
     *                 @OA\Property(property="image_url", type="string", example="https://pstuian.com/uploads/student/1802043.jpeg", description="Image URL of the student"),
     *                 @OA\Property(property="cv_link", type="string", example="https://cv.pstuian.com/cv_1802043.pdf", description="Student CV URL"),
     *                 @OA\Property(property="bio", type="string", example="student details", description="Student details"),
     *                 @OA\Property(property="linkedin", type="string", example="https://www.linkedin.com/in/engg-shishir/", description="LinkedIn account URL"),
     *                 @OA\Property(property="facebook", type="string", example="https://www.facebook.com/Engg.Shishir/", description="Facebook account URL")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Student updated successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function update(StudentRequest $request, int $id): JsonResponse
    {
        try {
            return $this->responseJson(
                $this->studentService->update($id, $request->all()),
                Response::HTTP_OK,
                __('Student updated successfully.')
            );
        } catch (Exception $exception) {
            return $this->responseErrorJson($exception);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/backend/students/{id}",
     *      tags={"Students"},
     *      summary="Delete a student",
     *      description="Delete a student by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the student to delete",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Parameter(name="deleted", description="Delete type, Soft=1, Hard=9, Keep empty for permanent delete", example="1", required=false, in="query", @OA\Schema(type="integer")),
     *      @OA\Response(
     *          response=200,
     *          description="student deleted successful",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="student not found"
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
            $deleteMessage = new DeleteMessage($deleteStatusInt, 'Student');

            return $this->responseJson(
                $this->studentService->delete(
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

    public function patch(StudentRequest $request, int $id)
    {
        $user = $this->studentService->getById($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $fieldsToUpdate = $request->all();

        if (!empty($fieldsToUpdate)) {
            foreach ($fieldsToUpdate as $field => $value) {
                if (!in_array($field, $user->getFillable())) {
                    return response()->json(['message' => "Field '$field' is not fillable in the Employee model"], 422);
                }
            }
            return $this->responseJson(
                $this->studentService->update($id, $fieldsToUpdate),
                Response::HTTP_OK,
                __('Student updated successfully.')
            );

        } else {
            return response()->json(['message' => 'At least one field is required for update'], 422);
        }
    }
}
