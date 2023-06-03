<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function list()
    {
        return response()->json(Resource::paginate());
    }

    public function subscribe(Request $request, Resource $resource)
    {
        $user = User::find(1);
        if (!$user) {
            throw new Exception("run db:seed command first");
        }
        
        if (!Auth::check())
        Auth::login($user);
        
        if ($resource->subscribers()->whereId($user->id)->exists())
            return response()->json(["message" => "you've already subscribed."]);

        $resource->subscribers()->attach($user->id);

        return response()->json([
            "message" => sprintf("you have been subscribed to the %s resource.", $resource->name)
        ]);
    }
}
