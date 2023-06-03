<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Actions\Resource\Subscribe;

class ResourceController extends Controller
{
    public function list()
    {
        return response()->json(Resource::paginate());
    }

    public function subscribe(Resource $resource)
    {
        [$message, $statusCode] = (new Subscribe($resource))->handle();
        
        return response()->json([
            "message" => $message
        ], $statusCode);
    }
}
