<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProfileResource::collection(Profile::paginate(10)->with('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile = Profile::create(
            [
                'user_id' => $request->user_id,
                'url' => $request->url,
                'gender' => $request->gender
            ]
        );
        $user = User::findOrFail($profile->user_id);
        $user->profile_id = $profile->id;
        $user->save();
        return new ProfileResource($profile);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $id)
    {
        return new ProfileResource($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        if ($request->url != null){
            $profile->url = $request->url;
        }
        if ($request->gender != null){
            $profile->gender = $request->gender;
        }

        if ($profile->save()){
            return new ProfileResource($profile);
        }
        
        return response()->json(['status' => 404, 'message' => 'some attributes are missing']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $id)
    {
        $validation = $request->validate([
            'url' => 'required',
            'gender' => 'required',
        ]);
        
        if($validation){
            $id->update([
                'url' => $request->url,
                'gender' => $request->gender
            ]);
            return new ProfileResource($id);
        }

        return response()->json(['status' => 404, 'message' => 'some attributes are missing']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $id)
    {
        $id->delete();
        return  response()->json(['status' => 204, 'message' => 'profile was deleted successfully',]);
    }
}
