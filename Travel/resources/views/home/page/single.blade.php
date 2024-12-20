@extends('layouts.app') 
@section('content')
<style>
    .post-content img {
        max-width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: contain;
    }

    .like-icon {
        cursor: pointer;
        color: gray;
    }

    .liked {
        color: blue;
    }

    #comment-list {
        max-height: 500px;
        overflow-y: auto;
    }

    .scroll::-webkit-scrollbar {
        width: 8px;
    }

    .scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .scroll::-webkit-scrollbar-thumb {
        background-color: #4a90e2;
        border-radius: 10px;
        border: 2px solid #f1f1f1;
    }

    .scroll::-webkit-scrollbar-thumb:hover {
        background-color: #3c7dc4;
    }

    .notification-items {
        max-height: 350px;
        overflow-y: auto;
    }

    .menu-button {
        cursor: pointer;
    }

    .menu {
        z-index: 10;
    }

    .menu a {
        display: block;
        padding: 8px 16px;
        color: #4A5568;
        text-decoration: none;
    }

    .menu a:hover {
        background-color: #EDF2F7;
    }

    .star {
        font-size: 30px;
        color: #ccc;
        /* Màu mặc định của sao */
        cursor: pointer;
        transition: color 0.3s;
    }

    .star:hover,
    .star.selected {
        color: #ffcc00;
    }

    .rated {
        color: #ffcc00;
    }

    .bookmark-icon {
        color: gray;
    }

    .bookmark-icon.bookmarked {
        color: gold;
    }
</style>
<!-- Header Start -->
<div class="container-fluid page-header">
    <div class="container">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-4 text-white text-uppercase">Blog Detail</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Blog Detail</p>
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


