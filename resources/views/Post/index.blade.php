@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/post.css') }}">
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">

@endsection

@section('content')
<div class="container gedf-wrapper">
    <div class="row">


        <div class="col-md-12 align-self-center">
                @if (Session::has('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ Session::get('success') }}</strong>
                        </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <!--- \\\\\\\Post-->
            <div class="card gedf-card mb-3">
                <form action="{{ route('Post.store') }}" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                                    @csrf
                                    <div class="form-group">
                                        <label class="" for="message">Title</label>
                                        <input name="title" type="text" class="form-control" rows="3" placeholder="Enter Post Title hear ?" value="{{ old('title') }}" required>
                                        <p>Min 20 characters and max 255 characters required</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="message">Description</label>
                                        <textarea class="form-control" id="message" name="description" rows="3" placeholder="What are you thinking?" required>{{ old('description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" name="media[]" class="custom-file-input" id="customFile" multiple>
                                            <label class="custom-file-label" for="customFile">Upload image</label>
                                        </div>
                                    </div>

                        </div>
                        <div class="btn-toolbar justify-content-between">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary">Store</button>
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
            <!-- Post /////-->

            <!--- \\\\\\\Post-->
            {{-- <div class="card gedf-card mb-3">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                            </div>
                            <div class="ml-2">
                                <div class="h5 m-0">@LeeCross</div>
                                <div class="h7 text-muted">Miracles Lee Cross</div>
                            </div>
                        </div>
                        <div>
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>10 min ago</div>
                    <a class="card-link" href="#">
                        <h5 class="card-title">Lorem ipsum dolor sit amet, consectetur adip.</h5>
                    </a>

                    <p class="card-text">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo recusandae nulla rem eos ipsa praesentium esse magnam nemo dolor
                        sequi fuga quia quaerat cum, obcaecati hic, molestias minima iste voluptates.
                    </p>
                </div>
                <div class="card-footer">
                    <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                    <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
                </div>
            </div> --}}
            <!-- Post /////-->

            @foreach ($posts as $post)
                <div class="card gedf-card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                </div>
                                <div class="ml-2">
                                    <div class="h5 m-0">{{ $post->User->name }}</div>
                                    <div class="h7 text-muted">{{ $post->User->email }}</div>
                                </div>
                            </div>
                            @if($post->user_id==\Auth::user()->id)
                            <a href="{{ route('Post.edit',[$post]) }}" target="_blank" class="btn btn-info" rel="noopener noreferrer">
                                Edit
                            </a>
                            @endif
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>{{ $post->updated_at->diffForHumans() }}</div>
                        <a class="card-link" href="#">
                            <h5 class="card-title">{{ $post->title }}</h5>
                        </a>

                        <p class="card-text">
                            {{ $post->description }}
                        </p>
                        <p>
                            Totle Vote : <b>{{ $post->like }}</b>
                        </p>
                        <hr>
                        @foreach ($post->Media as $item)
                            <a href="{{ asset('posts/'.$item->file_name) }}" target="_blank">
                                <span class="badge badge-secondary">{{ $item->file_name }}</span>
                            </a>
                            @if($post->user_id==\Auth::user()->id)
                                <a href="{{ route('RemoveMedia',[$item]) }}" class="btn-xs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg></a>
                            @endif


                        @endforeach

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('Like',[$post]) }}" class="btn btn-success mr-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg> UpVote    </a>
                        <a href="{{ route('Un-Like',[$post]) }}" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg> DownVote </a>
                    </div>
                </div>
                <h3>Comments</h3>
                <hr>
                <form action="{{ route('Comment.Add',[$post]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12 row mb-3">
                        <div class="col-md-5">
                            <div class="custom-file">
                                <input type="file" name="media" class="custom-file-input" id="customFile" multiple="">
                                <label class="custom-file-label" for="customFile">Upload image</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="comment" id="" class="form-control" required>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-info">Comment</button>
                        </div>
                    </div>
                </form>
                @foreach($post->all_comment as $item)
                    <x-comment :comment="$item"></x-comment>
                @endforeach
            @endforeach






        </div>
    </div>
</div>
@endsection
