<?php

namespace App\Actions\Search;

use Illuminate\Http\Request;

class ElasticSearch
{
	public static function buildQuery(Request $request)
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
            $searchQueries[] = sprintf('user_name:"%s"', $request->user);
        }

		if ($request->has("content")) {
            $searchQueries[] = sprintf('content:"%s"', $request->content);
        }

        return implode(" AND ", $searchQueries);
	}
}