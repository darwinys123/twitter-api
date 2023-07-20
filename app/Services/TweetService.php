<?php

namespace App\Services;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TweetService
{

  private $mediaService;

  public function __construct()
  {
    $this->mediaService = new MediaService;
  }

  public function list()
  {
    $tweets = TweetResource::collection(Tweet::orderBy('id', 'desc')->get());
    return $tweets;
  }

  public function storeTweet($request)
  {
    $tweet = new Tweet;
    $tweet->user_id = Auth::user()->id;
    $tweet->description = $request->description;
    if ($request->attachment) {
      $store = $this->mediaService->saveFile($request->attachment);
      $tweet->attachment = $store;
    }

    if ($tweet->save()) {
      return new TweetResource($tweet);
    }
  }

  public function updateTweet($request, $id)
  {
    $tweet = Tweet::find($id);
    if (!$tweet) {
      return response()->json(['message' => 'Tweet not found'], 400);
    }

    $tweet->description = $request->description;
    if ($request->attachment) {
      $store = $this->mediaService->saveFile($request->attachment);
      $tweet->attachment = $store;
    }

    if ($tweet->update()) {
      return new TweetResource($tweet);
    }
  }

  public function deleteTweet($id)
  {
    $tweet = Tweet::find($id);
    if (!$tweet) {
      return response()->json(['message' => 'Tweet already deleted sir']);
    }
    $tweet->delete();

    return response()->json(['message' => 'Tweet Deleted']);
  }
}
