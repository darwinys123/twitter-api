<?php

namespace App\Services;

use App\Models\UserFollower;
use Illuminate\Support\Facades\Auth;

class FollowerService
{
  public function list()
  {
    $followers = UserFollower::with('follower')->where('user_id', Auth::user()->id)->get();

    return $followers;
  }

  public function follow($id)
  {
    $myId = Auth::user()->id;
    $userFollowers = UserFollower::where('user_id', $id)->where('follower_id', $myId)->first();
    if (!$userFollowers) {
      $newFollow = new UserFollower;
      $newFollow->user_id = $id;
      $newFollow->follower_id = $myId;
      $newFollow->save();

      return response()->json(['message' => 'User Followed']);
    }
    return response()->json(['message' => 'User Already Followed'], 400);
  }

  public function unfollow($id)
  {
    $myId = Auth::user()->id;
    $userFollowers = UserFollower::where('user_id', $id)->where('follower_id', $myId)->first();
    if (!$userFollowers) {
      return response()->json(['message' => 'You did not follow this user'], 400);
    }
    $userFollowers->delete();
    return response()->json(['message' => 'You unfollowed this user']);
  }
}
