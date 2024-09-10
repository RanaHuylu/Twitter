@extends('layouts.layout')
@section('content')
@php
    $isBlocked = auth()->user()->blockedUsers()->where('blocked_user_id', $user->id)->exists();
@endphp
<div class="mb-16">
    <!-- Top -->
    <div class="z-10 bg-black w-full flex flex-row border-b border-zinc-700">
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
            <p class="text-white ml-4"> @ {{ $user->name }} - {{ $user->email }}</p>
        </div>
    </div>
    <!-- Back Image -->
    <div class="">
        <img src="{{ $user->background_image ? asset('storage/' . $user->background_image) : asset('images/fon.jpg') }}" alt="" class="h-72 w-full">
    </div>
    <div class="relative ml-4 ">
        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/profile.png') }}" alt="" class="rounded-full size-32 outline outline-4 -top-20 absolute max-[500px]:size-24">
        <div class="flex justify-end mt-3 mr-4 space-x-5 text-white max-[500px]:justify-start max-[500px]:pt-10">
            <i class="material-icons outline outline-offset-2 outline-1 rounded-full">more_horiz</i>
            <i class="material-icons outline outline-offset-2 outline-1 rounded-full">mail</i>
            <i class="material-icons outline outline-offset-2 outline-1 rounded-full">notifications</i>
            @if (auth()->check() && auth()->user()->id !== $user->id)
                <a href="{{ route('profile.index', ['id' => $user->id]) }}" class="material-icons block outline outline-offset-2 outline-1 rounded-full block-button" data-user-id="{{ $user->id }}">block</a>
            @endif
            @if(auth()->check() && auth()->user()->id === $user->id)
            <a href="{{ route('profile.edit') }}">
                <button class="border border-white rounded-full px-4">
                    Profili Düzenle
                </button>
            </a>
            @else
                @if ($isBlocked)
                    <form action="{{ route('unblock.user', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="border border-white rounded-full px-4">
                            Engeli Kaldır
                        </button>
                    </form>
                @else
                    @if(auth()->user()->following()->where('followed_id', $user->id)->exists())
                        <button class="border border-white rounded-full px-4" onclick="event.preventDefault(); document.getElementById('unfollow-form').submit();">
                            Takibi Bırak
                        </button>
                        <form id="unfollow-form" action="{{ route('unfollow', $user->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @else
                        <form action="{{ route('follow', ['user' => $user->id]) }}" method="POST">
                            @csrf
                            @if ($user->is_private)
                                <button type="submit" class="border border-white rounded-full px-4">
                                    İstek Gönderildi
                                </button>
                            @else
                                <button type="submit" class="border border-white rounded-full px-4">
                                    Takip Et
                                </button>
                            @endif
                        </form>
                    @endif
                @endif
            @endif
        </div>
        <div class="mt-12 text-white">
            <p>{{ $user->name }}</p>
            <p>@ {{ $user->name }}</p>
            <p>{{$user->description}}</p>
            <p><i class="material-icons text-zinc-800 mr-2">calendar_month</i>{{ $user->created_at->format('d/m/Y') }}</p>
            <p>{{ $user->following()->count() }} Takip Edilen  - {{ $user->followers()->count() }} Takipçi</p>
        </div>
        <div class="flex flex-row border-b border-zinc-700 -ml-4 mt-4">
                    <div class="flex basis-1/2 hover:bg-zinc-900 h-16 justify-center items-center">
                        <input id="gonderi" class="peer/gonderi hidden" type="radio" name="status" checked />
                        <label for="gonderi"
                            class="peer-checked/gonderi:border-cyan-700 text-white text-xl border-b-4 border-transparent">Gönderiler</label>
                    </div>
                    <div class="flex basis-1/2 hover:bg-zinc-900 h-16 justify-center items-center">
                        <input id="yanit" class="peer/yanit hidden" type="radio" name="status" />
                        <label for="yanit"
                            class="peer-checked/yanit:border-cyan-700 text-white text-xl border-b-4 border-transparent">Yanıtlar</label>
                    </div>
                    <div class="flex basis-1/2 hover:bg-zinc-900 h-16 justify-center items-center">
                        <input id="media" class="peer/media hidden" type="radio" name="status"/>
                        <label for="media"
                            class="peer-checked/media:border-cyan-700 text-white text-xl border-b-4 border-transparent">Medya</label>
                    </div>
                </div>
    </div>

    <!-- Akış -->
        <div>
            @foreach($posts as $post)
                <x-post :post="$post" />
            @endforeach
        </div>



</div>
@vite('resources/js/blockUser.js')
@endsection
