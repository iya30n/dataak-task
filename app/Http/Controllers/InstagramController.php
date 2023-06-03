<?php

namespace App\Http\Controllers;

use App\Models\Instagram;
use App\Events\InstagramCreated;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\Instagram\StoreInstagramRequest;

class InstagramController extends Controller
{
    public function store(StoreInstagramRequest $request)
    {
        DB::beginTransaction();
        try {
            $instagram = Instagram::create($request->all());

            event(new InstagramCreated($instagram));
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            return response()->json(["message" => "Server Error!"], 500);
        }
        
        return response()->json(["message" => "Instagram post created successfully."]);
    }

    public function search(SearchRequest $request)
    {
        $searchQueries = [];

        if ($request->has("start_date")) {
            $endDate = $request->input("end_date", now()->format("Y-m-d"));
            $searchQueries[] = sprintf("created_at:[%s TO %s]", $request->start_date, $endDate);
        }

        if ($request->has("title")) {
            $searchQueries[] = sprintf('title:"%s"', $request->title);
        }

        if ($request->has("resource")) {
            $searchQueries[] = sprintf('resource:"%s"', $request->resource);
        }

        if ($request->has("user")) {
            $searchQueries[] = sprintf('(user_name:"%s" OR user_username:%s)', $request->user, $request->user);
        }

        $query = implode(" AND ", $searchQueries);

        $result = Instagram::search($query)->paginate(15);

        return $result->toJson();
    }
}