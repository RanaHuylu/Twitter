<div>
    @if($users->isNotEmpty())
        <h3 class="text-white bg-zinc-700 rounded-t-lg">Kullanıcılar:</h3>
        @foreach ($users as $user)
            <div class="user mb-4">
                <p class="text-white odd:bg-zinc-800 even:bg-zinc-700">
                    <a href="{{ route('profile.index', $user->id) }}" class="text-blue-400 hover:underline">
                       @ {{ $user->name }} - {{ $user->email }}
                    </a>
                </p>
            </div>
        @endforeach
    @endif
</div>
