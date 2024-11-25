@extends('layouts.app')
@section('content')

<div class="bg-zinc-900 p-5">
    <h1 class="text-2xl font-bold mb-4">List of saved articles</h1>
    <div class="space-y-4">
        @forelse($bookmarks as $blog)
            <article class="rounded-lg p-4">
                <div class="flex gap-4">
                    @if(!empty($blog->image_url))
                    <img src="{{asset('img/' . $blog->image_url)}}" alt="Post thumbnail"
                        class="w-48 h-48 rounded-lg object-cover" />
                    @else
                    <img src="{{asset('img/undefined.jpg')}}"" alt="Post thumbnail"
                        class="w-48 h-48 rounded-lg object-cover" />
                    @endif
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold mb-2">
                            {{ $blog->title }}
                        </h2>
                        <div class="flex items-center gap-2 text-sm text-zinc-400 mb-4">
                            <span>Saved from post by<b>{{ $blog->user->name ?? 'Người dùng ẩn danh' }}</b></span>
                        </div>
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('bookmarks.remove', $blog->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="rounded-md py-2 px-4 flex items-center bg-primary">
                                    Unsave
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <!-- Hiển thị khi không có bài viết nào được lưu -->
            <p class="text-zinc-400">Bạn chưa lưu bài viết nào.</p>
        @endforelse
    </div>
</div>
@endsection