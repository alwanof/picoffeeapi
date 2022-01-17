<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Http\Resources\UserResource;
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
            'password' => $request->password
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

    public function userTweets($id)
    {
        $user = User::find($id);
        $user->tweet();
        return TweetResource($id);
    }


    public function userProfile($id)
    {
        $user = User::find($id);
        $user->profile();
        return ProfileResource($id);
    }

    public function followUser(Request $request)
    {
        $user = User::find($request->id);
        if(!$user->following())
        {
            $user->following()->attach($request->id);
            $user->save();
        }
        else{
            $user->following()->detach($request->id);
            $user->save();
        }
        return response('Status Changed Successfully',200);
    }

}
