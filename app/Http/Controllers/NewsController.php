<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Events\NewsCreated;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\News\StoreNewsRequest;

class NewsController extends Controller
{
    public function store(StoreNewsRequest $request)
    {
        DB::beginTransaction();
        try {
            $news = News::create($request->validated());

            event(new NewsCreated($news));
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Server Error!"], 500);
        }
        
        return response()->json(["message" => "News created successfully."]);
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
            $searchQueries[] = sprintf('user_name:"%s"', $request->user);
        }

        $query = implode(" AND ", $searchQueries);

        $result = News::search($query)->paginate(15);

        return $result->toJson();
    }
}
