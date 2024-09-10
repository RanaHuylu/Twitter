@extends('layouts.layout')
@section('content')

<div class="mt-4 px-8">
    <h1 class="text-white">Bildirimler</h1>

    <h2 class="text-white mt-4">Takip Talepleri</h2>
    @if(session('message'))
        <div class="alert alert-success text-white">
            {{ session('message') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-white">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-zinc-800 rounded-lg">
        <div class="p-4">
            <!-- Takip istekleri -->
            <ul class="list-disc list-inside">
                @forelse($followRequests as $request)
                    <li class="text-white mb-2">
                        <a href="{{route('profile.index', $request->follower->id)}}">
                             @ {{ $request->follower->name }} sizi takip etmek istiyor.
                        </a>
                        <div class="mt-2">
                            <form action="{{ route('follow.accept', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success mr-4">Kabul Et</button>
                            </form>
                            <form action="{{ route('follow.decline', $request->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger ml-4">Reddet</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="text-white">Hiçbir takip isteği yok.</li>
                @endforelse
            </ul>
        </div>

    </div>
    <!-- Etiket bildirimleri -->
    <h2 class="text-white mt-7">Etiket Bildirimleri</h2>
    <div class="bg-zinc-800  rounded-lg">
        <div class="p-4">
            <ul class="list-disc list-inside text-white">
                @foreach($mentions as $mention)
                    <li>
                        {{ $mention->user->name }} seni
                        @if($mention->post_id)
                            <a href="{{ route('post.show', $mention->post_id) }}">bir postta</a>
                        @else
                            <a href="{{ route('mentions.comment', $mention->comment_id) }}">bir yorumda</a>
                        @endif
                        etiketledi.
                        {{ \Carbon\Carbon::parse($mention->created_at)->format('d/m/Y - H:i') }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
