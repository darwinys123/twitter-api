<?php

namespace App\Http\Controllers;

use App\Services\FollowerService;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function index(FollowerService $followerService)
    {
        return $followerService->list();
    }

    public function follow($id, FollowerService $followerService)
    {
        return $followerService->follow($id);
    }

    public function unfollow($id, FollowerService $followerService)
    {
        return $followerService->unfollow($id);
    }
}
