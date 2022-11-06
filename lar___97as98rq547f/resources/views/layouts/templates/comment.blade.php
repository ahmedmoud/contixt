<li class="comment">
<div class="media mb-4">

@if( Auth::check() && Auth::user()->id == $comment->user->id ) 
<a title="حذف التعليق" class="removeComment" CommentID="{{ $comment->id }}"><i class="fa fa-times" ></i></a> @endif
<img class="d-flex mr-3 rounded-circle" src="{{ url('images/fuser.png') }}" alt="" style=" height: auto; max-width: 68px; width: auto; "><b  itemprop="name" class="mt-0 comment-title">
@if( $comment->user_id == 630  )
   {{ $comment->name ? $comment->name : 'عضو/ة' }}
@else
{{ $comment->user->name }}
@endif
</b><span itemprop="commentTime">{{ $comment->created_at }}</span><div itemprop="commentText" class="media-body comment-body ">{!! $comment->comment !!}</div></div>
</li>