<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ApiDocumentController extends Controller
{
    public function getApiDocs()
    {
        $swaggerYamlFile = url('documentation/yaml-file/index-v1.yaml');
        return view('swagger', compact('swaggerYamlFile'));
    }

    public function getYamlFile($file)
    {
        $content = file_get_contents(storage_path("docs/{$file}"));
        return response($content, Response::HTTP_OK)->header('Content-Type', 'application/yaml');
    }

    public function getYamlPathFile($folder, $file)
    {
        \Log::info($file);
        $content = file_get_contents(storage_path("docs/path/{$folder}/{$file}"));
        return response($content, Response::HTTP_OK)->header('Content-Type', 'application/yaml');
    }

    public function getYamlResponseFile($file)
    {
        $content = file_get_contents(storage_path("docs/response/{$file}"));
        return response($content, Response::HTTP_OK)->header('Content-Type', 'application/yaml');
    }

    public function getYamlModelsFile($file)
    {
        $content = file_get_contents(storage_path("docs/models/{$file}"));
        return response($content, Response::HTTP_OK)->header('Content-Type', 'application/yaml');
    }
}
