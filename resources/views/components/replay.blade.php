{{-- <div class="row">
{{ $comment }}
    <div class="col-md-11">
        <input type="text" name="" id="" class="form-control" required>
    </div>
    <div class="col-md-1">
          <button type="submit" class="btn btn-info">Replay</button>
    </div>
</div> --}}

<form action="{{ route('Comment.Add',[$comment->post_id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col-md-12 row mb-3">
        <div class="col-md-5">
            <div class="custom-file">
                <input type="file" name="media" class="custom-file-input" id="customFile" multiple="">
                <label class="custom-file-label" for="customFile">Upload image</label>
            </div>
        </div>
        <div class="col-md-6">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <input type="text" name="comment" id="" class="form-control" required>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-info">Reply</button>
        </div>
    </div>
</form>