<!-- Blog Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <!-- Blog Detail Start -->
                <div class="pb-3">
                    <div class="blog-item">
                        <div class="position-relative">
                            @if (!empty($blog->image_url))
                                <img class="img-fluid w-100" src=" {{ asset('img/' . $blog->image_url) }}" alt="">
                            @else
                                <img class="img-fluid w-100" src=" {{ asset('img/undefined.jpg') }}" alt="">
                            @endif
                            <div class="blog-date">
                                <h6 class="font-weight-bold mb-n1">{{ $blog->created_at->format('d') }}</h6>
                                <small class="text-white text-uppercase">{{ $blog->created_at->format('M') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white mb-3" style="padding: 30px;">
                        <div class="d-flex mb-3">
                            <a class="text-primary text-uppercase text-decoration-none"
                                href="">{{ $blog->user->name }}</a>
                            <span class="text-primary px-2">|</span>
                            <a class="text-primary text-uppercase text-decoration-none"
                                href="">{{ $blog->category->name }}</a>
                        </div>
                        <h2 class="mb-3 d-flex justify-content-between align-items-center">
                            {{ $blog->title }}
                            @if (auth()->check() && auth()->id() === $blog->user_id)
                                <div class="relative">
                                    <button class="menu-button text-gray-500 focus:outline-none" onclick="toggleMenu(this)">
                                        &#8226;&#8226;&#8226;
                                    </button>
                                    <!-- Menu chỉnh sửa và xóa -->
                                    <div
                                        class="menu hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg">
                                        <a href="{{ route('blog.editBlog', Crypt::encrypt($blog->id)) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Sửa
                                        </a>
                                        <form id="delete-post-{{ $blog->id }}"
                                            action="{{ route('blog.destroyBlog', $blog->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button type="button" onclick="confirmDelete('{{ $blog->id }}')"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            Xóa
                                        </button>

                                    </div>
                                </div>
                            @endif
                        </h2>
                        <div class="post-content">
                            {!! $blog->content !!}
                        </div>
                        <div class="d-flex align-items-center mt-4">
                            <div class="mr-3">
                                <span id="like-button"
                                    class="like-icon {{ $blog->likes->contains(auth()->user()) ? 'liked' : '' }}"
                                    data-post-id="{{ $blog->id }}" data-csrf-token="{{ csrf_token() }}">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span id="like-count">{{ $blog->like_count }}</span>
                                </span>
                            </div>
                            <!-- <div class="mr-3">
                                <i class="fas fa-comments"></i> <span>{{ $blog->comment_count }}</span>
                            </div> -->
                            <div>
                                <i class="fas fa-eye"></i> <span>{{ $blog->view_count }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-4">
                        <div class="mr-3 d-flex">
                            <button id="bookmark-button"
                                class="bookmark-icon {{ $blog->bookmarks->contains('user_id', auth()->id()) ? 'bookmarked' : '' }}"
                                data-post-id="{{ $blog->id }}" data-csrf-token="{{ csrf_token() }}">
                                <i class="fas fa-bookmark"></i>
                            </button>
                        </div>
                    </div>
                    <div class="rating">
                        <form id="rating-form">
                            @csrf
                            <label for="rating">Rate</label>
                            <span class="star {{ $userRating && $userRating->rating >= 1 ? 'rated' : '' }}"
                                data-value="1" data-post-id="{{ $blog->id }}">&#9733;</span>
                            <span class="star {{ $userRating && $userRating->rating >= 2 ? 'rated' : '' }}"
                                data-value="2" data-post-id="{{ $blog->id }}">&#9733;</span>
                            <span class="star {{ $userRating && $userRating->rating >= 3 ? 'rated' : '' }}"
                                data-value="3" data-post-id="{{ $blog->id }}">&#9733;</span>
                            <span class="star {{ $userRating && $userRating->rating >= 4 ? 'rated' : '' }}"
                                data-value="4" data-post-id="{{ $blog->id }}">&#9733;</span>
                            <span class="star {{ $userRating && $userRating->rating >= 5 ? 'rated' : '' }}"
                                data-value="5" data-post-id="{{ $blog->id }}">&#9733;</span>
                        </form>
                        <p>Average Rating <span
                                id="average-rating">{{ number_format($blog->averageRating(), 1) }}</span></p>
                    </div>
                </div>
                <!-- Blog Detail End -->

                <!-- Comment List Start -->
                <div class="max-w-4xl mx-auto p-6">
                    <!-- Comment Form Start -->
                    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                        <h4 class="text-2xl font-bold mb-6 tracking-wide">Leave a comment</h4>
                        <form id="comment-form" class="space-y-4" data-post-id="{{ $blog->id }}">
                            @csrf
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message
                                    *</label>
                                <textarea id="message" name="message" rows="5" placeholder="Your message" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full md:w-auto px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Leave a comment
                            </button>
                        </form>
                    </div>
                    <!-- Comment Form End -->
                    <!-- Comment List Start -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h4 class="text-2xl font-bold mb-6 tracking-wide">{{ $comments->count() }} Comments</h4>

                        <div class="space-y-6 scroll" id="comment-list">
                            @foreach ($comments as $comment)
                                <div class="flex space-x-4" data-comment-id="{{ $comment->id }}">
                                    <div class="flex-shrink-0">
                                        @if (isset($comment->user->profile->avatar) && file_exists(public_path('img/profile/avatar/' . $comment->user->profile->avatar)))
                                            {{-- Avatar Container --}}
                                            <img src="{{ asset('img/profile/avatar/' . $comment->user->profile->avatar) }}"
                                                alt="User Avatar" class="w-12 h-12 rounded-full">
                                        @else
                                            {{-- Default Avatar --}}
                                            <img src="{{ asset('img/profile/avatar.png') }}" alt="User Avatar"
                                                class="w-12 h-12 rounded-full">
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex items-center mb-1 justify-between">
                                            <div>
                                                <h6 class="font-semibold mr-2">{{ $comment->user->name }}</h6>
                                                <small
                                                    class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <!-- Nút menu 3 chấm -->
                                            @if (auth()->check() && auth()->id() === $comment->user_id)
                                                <div class="relative">
                                                    <button class="menu-button text-gray-500 focus:outline-none"
                                                        onclick="toggleMenu(this)">
                                                        &#8226;&#8226;&#8226;
                                                    </button>
                                                    <!-- Menu chỉnh sửa và xóa -->
                                                    <div
                                                        class="menu hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg">
                                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 update-comment"
                                                            onclick="editComment(this, '{{ $comment->id }}')">Sửa</a>
                                                        <a
                                                            class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 delete-comment">Xóa</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <p class="text-gray-700 mb-3">{{ $comment->content }}</p>
                                        <button
                                            class="reply-btn px-3 py-1 text-sm border border-indigo-500 text-indigo-500 font-semibold rounded-md hover:bg-indigo-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            Reply
                                        </button>
                                        <div class="reply-form hidden mt-4">
                                            <textarea
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                rows="3" placeholder="Write your reply..."></textarea>
                                            <button
                                                class="submit-reply mt-2 px-3 py-1 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                Submit Reply
                                            </button>
                                        </div>

                                        <!-- Display Replies -->
                                        <div class="replies mt-4 ml-6 space-y-4">
                                            @foreach ($comment->replies as $reply)
                                                <div class="flex space-x-4" data-reply-id="{{ $reply->id }}">
                                                    <div class="flex-shrink-0">
                                                        @if (isset($comment->user->profile->avatar) && file_exists(public_path('img/profile/avatar/' . $comment->user->profile->avatar)))
                                                            {{-- Avatar Container --}}
                                                            <img src="{{ asset('img/profile/avatar/' . $comment->user->profile->avatar) }}"
                                                                alt="User Avatar" class="w-12 h-12 rounded-full">
                                                        @else
                                                            {{-- Default Avatar --}}
                                                            <img src="{{ asset('img/profile/avatar.png') }}" alt="User Avatar"
                                                                class="w-12 h-12 rounded-full">
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div class="flex items-center mb-1 justify-between">
                                                            <div>
                                                                <h6 class="font-semibold mr-2">{{ $reply->user->name }}</h6>
                                                                <small
                                                                    class="text-gray-500">{{ $reply->created_at->diffForHumans() }}</small>
                                                            </div>
                                                            <!-- Nút menu 3 chấm cho reply -->
                                                            @if (auth()->check() && auth()->id() === $reply->user_id)
                                                                <div class="relative">
                                                                    <button class="menu-button text-gray-500 focus:outline-none"
                                                                        onclick="toggleMenu(this)">
                                                                        &#8226;&#8226;&#8226;
                                                                    </button>
                                                                    <!-- Menu chỉnh sửa và xóa -->
                                                                    <div
                                                                        class="menu hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg">
                                                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 update-reply"
                                                                            onclick="editReply(this, '{{ $reply->id }}')">Sửa</a>
                                                                        <a
                                                                            class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 delete-reply">Xóa</a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <p class="text-gray-700 mb-3">{{ $reply->content }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Comment List End -->


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
                                        <a href="{{ route('blog.show', Crypt::encrypt($notification->data['post_id'])) }}"
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="{{ asset('js/post.js') }}"></script>
@endsection