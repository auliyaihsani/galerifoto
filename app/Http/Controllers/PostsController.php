<?php

namespace App\Http\Controllers;
use App\Post;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function store(Request $request)
    {
      $request->validate([
        'description'=> 'required',
        'image'=> 'required | image | mimes:jpg,jpeg| max:2000',

      ]);


      $post = New Post;
      $post->description = $request->description;
      $post->user_id = auth()->id();

      if ($request->hasFile('image')){
        $file = $request->file('image');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('/image');
        $file->move($destinationPath, $fileName);
        $post->image = $fileName;
      }
      $post->save();
      return back()->withMessage('berhasil di upload');
    }
}
