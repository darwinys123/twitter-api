<?php

namespace App\Http\Controllers;

use App\Http\Requests\TweetRequest;
use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use App\Services\TweetService;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index(TweetService $tweetService)
    {
        return $tweetService->list();
    }

    public function store(TweetRequest $request, TweetService $tweetService)
    {
        return $tweetService->storeTweet($request);
    }

    public function update(Request $request, $id, TweetService $tweetService)
    {
        return $tweetService->updateTweet($request, $id);
    }

    public function delete(TweetService $tweetService, $id)
    {
        return $tweetService->deleteTweet($id);
    }
}
