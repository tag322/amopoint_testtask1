<?php

namespace App\Http\Controllers;

use App\Models\UserApiExample;

class UserApiExampleController extends Controller
{
    public function index()
    {
        $users = UserApiExample::with('posts')->get();

        return response()->json($users);
    }
}
