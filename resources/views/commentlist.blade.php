@if(count($comments) > 0)
@foreach($comments as $comment)


<div class="comments-wrap">
    <div class="comments-header">
        <div class="comment-by"><i class="fa fa-user-circle"></i>{{ $comment->user->name }}</div>
        <div class="comment-time">{{ $comment->created_at->diffForHumans() }}</div>                                       
    </div>
    <div class="comments-content">
        <p>{{ $comment->comment }}</p>
    </div> 
</div>
@endforeach
@else
<div class="comments-wrap">
    <div class="comments-content mt-0">
        <p>There are no comments yet.</p>
    </div>
</div>
@endif