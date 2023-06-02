<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Instagram;
use Illuminate\Http\Request;

class InstagramController extends Controller
{
    public function addNew()
    {
        // create new record
        // attach it to the elastic
        // return response with done message and created record.
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