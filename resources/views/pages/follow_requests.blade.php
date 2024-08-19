@extends('layouts.layout')
@section('content')

<div class="container mt-4">
    <h1 class="text-white">Takip İstekleri</h1>

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

    <div class="container bg-zinc-800 mt-4 rounded-lg">
        <div class="p-4">
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
</div>

@endsection
