<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function list()
    {
        return response()->json(Resource::paginate());
    }

    public function subscribe(Request $request, Resource $resource)
    {
        
    }
}
