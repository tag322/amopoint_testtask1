<?php

namespace App\Http\Controllers;

use App\Models\UserApiExample;

class UserApiExampleController extends Controller
{
    public function index()
    {
        $users = UserApiExample::with('posts')->get();

        $lastUpdatedAt = $users->max('updated_at');

        return response()->json([
            'last_updated_at' => $lastUpdatedAt,
            'data' => $users,
        ]);
    }
}
