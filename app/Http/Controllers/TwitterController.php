<?php

namespace App\Http\Controllers;

use App\Models\Twitter;
use App\Events\TwitterCreated;
use Illuminate\Support\Facades\DB;
use App\Actions\Search\ElasticSearch;
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
        $query = ElasticSearch::buildQuery($request);

        $result = Twitter::search($query)->paginate(15);

        return $result->toJson();
    }
}
