<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Events\NewsCreated;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SearchRequest;
use App\Actions\Search\ElasticSearch;
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
        $query = ElasticSearch::buildQuery($request);

        $result = News::search($query)->paginate(15);

        return $result->toJson();
    }
}
