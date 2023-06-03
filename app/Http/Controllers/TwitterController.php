<?php

namespace App\Http\Controllers;

use App\Models\Twitter;
use App\Events\TwitterCreated;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Twitter\SearchRequest;
use App\Http\Requests\Twitter\StoreTwitterRequest;

class TwitterController extends Controller
{
    public function store(StoreTwitterRequest $request)
    {
        DB::beginTransaction();
        try {
            $twitter = Twitter::create($request->validated());

            event(new TwitterCreated($twitter));
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Server Error!"], 500);
        }
        
        return response()->json(["message" => "Tweet created successfully."]);
    }

    public function search(SearchRequest $request)
    {
        $searchQueries = [];

        if ($request->has("start_date")) {
            $endDate = $request->input("end_date", now()->format("Y-m-d"));
            $searchQueries[] = sprintf("created_at:[%s TO %s]", $request->start_date, $endDate);
        }

        if ($request->has("content")) {
            $searchQueries[] = sprintf('content:"%s"', $request->content);
        }

        if ($request->has("resource")) {
            $searchQueries[] = sprintf('resource:"%s"', $request->resource);
        }

        if ($request->has("user")) {
            $searchQueries[] = sprintf('(user_name:"%s" OR user_username:%s)', $request->user, $request->user);
        }

        $query = implode(" AND ", $searchQueries);

        $result = Twitter::search($query)->paginate(15);

        return $result->toJson();
    }
}
