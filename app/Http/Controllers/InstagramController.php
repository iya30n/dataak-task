<?php

namespace App\Http\Controllers;

use App\Models\Instagram;
use App\Events\InstagramCreated;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SearchRequest;
use App\Actions\Search\ElasticSearch;
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
            return response()->json(["message" => "Server Error!"], 500);
        }
        
        return response()->json(["message" => "Instagram post created successfully."]);
    }

    public function search(SearchRequest $request)
    {
        $query = ElasticSearch::buildQuery($request);

        $result = Instagram::search($query)->paginate(15);

        return $result->toJson();
    }
}