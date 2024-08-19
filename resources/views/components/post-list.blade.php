<div>
    @if($posts->isNotEmpty())
    <h3 class="text-white bg-zinc-700 rounded-t-lg">Postlar:</h3>
        @foreach ($posts as $post)
            <div class="post odd:bg-zinc-700 even:bg-zinc-800" id="post-{{ $post->id }}">
                <h2 class="text-white ml-2">@ {{ $post->user->name }}</h2>
                <a href="{{$post->id}}" class="view-post text-white ml-2" data-post-id="{{ $post->id }}">{{ $post->content }}</a>
            </div>
        @endforeach
    @endif
</div>

