@extends('layouts.app')
@section('content')
<link href="{{asset('css/create_blog.css') }}" rel="stylesheet">

<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Blog</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Blog</p>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- Booking Start -->
<div class="container-fluid booking mt-5 pb-5">
    <div class="container pb-5">
        <div class="bg-light shadow" style="padding: 30px;">
            <div class="row align-items-center" style="min-height: 60px;">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <select class="custom-select px-4" style="height: 47px;">
                                    <option selected>Destination</option>
                                    <option value="1">Destination 1</option>
                                    <option value="2">Destination 1</option>
                                    <option value="3">Destination 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <div class="date" id="date1" data-target-input="nearest">
                                    <input type="text" class="form-control p-4 datetimepicker-input"
                                        placeholder="Depart Date" data-target="#date1" data-toggle="datetimepicker" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <div class="date" id="date2" data-target-input="nearest">
                                    <input type="text" class="form-control p-4 datetimepicker-input"
                                        placeholder="Return Date" data-target="#date2" data-toggle="datetimepicker" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mb-md-0">
                                <select class="custom-select px-4" style="height: 47px;">
                                    <option selected>Duration</option>
                                    <option value="1">Duration 1</option>
                                    <option value="2">Duration 1</option>
                                    <option value="3">Duration 1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block" type="submit"
                        style="height: 47px; margin-top: -2px;">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Booking End -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="post-creator d-flex align-items-center p-3">
            <a href="#" role="link">
                <img src="https://via.placeholder.com/40" alt="Hình đại diện" class="profile-pic">
            </a>
            <div>
                <h3 class="mb-0">New Posts</h3>
                <div class="user-prompt">
                    <a href="{{ route('create.post') }}">What are you thinking?</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Blog Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="row pb-3">
                    @if($posts->isNotEmpty())
                        @foreach($posts as $post)
                            <div class="col-md-6 mb-4 pb-2">
                                <div class="blog-item-post blog-item">
                                    <div class="position-relative">
                                        @if (!empty($post->image_url))
                                            <img class="img-post w-100" src="{{asset('img/' . $post->image_url)}}" alt="">
                                        @else
                                            <img class="img-post w-100" src="{{asset('img/undefined.jpg')}}" alt="">
                                        @endif
                                        <div class="blog-date">
                                            <h6 class="font-weight-bold mb-n1">{{ $post->created_at->format('d') }}</h6>
                                            <small
                                                class="text-white text-uppercase">{{ $post->created_at->format('M') }}</small>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4">
                                        <div class="d-flex mb-2">
                                            <a class="text-primary text-uppercase text-decoration-none name-post"
                                                href="">{{ $post->user->name }}</a>
                                            <span class="text-primary px-2">|</span>
                                            <a class="text-primary text-uppercase text-decoration-none name-post"
                                                href="">{{ $post->category->name }}</a>
                                        </div>
                                        <a class="h5 m-0 text-decoration-none"
                                            href="{{ route('blog.show', Crypt::encrypt($post->id)) }}">{{ Str::limit($post->title, limit: 60, end: '...') }}</a>
                                        <p class="mt-2">{{ Str::limit(strip_tags($post->content), 100, '...') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info">There are no articles matching your search.</div>
                    @endif

                    <!-- Phân trang -->
                    @if($posts->isNotEmpty())
                        <div class="col-12">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-lg justify-content-center bg-white mb-0"
                                    style="padding: 30px;">
                                    <!-- Previous Link -->
                                    @if ($posts->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $posts->previousPageUrl() }}" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Page Number Links -->
                                    @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                        <li class="page-item {{ $posts->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $posts->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    <!-- Next Link -->
                                    @if ($posts->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $posts->nextPageUrl() }}" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4 mt-5 mt-lg-0">
                <!-- Notification -->
                <div class="w-[380px] bg-zinc-900 rounded-lg shadow-md">
                    <!-- Header -->
                    <div class="p-4 flex items-center justify-between border-b border-zinc-800">
                        <h2 class="text-xl font-semibold">Notifications</h2>
                    </div>

                    <!-- Tabs -->
                    <!-- <div class="flex space-x-2 p-4 bg-transparent">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Tất cả</button>
                        <button class="bg-zinc-800 px-4 py-2 rounded-lg hover:bg-zinc-700">Chưa đọc</button>
                    </div> -->

                    <!-- Notification Items -->
                    <div id="notification-list" class="space-y-4 p-2 notification-items scroll">
                        @if ($notifications->isEmpty()) <!-- Kiểm tra nếu không có thông báo -->
                            <div class="text-center text-gray-500">
                                There are currently no notifications.
                            </div>
                        @else
                            @foreach ($notifications as $notification)
                                <div class="flex items-start gap-2 p-2 hover:bg-zinc-800 rounded-lg">
                                    <div class="h-12 w-12 rounded-full bg-gray-400 flex items-center justify-center text-white">
                                        @if (isset($notification->data['avatar']) && $notification->data['avatar'] && file_exists(public_path('img/profile/avatar/' . $notification->data['avatar'])))
                                            <img src="{{ asset('img/profile/avatar/' . $notification->data['avatar']) }}"
                                                alt="Avatar" class="h-12 w-12 rounded-full">
                                        @else
                                            <img src="{{ asset('img/profile/avatar.png') }}" alt="User Avatar"
                                                class="h-12 w-12 rounded-full">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm">
                                            <span class="font-semibold">{{ $notification->data['user_name'] }}</span>
                                            {{ $notification->data['message'] }}
                                        </p>
                                        <p class="text-xs text-zinc-400 mt-1">{{ $notification->created_at->diffForHumans() }}
                                        </p>
                                        <a href="{{ route('posts.show', $notification->data['post_id']) }}"
                                            class="text-blue-500 hover:underline">Xem bài viết</a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <!--     <button class="w-full py-3 text-sm text-zinc-400 hover:bg-zinc-800">Xem thông báo trước
                            đó</button> -->
                    </div>
                </div>


                <!-- Search Form -->
                <div class="mb-5">
                    <div class="bg-white" style="padding: 30px;">
                        <div class="input-group">
                            <form class="d-flex" action="{{ route('posts.search') }}" method="GET">
                                <input type="text" name="query" class="form-control p-4" placeholder="Keyword" required>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary border-primary text-white"
                                        style="cursor: pointer;" onclick="this.closest('form').submit();">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </form>
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Category List -->
                <div class="mb-5">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categories</h4>
                    <div class="bg-white" style="padding: 30px;">
                        <ul class="list-inline m-0">
                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                <a class="text-dark" href="{{ route('blog') }}"><i
                                        class="fa fa-angle-right text-primary mr-2"></i>All</a>
                                <span class="badge badge-primary badge-pill">{{ $totalPost }}</span>
                            </li>
                            @foreach ($categories as $category)
                                <li class="mb-3 d-flex justify-content-between align-items-center">
                                    <a class="text-dark"
                                        href="{{ route('category.posts', Crypt::encrypt($category->id)) }}"><i
                                            class="fa fa-angle-right text-primary mr-2"></i>{{ $category->name }}</a>
                                    <span class="badge badge-primary badge-pill">{{ $category->posts_count }}</span>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <!-- Recent Post -->
                <div class="mb-5">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Recent Post</h4>
                    @foreach ($topViewPosts as $post)
                        <a class="d-flex align-items-center text-decoration-none bg-white mb-3"
                            href="{{ route('blog.show', Crypt::encrypt($post->id)) }}">
                            <img class="img-fluid" src="{{ asset('img/' . ($post->image_url ?? 'img/undefined.jpg')) }}"
                                alt="" ; style="width: 50%">
                            <div class="pl-3">
                                <h6 class="m-1">{{ Str::limit($post->title, 60, '...') }}</h6>
                                <small>{{ $post->created_at->format('M d, Y') }}</small>
                            </div>
                        </a>
                    @endforeach

                </div>

                <!-- Tag Cloud -->
                <!-- <div class="mb-5">
                    <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Tag Cloud</h4>
                    <div class="d-flex flex-wrap m-n1">
                        <a href="" class="btn btn-light m-1">Design</a>
                        <a href="" class="btn btn-light m-1">Development</a>
                        <a href="" class="btn btn-light m-1">Marketing</a>
                        <a href="" class="btn btn-light m-1">SEO</a>
                        <a href="" class="btn btn-light m-1">Writing</a>
                        <a href="" class="btn btn-light m-1">Consulting</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<!-- Blog End -->

@endsection