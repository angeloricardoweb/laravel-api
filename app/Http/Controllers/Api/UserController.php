<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::paginate(10);
        return UserResource::collection($user);
    }

    public function store(StoreUpdateUserRequest $request)
    {
        // if ($request->password != $request->password_confirmation) {
        //     return response()->json(['error' => 'Passwords do not match'], 422);
        // }

        // $user = User::where('email', $request->email)->first();
        // if ($user) {
        //     return response()->json(['error' => 'User already exists'], 422);
        // }

        $data = $request->validated();
        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        return new UserResource($user);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return new UserResource($user);
    }
}
