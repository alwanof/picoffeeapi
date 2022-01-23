<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\TweetResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return UserResource::collection(User::paginate(10));
    }


    public function store(Request $request)
    {
        $new_user = User::create([
            'profile_id' => $request->profile_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return new UserResource($new_user);
    }


    public function show(User $id)
    {
        return new UserResource($id);
    }


    public function update(Request $request, User $id)
    {
        $id->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return new UserResource($id);
    }


    public function destroy(User $id)
    {
        $id->delete();
        return  response('User has been Deleted Successfully!',200);
    }

    public function userTweets(User $id)
    {
        $user = User::find($id);
        $user->tweets()->get();
        return new TweetResource($id);
    }


    public function userProfile(User $id)
    {
        $user = User::find($id);
        $user->profile();
        return new ProfileResource($id);
    }

    public function followUser(Request $request)
    {
//        $user = User::find($request->from_user_id);
//        $user->following($user)->detach($request->to_user_id);

        $user = User::find($request->from_user_id);
        $user->following($user)->attach($request->to_user_id);

        return response('Status Changed Successfully',200);
    }

}
