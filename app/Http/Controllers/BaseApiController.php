<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;

/**
 * Class BaseApiController.
 *
 * @package App\Http\Controllers
 */
class BaseApiController extends BaseController
{
    use ResponseTrait;
    /**
     * Include relations, relations must be define in transformer
     *
     * @param string|array $includes
     * @return $this
     */
    public function parseIncludes($includes)
    {
        $this->fractal->parseIncludes($includes);

        return $this;
    }

    /**
     * Return data with item.
     *
     * @param object $item
     * @param $callback
     * @return JsonResponse
     */
    public function responseWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);

        return $this->responseFractal($resource);
    }

    /**
     * Return data with collection.
     *
     * @param $collection
     * @param $callback
     * @return JsonResponse
     */
    public function responseWithCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);

        return $this->responseFractal($resource);
    }

    /**
     * Return data with paginator.
     *
     * @param LengthAwarePaginator $paginator
     * @param $callback
     * @return JsonResponse
     */
    public function responseWithPaginator($paginator, $callback)
    {
        $resource = new Collection($paginator->getCollection(), $callback);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->responseFractal($resource);
    }

    /**
     * Return response.
     *
     * @param ResourceInterface $resource
     * @return JsonResponse
     */
    private function responseFractal(ResourceInterface $resource)
    {
        $data = $this->fractal->createData($resource)->toArray();

        return $this->responseOk($data);
    }
}
