@extends('layouts.mainLayout')

@section('title', 'Community')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/community.css') }}">
@endpush

@section('content')
<!-- Main Section -->
<main style="background-color: #eff2f6">
    <div class="container py-4">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-3">
                <nav class="navbar navbar-expand-lg mx-0 pt-0">
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSideNavbar">
                        <div class="offcanvas-body d-block px-2 px-lg-0">
                            <div class="card overflow-hidden">
                                <div class="card-body pt-2">
                                    <div class="text-center">
                                        @auth
                                            <div class="avatar avatar-lg mt-n5 mb-3">
                                                <a href="{{ route('user.show', auth()->user()->id) }}">
                                                    <img class="avatar-img rounded border border-white border-3"
                                                        src="{{ auth()->user()->getProfileUrl() }}" alt="Profile Pic"
                                                        width="72">
                                                </a>
                                            </div>
                                            <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                            <small>{{ auth()->user()->email }}</small>
                                            <p class="mt-3">{{ auth()->user()->bio ?? 'Bio is Empty'}}</p>
                                            <div class="hstack gap-2 gap-xl-3 justify-content-center">
                                                @if (auth()->user()->canShare())
                                                    <div>
                                                        <h6 class="mb-0">{{ auth()->user()->posts->count() }}</h6>
                                                        <small>Post</small>
                                                    </div>
                                                    <div class="vr"></div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ auth()->user()->followers }}</h6>
                                                    <small>Followers</small>
                                                </div>
                                                <div class="vr"></div>
                                                <div>
                                                    <h6 class="mb-0">{{ auth()->user()->following }}</h6>
                                                    <small>Following</small>
                                                </div>
                                            </div>
                                        @endauth
                                        @guest
                                            <div class="avatar avatar-lg mt-n5 mb-3">
                                                <a>
                                                    <img class="avatar-img rounded border border-white border-3"
                                                        src="{{ asset('images/profile/profile.jpg') }}" alt="Profile Pic"
                                                        width="72">
                                                </a>
                                            </div>
                                            <h5 class="mb-0">Guest</h5>
                                        @endguest
                                    </div>
                                </div>
                                @auth
                                    <div class="card-footer text-center py-2">
                                        <a class="link-primary text-decoration-none"
                                            href="{{ route('user.show', auth()->user()->id )}}">View Profile </a>
                                    </div>
                                @endauth
                                @guest
                                    <div class="card-footer text-center py-2">
                                        <a class="link-primary text-decoration-none" href="{{ route('login')}}">Login</a>
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- Navbar END-->
            </div>
            <!-- Middle Section -->
            <div class="col-lg-6">
                <!-- Alerts -->
                <div>
                    @if(session()->has('alert'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('alert') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @error('post-title')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                    @error('post-image')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                    @error('post-video')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                </div>
                <!-- Share your Thoughts -->
                @auth
                    @if(auth()->user()->canShare())
                        <div class="card card-body mb-3">
                            <div class="d-flex mb-3">
                                <div class="me-2">
                                    <a href="{{ route('user.show', auth()->user()->id) }}"> <img
                                            class="avatar-sm rounded-circle" src="{{ auth()->user()->getProfileUrl() }}" alt=""
                                            width="50px"> </a>
                                </div>
                                <form class="w-100" action="{{ route('post.share') }}" method="POST">
                                    @csrf
                                    <input type="text" name="post-title" placeholder="Caption/Title (Optional)" minlength="5" maxlength="100" class="form-control mb-3">
                                    <textarea class="form-control" rows="3" name="post-message"
                                        placeholder="Share your thoughts..." minlength="3" required></textarea>
                                    @error('post-message')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="d-flex flex-wrap justify-content-end align-items-center">
                                        <button class="btn btn-sm btn-dark text-end mt-2">Post</button>
                                    </div>
                                </form>
                            </div>
                            <!-- Share Images/Videos -->
                            <ul class="nav nav-pills nav-stack small fw-normal gap-2">
                                <li class="nav-item">
                                    <button class="nav-link bg-grey py-1 px-2 mb-0" href="#!" data-bs-toggle="modal"
                                        data-bs-target="#postImage"> <i
                                            class="bi bi-image-fill text-success pe-2"></i>Photo</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link bg-grey py-1 px-2 mb-0" href="#!" data-bs-toggle="modal"
                                        data-bs-target="#postVideo"> <i
                                            class="bi bi-camera-reels-fill text-info pe-2"></i>Video</button>
                                </li>
                            </ul>
                        </div>
                        <hr>
                    @endif
                @endauth
                <div>
                    <!-- Single Post -->
                    @foreach ($posts as $post)
                    <div class="card mb-3">
                        <div class="px-3 pt-4 pb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img style="width:50px" class="me-2 avatar-sm rounded-circle"
                                        src="{{ $post->user->getProfileUrl() }}" alt="{{ $post->user->name }}">
                                    <div class="">
                                        <h5 class="card-title mb-0"><a href="{{ route('user.show', $post->user->id) }}"
                                                class="text-decoration-none text-dark">{{ $post->user->name }}</a></h5>
                                        <p class="text-muted m-0">{{ $post->user->email }}</p>
                                    </div>
                                </div>
                                <!-- Post dropdown -->
                                <div class="dropdown">
                                    <a class="text-dark btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('post', $post->id) }}">View Post</a>
                                        </li>
                                        @auth
                                            @if (auth()->user()->id === $post->user_id)
                                                <li>
                                                    <form action="{{ route('post.delete', $post->id) }}" method="POST">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button class="dropdown-item" type="submit">Delete Post</button>
                                                    </form>
                                                </li>
                                            @endif
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6>{{ $post->title }}</h6>
                            @if ($post->type === "message")
                                <p class="fs-6 fw-light text-muted">
                                    {{ $post->content }}
                                </p>
                            @elseif ($post->type === "image")
                                <div class="post">
                                    <img class="rounded" src="{{ $post->getPostUrl() }}" alt="Post">
                                </div>
                            @elseif ($post->type === "video")
                                <div class="post">
                                    <video controls>
                                        <source src="{{ $post->getPostUrl() }}" type="video/mp4">
                                    </video>
                                </div>
                            @endif
                            <!-- Like Section -->
                            <div class="d-flex justify-content-between my-3">
                                <div>
                                    @auth
                                        @if ($post->postLiked($post))
                                            <form action="{{ route('post.unlike', $post->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="fw-light text-danger nav-link fs-6"><i
                                                        class="bi bi-heart-fill"></i> {{ $post->totalLikes($post->id)
                                                    }}</button>
                                            </form>
                                        @else
                                            <form action="{{ route('post.like', $post->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="fw-light text-danger nav-link fs-6"><i
                                                        class="bi bi-heart"></i> {{ $post->totalLikes($post->id) }}</button>
                                            </form>
                                        @endif
                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}" class="fw-light text-danger nav-link fs-6"><i
                                                class="bi bi-heart-fill"></i> {{ $post->likes->count() }}</a>
                                    @endguest
                                </div>
                                <div>
                                    <span class="fs-6 fw-light text-muted"> <i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }} </span>
                                </div>
                            </div>
                            <!-- Comments Section -->
                            <div>
                                @auth
                                    @if (!$post->commentExists($post->id, auth()->user()->id))
                                        <form action="{{ route('post.comment') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="hidden" name="post-id" value="{{ $post->id }}">
                                                <input type="text" name="post-comment" class="form-control mb-3" required>
                                                @error('post-comment')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <button class="btn btn-dark btn-sm">Add Comment</button>
                                            </div>
                                        </form>
                                    @endif
                                @endauth
                                @foreach ($post->comments()->orderBy('created_at', 'DESC')->take(2)->get() as $comment)
                                <hr>
                                <div class="d-flex align-items-start">
                                    <img style="width:35px" class="me-2 avatar-sm rounded-circle"
                                        src="{{ $comment->user->getProfileUrl() }}" alt="Luigi Avatar">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('user.show', $comment->user->id) }}"
                                                class="mt-2 text-dark text-decoration-none">
                                                <h6 class="m-0">{{ $comment->user->name }}</h6>
                                            </a>
                                            <small class="fs-6 fw-light text-muted">{{
                                                $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="d-flex">
                                            <p class="fs-6 mt-3 fw-light">
                                                {{ $comment->comment }}
                                            </p>
                                            @auth
                                                @if ($comment->user_id === auth()->user()->id)
                                                    <div class="ms-auto my-auto">
                                                        <form action="{{ route('post.uncomment') }}" method="POST">
                                                            @method("DELETE")
                                                            @csrf
                                                            <input type="hidden" name="post-id" value="{{ $post->id }}" />
                                                            <button type="submit" class="btn btn-sm btn-danger m-0"><i
                                                                    class="bi bi-trash3-fill"></i></button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @if ($post->comments->count() > 2)
                                    <hr>
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-primary-soft text-primary fw-medium"
                                            href="{{ route('post', $post->id) }}">View All Comments</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Right Section -->
            <div class="d-none d-lg-block col-lg-3">
                <div class="card">
                    <div class="card-header pb-0 border-0">
                        <h5 class="">Trainers to Follow</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($trainers as $trainer)
                        <div class="hstack gap-2 mb-3 flex-wrap">
                            <div class="avatar">
                                <a href="{{ route('user.show', $trainer->id) }}">
                                    <img class="avatar-img rounded-circle" src="{{ $trainer->getProfileUrl() }}" alt=""
                                        width="50px">
                                </a>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-start">
                                <a class="h6 mb-0 text-decoration-none" href="{{ route('user.show', $trainer->id) }}">{{
                                    substr($trainer->name, 0, 15) }}..</a>
                                <a class="mb-0 small text-muted text-decoration-none"
                                    href="{{ route('user.show', $trainer->id) }}">{{ substr($trainer->email, 0, 15)
                                    }}..</a>
                            </div>
                            @auth
                                @if (!auth()->user()->follows($trainer->id))
                                    <div class="ms-auto">
                                        <form action="{{ route('user.follow') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user-id" value="{{ $trainer->id }}">
                                            <button class="btn btn-primary-soft rounded-circle icon-md"><i
                                                    class="bi bi-plus-lg"></i></button>
                                        </form>
                                    </div>
                                @else
                                    <div class="ms-auto">
                                        <form action="{{ route('user.unfollow') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user-id" value="{{ $trainer->id }}">
                                            <button class="btn btn-primary-soft rounded-circle icon-md"><i
                                                    class="bi bi-dash"></i></button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                            @guest
                                <a href="{{ route('login') }}"
                                    class="btn btn-primary-soft rounded-circle ms-auto icon-md"><i
                                        class="bi bi-plus-lg"></i></a>
                            @endguest
                        </div>
                        @endforeach
                        <div class="d-grid mt-3">
                            <a class="btn btn-sm btn-primary-soft" href="{{ route('trainers') }}">Show More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Image Modal -->
<div class="modal fade" id="postImage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Share Images</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('post.share.image') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="post-title" id="post-title" minlength="5" maxlength="100" placeholder="Caption/Title (Optional)">
                    </div>
                    <div class="mb-3">
                        <label for="post-image" class="form-label">Image</label>
                        <input type="file" name="post-image" id="post-image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-end align-items-center">
                        <button class="btn btn-dark m-0">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Video Modal -->
<div class="modal fade" id="postVideo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Share Videos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('post.share.video') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="post-title" class="form-control" id="post-title" minlength="5" maxlength="100" placeholder="Caption/Title (Optional)">
                    </div>
                    <div class="mb-3">
                        <label for="post-video" class="form-label">Video</label>
                        <input type="file" name="post-video" id="post-video" class="form-control" accept="video/*" required>
                    </div>
                    <div class="mb-3 d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-dark m-0">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection