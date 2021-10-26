@extends('layouts.app')

@section('content')
<div class="container gedf-wrapper">
    <div class="row">
        <div class="col-md-12 align-self-center">
            <div class="card gedf-card mb-3">
                <form action="{{ route('Post.update',[$post_detail]) }}" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label class="" for="message">Title</label>
                                        <input name="title" type="text" class="form-control" rows="3" value="{{ $post_detail->title }}" placeholder="Enter Post Title hear ?" required>
                                        <p>Min 20 characters and max 255 characters required</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="message">Description</label>
                                        <textarea class="form-control" id="message" name="description" rows="3" placeholder="What are you thinking?" required>{{ $post_detail->description }}</textarea>
                                    </div>
                                    @foreach ($post_detail->Media as $item)
                                        <a href="{{ asset('posts/'.$item->file_name) }}" target="_blank">
                                            <span class="badge badge-secondary">{{ $item->file_name }}</span>
                                        </a>
                                        @if($post_detail->user_id==\Auth::user()->id)
                                            <a href="{{ route('RemoveMedia',[$item]) }}" class="btn-xs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg></a>
                                        @endif
                                    @endforeach
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" name="media[]" class="custom-file-input" id="customFile" multiple>
                                            <label class="custom-file-label" for="customFile">Upload image</label>
                                        </div>
                                    </div>

                        </div>
                        <div class="btn-toolbar justify-content-between">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            <div class="btn-group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-globe"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="#"><i class="fa fa-globe"></i> Public</a>
                                    <a class="dropdown-item" href="#"><i class="fa fa-users"></i> Friends</a>
                                    <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Just me</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
