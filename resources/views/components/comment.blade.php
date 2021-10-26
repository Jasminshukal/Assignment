<div class="jumbotron ">
    <div class="container">
      <h5>{{ $comment->User->name }} | {{ $comment->updated_at->diffForHumans() }}</h5>

      @if ($comment->user_id==\Auth::user()->id)
        <a href="{{ route('Comment.Delete',[$comment]) }}" class="btn btn-danger float-right">Delete comment</a>
      @endif

      <p class="lead">{{ $comment->comment }}</p>
        @isset($comment->file_name)
            <a href="{{ asset('comment/'.$comment->file_name) }}" target="_blank" class="mb-3">
            <span class="badge badge-secondary">{{ $comment->file_name }}</span>
            </a>
        @endisset
        <hr>
        <x-replay :comment="$comment" :perent_id="$comment->id"></x-replay>
    </div>
</div>
@foreach ($comment->child as $item)
    <div class="ml-5">
        <x-comment :comment="$item"></x-comment>
    </div>
@endforeach
