@extends('layouts.front')


@section('content')
    <div class="content-wrap well">
        <h4>{{$thread->subject}}</h4>
        <hr>

        <div class="thread-details">
            {!! ($thread->thread)  !!}
        </div>
        <br>
        @if(Auth::user()->id === $thread->user_id)
        <div class="actions">

                <a href="{{route('thread.edit',$thread->id)}}" class="btn btn-info btn-xs">Edit</a>

                {{--//delete form--}}
                <form action="{{route('thread.destroy',$thread->id)}}" method="POST" class="inline-it">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <input class="btn btn-xs btn-danger" type="submit" value="Delete">
                </form>

            </div>
        @endif
    </div>
    <hr>
    <br>

    {{--Answer/comment--}}
    <div class="comment-list">
        @foreach($thread->comments as $comment)
            <div class="comment-list well well-lg">
                @include('thread.partials.comment-list')

                <button class="btn btn-xs btn-default" onclick="toggleReply('{{$comment->id}}')">reply</button>
                <br>
                {{--//reply form--}}
                <div style="margin-left: 50px" class="reply-form-{{$comment->id}} hidden">

                    <form action="{{route('replycomment.store',$comment->id)}}" method="post" role="form">
                        {{csrf_field()}}
                        <legend>Create Reply</legend>

                        <div class="form-group">
                            <input type="text" class="form-control" name="body" id="" placeholder="Reply...">
                        </div>


                        <button type="submit" class="btn btn-primary">Reply</button>
                    </form>

                </div>
                <hr>
                <br>


            @foreach($comment->comments as $reply)
                    @include('thread.partials.reply-list')

                @endforeach


                @endforeach
    </div>
            <hr>
            <br>


            <div class="comment-form">
        <form action="{{route('threadcomment.store',$thread->id)}}" method="post" role="form">
            {{csrf_field()}}
            <legend>Leave Comment</legend>

            <div class="form-group">
                <input type="text" class="form-control" name="body" id="" placeholder="Input...">
            </div>


            <button type="submit" class="btn btn-primary">Answer</button>
        </form>
    </div>
    <div class="actions">

    </div>


@endsection
        @section('js')

                <script>
                    function toggleReply(commentId){
                        $('.reply-form-'+commentId).toggleClass('hidden');
                    }
                </script>

@endsection


