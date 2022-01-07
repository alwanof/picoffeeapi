<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if($user == false){
            $response = [
                'statusCode' => '401',
                'messsage' => 'user was not fount',
            ];
            return(response()->json($response));
        }

        if(Hash::check($fields['password'], $user->password)){
            $response = [
                'statusCode' => '401',
                'messsage' => 'wrong password',
                'hash1' => $fields['password'],
                'hash2' => $user->password,
            ];
            return(response()->json($response));
        }

        $token = $user->createToken('PiCoffeeToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return(response()->json($response)->setStatusCode(200));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['email']),
        ]);

        $token = $user->createToken('PiCoffeeAppToken')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return(response()->json($response)->setStatusCode(201));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'statusCode' => '204',
            'messsage' => 'logout was successful',
        ];
        return(response()->json($response));
    }
}
