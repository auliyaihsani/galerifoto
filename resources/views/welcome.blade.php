@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">wellcome, {{Auth::user()->name}}</div>
            </div>
                <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-block"> <i class="fa fa-upload"></i>  upload image</a>
        </div>
    </div>
</div>
<!-- modal boostrap -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <form  action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="form-group">
            <input type="file" class="form-control" name="image" value="">
          </div>

          <div class="form-group">
            <textarea name="description" class="form-control" placeholder="deskripsi foto"></textarea>
          </div>
          <button type="submit" class="btn btn-success btn-block" name="button">Simpan</button>
        </form>
      </div>
    </div>

  </div>
</div>

<hr>
<div class="container">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        Galery
      </div>
    </div>
  </div>
@foreach ($posts as $post)
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="show_image"><a href="#{{$post->id}}" data-toggle="modal" ><img src="{{asset('image/'.$post->image)}}" alt=""> </a>

        </div>
      </div>
      <div class="post-footer">
        <div class="button-footer">
          <a href="#{{$post->id}}" data-toggle="modal" class="btn btn-default btn-xs"> <i class="fa fa-comment"></i> Komentar</a>
          <span class="btn btn-default btn-xs">{{$post->comments()->count()}}</span>
          <span class="btn btn-default btn-xs {{$post->Youliked()? "liked":""}}" onclick="postlike('{{$post->id}}', this)" ><i class="fa fa-thumbs-up">suka</i></span>
            <span class="btn btn-default btn-xs" id="{{$post->id}}-count">{{$post->likes()->count()}}</span>
        </div>
      </div>
    </div>

  </div>

<!-- modal komen -->
<div class="modal fade" id ="{{$post->id}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="show_modal_image"><a href="" ><img src="{{asset('image/'.$post->image)}}" alt=""> </a></div>
        <div class="desc-post">
          description
        </div>
        <div class="panel-footer" style="border-radius: 12px;">
          <span class="user-info">by sani</span>
          <span class="user-time pull-right">2 min ago</span>
        </div>
        <br>
        <h4><b>Komentar</b></h4>
        <form class="" action="{{route('addComment', $post->id)}}" method="post">
          {{ csrf_field() }}
          <div class="form-group">
            <input type="text" name="content" value="" class="form-control" placeholder="tulis komentar">
          </div>
          <button type="submit" class="btn btn-success btn-block" name="button">Komentar</button>
        </form>
        <hr>
        <div class="comment-list">
          @if($post->comments->isEmpty())
          <div class="text-center">
            tidak ada komentar
          </div>
          @else
          @foreach ($post->comments as $comment)
          <div class="comment-body">
            <p>{{$comment->content}}</p>
            <div class="comment-info">
              <span class="btn btn-default btn-xs"> <i class="fa fa-thumbs-up">suka</i> </span>
              <button class="btn btn-default btn-xs">2</button>
              <span class="pull-right">
              <span><small> by {{$comment->user->name}}</span></small>
              <span>{{$comment->created_at->diffForhumans()}}</span> |
              </span>
            </div>
          </div>
        @endforeach
        @endif
        </div>

      </div>
    </div>
  </div>
</div>


@endforeach
</div>  <!-- end container  -->
@endsection


<style type="text/css">
  .show_image img{
    width: 100%;
    height: 30%;
  }

  .post-footer{
    padding: 13px;
    padding-top: 0px;
  }

  .show_modal_image img{
    width: 100%;
    height: auto;
  }

  .description {
    margin-bottom: 22px;
    padding: 14px;
  }

  .liked {
    background: #099;
    background-color: #444;
  }


  .desc-post{
    padding: 14px;
    margin-bottom: 22px;
  }

  .comment-body{
    background-color: #2ab27b;
    color: #ffff;
    padding: 16px;
    border-top-right-radius: 25px;
    border-top-left-radius: 20px;
    margin-bottom: 17px;
  }

  .comment-body p{
    font-size: 21px;
    margin-bottom: 10px;
    border-bottom: 1px solid #eee;

  }

</style>


@section('js')
  <script type="text/javascript">
    function postlike(postId, elem){
      var csrfToken = '{{csrf_token()}}';
      var likeCount = parseInt($('#'+postId+"-count").text());
      $.post('{{route('postlike')}}', {postId:postId, _token:csrfToken}, function (data){
        console.log(data);

        if (data.message ==='liked') {
          $('#'+postId+"-count").text(likeCount+1);
          $(elem).text('anda menyukai ini').css({color:'blue'});
        }else{
          $('#'+postId+"-count").text(likeCount-1);
          $(elem).text('tidak suka').css({color:'red'});
        }
      });
    }
  </script>
@endsection
