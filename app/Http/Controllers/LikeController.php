<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Input;

class LikeController extends Controller
{
    //
     public function postlike()
    {
      $postId=Input::get('postId');
      $post=Post::find($postId);

      if (!$post->Youliked()) {
          $post->Youlikeit();
          return response()->json(['status'=> 'success', 'message' => 'liked']);
      }else{
        $post->YouUnlike();
        return response()->json(['status'=> 'success', 'message' => 'unliked']);
      }
    }
}
