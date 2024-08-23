<div class="mx-auto">
    <div class="container flex ">
        <!-- Sag Sidebar -->
        <div class="flex">
            <div class="container w-full">
                <div class="bg-zinc-800 rounded-full pointer-events-auto fixed">
                    <form id="search-form" action="{{ route('search') }}" method="GET">
                        <button type="submit" class="hidden lg:flex items-center text-sm leading-6 text-slate-400 rounded-md py-1.5 pl-2 pr-3 w-80 h-12">
                            <i class="material-icons text-zinc-600 text-xl">search</i>
                            <input type="text" id="query" name="query" placeholder="Ara..." class="bg-zinc-800 w-full">
                       </button>
                    </form>
                </div>
                <div id="search-results" class="bg-zinc-800 rounded-lg fixed mt-12 w-80">
                    <!--Arama sonuçları burada gözükecek-->
                </div>
                <div class="mt-20 container border border-zinc-800 rounded-lg p-4">
                    <!-- Gündemler -->
                    <span class="text-white text-2xl font-bold">Gündemler</span>
                    <div class="mt-4 hover:bg-zinc-900 rounded-lg">
                        <p class="text-l font-medium text-white">1.Gündem</p>
                        <div class="flex justify-between">
                            <p class="text-slate-500">@kullanıcıadi</p>
                            <i class="material-icons text-white ml-8">more_horiz</i>
                        </div>
                    </div>
                    <div class="mt-4 hover:bg-zinc-900 rounded-lg">
                        <p class="text-l font-medium text-white">2.Gündem</p>
                        <div class="flex justify-between">
                            <p class="text-slate-500">@kullanıcıadi</p>
                            <i class="material-icons text-white ml-8">more_horiz</i>
                        </div>
                    </div>
                    <div class="mt-4 hover:bg-zinc-900 rounded-lg">
                        <p class="text-l font-medium text-white">3.Gündem</p>
                        <div class="flex justify-between">
                            <p class="text-slate-500">@kullanıcıadi</p>
                            <i class="material-icons text-white ml-8">more_horiz</i>
                        </div>
                    </div>
                    <div class="mt-4 hover:bg-zinc-900 rounded-lg">
                        <p class="text-l font-medium text-white">4.Gündem</p>
                        <div class="flex justify-between">
                            <p class="text-slate-500">@kullanıcıadi</p>
                            <i class="material-icons text-white ml-8">more_horiz</i>
                        </div>
                    </div>
                </div>
                <!-- Kimi takip etmeli -->
                <div class="container border border-zinc-800 mt-10 rounded-lg p-4">
                    <span class="text-white text-2xl font-bold">Kimi Takip Etmeli</span>
                    @forelse($suggestedUsers as $user)
                        <div class="mt-4 p-6 h-16 hover:bg-zinc-900 shadow-lg flex justify-between items-center space-x-4">
                            <a href="{{route('profile.index', $user->id)}}">
                            <div class="shrink-0">
                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/profile.png') }}" alt="" class="rounded-full size-10">
                            </div>
                            </a>
                            <div class="">
                                <div class="text-l font-medium text-white">{{ $user->name }}</div>
                                <p class="text-slate-500">@ {{ $user->name }}</p>
                            </div>
                            <div></div>
                            <div class="">
                                <form action="{{ route('follow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-white rounded-full w-24 p-2">Takip Et</button>
                                </form>
                            </div>
                        </div>
                        @empty
        <li>Takip edilecek kullanıcı bulunamadı.</li>
                        @endforelse
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    //search
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = document.getElementById('query').value;

        fetch(`/search?query=${query}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('search-results').innerHTML = `
                ${data.posts}
                ${data.users}
            `;
            document.getElementById('search-results').style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Dışarı tıklayınca arama sonuçlarını gizle
    document.addEventListener('click', function(event) {
        const searchResults = document.getElementById('search-results');
        const searchForm = document.getElementById('search-form');

        if (!searchForm.contains(event.target) && !searchResults.contains(event.target)) {
            searchResults.style.display = 'none';
        }
    });
</script>
