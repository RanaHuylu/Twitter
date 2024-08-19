@extends('layouts.layout')
@section('content')
    <!-- Top -->
    <div class="z-10 fixed bg-slate-950 w-[42.7%] flex flex-row border border-zinc-700">
        <div class="flex ml-2 h-16 justify-center items-center">
            <div class="relative group hover:bg-zinc-900 rounded-full">
                <a href="{{ route('index') }}">
                    <i class="material-icons text-white text-xl">arrow_back</i>
                </a>
                <span
                    class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">
                    Geri
                </span>
            </div>
        </div>
    </div>
    <div class="container mt-14 mx-auto border-x border-zinc-800">

        <div class="post p-4" data-post-id="{{ $post->id }}">
            <div class="flex pt-4 px-4 space-x-2">
                <div class="">
                    <a href="{{route('profile.index', $post->user->id)}}">
                        <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : asset('images/profile.png') }}" alt="" class="size-10 rounded-full">
                    </a>
                </div>
                <div class="w-full ml-3 overflow-hidden max-w-lg">
                    <span class="text-white">{{ $post->user->name }} (@ {{ $post->user->name }})</span>
                </div>
            </div>

            <div class="container relative flex flex-col px-10 py-2 ml-4 max-w-xl">
                <div><p class="text-white mt-2">{{ $post->content }}</p></div>
                <div class="flex justify-center items-center">
                    @foreach ($post->postMedia as $media)
                        @if ($media->media_type == 'image')
                            <img src="{{ asset('storage/' . $media->media_path) }}" alt="Uploaded Image" class="mt-4 border rounded-lg border-zinc-700">
                        @elseif ($media->media_type == 'video')
                            <video controls class="mt-4 border rounded-lg border-zinc-700">
                                <source src="{{ asset('storage/' . $media->media_path) }}" type="video/mp4">
                            </video>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Yorumlar -->
            <div class="comments-section mt-4">
                <h3 class="text-white text-xl">Yorumlar</h3>
                <div class="rounded-lg p-4 border-b border-zinc-700">
                    @foreach($post->comments as $comment)
                    <div class="comment border-b border-zinc-700 py-2">
                        <p class="text-white">{{ $comment->body }}</p>
                        <small class="text-gray-500">Yazan: {{ $comment->user->name }}</small>
                    </div>
                @endforeach
                </div>


                <!-- Yorum Ekleme Formu -->
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea class="w-[33rem] h-16 p-4 text-white bg-black focus:outline-none focus:ring-2 border-b border-zinc-700" name="body" placeholder="Yorumunuzu yazın"></textarea>
                    <button type="submit" class="text-white">Yorum Gönder</button>
                </form>
            </div>
        </div>
    </div>

@endsection
