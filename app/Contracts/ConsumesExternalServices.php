<?php

namespace App\Contracts;

use Illuminate\Support\Facades\Http;

/**
 * Trait ConsumesExternalServices
 * @package App\Traits
 * docs https://laravel.com/docs/8.x/http-client
 */
trait ConsumesExternalServices
{
    use ResponseTrait;

    public function get($requestUrl, $param)
    {
        return $this->call('get', $requestUrl, $param);
    }

    public function post($requestUrl, $param)
    {
        return $this->call('post', $requestUrl, $param);
    }

    public function put($requestUrl, $param)
    {
        return $this->call('put', $requestUrl, $param);
    }

    public function patch($requestUrl, $param)
    {
        return $this->call('patch', $requestUrl, $param);
    }

    public function delete($requestUrl, $param)
    {
        return $this->call('delete', $requestUrl, $param);
    }

    public function call($method, $requestUrl, $param, $headers = [])
    {
        $baseUrl          = config('services.domain.dutta');
        $headers['Token'] = request()->bearerToken();

        if (str_contains($headers['content-type'], 'application/x-www-form-urlencoded')) {
            return Http::asForm()->withHeaders($headers)->$method($baseUrl . $requestUrl, $param);
        }

        return Http::withHeaders($headers)->$method($baseUrl . $requestUrl, $param);
    }
}
