<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\TweetResource;
use App\Models\Comment;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        return UserResource::collection(User::paginate(11));
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
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
    if($validation){
        $id->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return new UserResource($id);
    }
        return response()->json(['status' => 404, 'message' => 'some attributes are missing']);
    }


    public function destroy(User $id)
    {
        $id->delete();
        return  response('User has been Deleted Successfully!',200);
    }

    public function userTweets($id)
    {
        $user = User::find($id);
        return $user->tweets;
    }

    public function followUser(Request $request)
    {
        $user = User::find($request->from_user_id);

        if($user->following()->where('to_user_id',$request->to_user_id)->exists())
        {
            $user->following()->detach($request->to_user_id);
            return response('unfollowed successfully',200);
        }
        else
        {
            $user->following()->attach($request->to_user_id);
            return response('followed successfully',200);
        }

    }

}
