<?php

namespace App\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
/**
 * Trait ResponseTrait.
 *
 * @package App\Contracts
 */
trait ResponseTrait
{
    /**
     * Response success structure.
     *
     * @param $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    private function success($data, $message = 'SUCCESS', $code = Response::HTTP_OK)
    {
        return response()->json(
            [
                'status' => true,
                'code' => $code,
                'data' => $data
            ]
        );
    }

    /**
     * Response error structure.
     *
     * @param $message
     * @param int $status
     * @return JsonResponse
     */
    private function error($message, $status = Response::HTTP_BAD_REQUEST, $exceptionCode = null)
    {
        $decode = is_string($message) ? json_decode($message) : '';
        if ($decode) {
            $message = $decode;
        }

        return response()->json(
            [
                'status' => false,
                'data' => null,
                'error' => [
                    'code' => $exceptionCode?: $status,
                    'message' => $message,
                ],
            ],
            $status
        );
    }

    /**
     * Response OK (200).
     *
     * @param array $data
     * @param string $message
     * @return JsonResponse
     */
    public function responseOk($data = [], $message = 'RESPONSE_OK')
    {
        return $this->success($data, $message, Response::HTTP_OK);
    }

    /**
     * Response Bad Request (400).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function responseBadRequest($message = 'RESPONSE_BAD_REQUEST'): JsonResponse
    {
        return $this->error($message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Response errors message when validate failed.
     *
     * @param array $errors
     * @return JsonResponse
     */
    public function responseValidateFailed($errors = []): JsonResponse
    {
        return $this->error($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Response Unauthorized (403).
     *
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function responseUnauthorized(string $message = 'RESPONSE_UNAUTHORIZED', int $status = Response::HTTP_UNAUTHORIZED): JsonResponse
    {
        return $this->error($message, $status);
    }

    /**
     * Response Not Found (404).
     *
     * @param string $message
     * @return JsonResponse
     */
    public function responseNotFound($message = 'RESPONSE_NOT_FOUND'): JsonResponse
    {
        return $this->error($message, Response::HTTP_NOT_FOUND);
    }


    /**
     * Response Error Server (500).
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseErrorInternal($message = 'RESPONSE_INTERNAL_SERVER_ERROR', $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return $this->error($message, $statusCode);
    }

    /**
     * @param string $message
     * @param int    $statusCode
     *
     * @return JsonResponse
     */
    public function responseForbidden($message = 'RESPONSE_FORBIDDEN', $statusCode = Response::HTTP_FORBIDDEN): JsonResponse
    {
        return $this->error($message, $statusCode);
    }

    /**
     * Response OK (200).
     *
     * @param CursorPaginator $cursorPaginatorData
     * @return JsonResponse
     */
    public function responseCursorPaginator(CursorPaginator $cursorPaginatorData): JsonResponse
    {
        // $nextCursor = $cursorPaginatorData->nextCursor() ? $cursorPaginatorData->nextCursor()->encode() : null;
        try {
            $prevCursor = $cursorPaginatorData->previousCursor() ? $cursorPaginatorData->previousCursor()->encode() : null;
            $nextCursor = $cursorPaginatorData->nextCursor() ? $cursorPaginatorData->nextCursor()->encode() : null;
        } catch (\Exception) {
            $prevCursor = null;
            $nextCursor = null;
        }

        return response()->json(
            [
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $cursorPaginatorData->getCollection(),
                'pagination' => [
                    'next_cursor' => $nextCursor,
                    'prev_cursor' => $prevCursor,
                    'has_more' => $cursorPaginatorData->hasMorePages()
                ],
            ]
        );
    }
    
    /**
     * Response OK (200).
     *
     * @param LengthAwarePaginator $paginator
     *
     * @return JsonResponse
     */
    public function responsePaginator(LengthAwarePaginator $paginator): JsonResponse
    {
        return response()->json(
            [
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $paginator->getCollection(),
                'pagination' => [
                    'per_page' => $paginator->perPage(),
                    'current_page' => $paginator->currentPage(),
                    'total' => $paginator->total(),
                    'has_more' => $paginator->hasMorePages()
                ],
            ]
        );
    }

    /**
     * Response OK (200).
     *
     * @param CursorPaginator $cursorPaginatorData
     * @param array $data
     *
     * @return JsonResponse
     */
    public function responseCursorPaginatorWithAdditionalData(CursorPaginator $cursorPaginatorData, $data): JsonResponse
    {
        try {
            $prevCursor = $cursorPaginatorData->previousCursor() ? $cursorPaginatorData->previousCursor()->encode() : null;
            $nextCursor = $cursorPaginatorData->nextCursor() ? $cursorPaginatorData->nextCursor()->encode() : null;
        } catch (\Exception) {
            $prevCursor = null;
            $nextCursor = null;
        }

        $res = [
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $cursorPaginatorData->getCollection(),
            'pagination' => [
                'next_cursor' => $nextCursor,
                'prev_cursor' => $prevCursor,
                'has_more' => $cursorPaginatorData->hasMorePages()
            ],
        ];

        return response()->json(array_merge($res, $data));
    }

    /**
     * Response OK (200).
     *
     * @param LengthAwarePaginator $paginator
     * @param $data
     * @return JsonResponse
     */
    public function responsePaginatorWithAdditionalData(LengthAwarePaginator $paginator, $data): JsonResponse
    {
        $res = [
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $paginator->getCollection(),
            'pagination' => [
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total' => $paginator->total(),
                'has_more' => $paginator->hasMorePages()
            ],
        ];

        return response()->json(array_merge($res, $data));
    }
}
