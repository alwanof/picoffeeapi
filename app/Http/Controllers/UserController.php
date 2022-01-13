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
        //
    }


    public function userProfile()
    {
        //
    }

    public function followUser(Request $request)
    {
        $user = auth()->user();
        $following = User::find($request->user_id);

        switch ($request->get('act')) {
            case "follow":
                $user->following()->attach($following);
                //response {"status":true}
                break;
            case "unfollow":
                $user->following()->detach($following);
                //response {"status":true}
                break;
            default:
                //response {"status":false, "error" : ['wrong act']}
        }
    }

}
