<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Http\Resources\TweetResource;

class TweetController extends Controller
{
    public function index(){

        return TweetResource::collection(Tweet::paginate(10));
       // return response()->json(Tweet::paginate(10));
    }

    public function show($id){

        $tweet=Tweet::find($id);
        return response()->json($tweet);
    }

    public function topTweets(){
       // return Tweet::withCount(['likes'])->orderBy('tweet_id')->get();
      //  return response()->json(Tweet::where('tweet_id','1')->with(['likes'])->get());
      $all=TweetResource::collection(Tweet::all());
      return $all->sortBy('likes_count');


    }

    public function specificTopTweets($id){

        $tweet=Tweet::find($id);
        return response()->json($tweet);
    }

    public function tweetComments($id){
        //$tweet=Tweet::find($id);
        //return response()->json($tweet::with(['comments'])->get());
        return response()->json(Tweet::where('id', $id)->with(['comment'])->get());


        }

    public function store(Request $request){

        $tweet=new Tweet();

        $tweet->tweet=$request->tweet;
        $tweet->user_id=$request->user_id;
       // $tweet->likes_count=0;

        $tweet->save();
        return response()->json($tweet);
    }

    public function update(Request $request,$id){

        $tweet=Tweet::find($id);
        $tweet->tweet=$request->tweet;
        $tweet->save();
        return response()->json($tweet);
    }

    public function destroy($id){

        $tweet=Tweet::find($id);
        $tweet->delete();
        return response('Deleted Successfully!',200);

    }

    public function like(Request $request){

        //$tweet=Tweet::find($id);

        $tweet = Tweet::find($request->id);

        if($tweet->likes()->get()->contains($request->user_id)){
             $tweet->likes()->deattach($request->id);
        }
        else {
             $tweet->likes()->attach($request->id);
             $tweet->likes_count = $tweet->likes_count++;

        }

        $tweet->save();

        return response()->json(['success'=>'Status change successfully.']);

    }
}
