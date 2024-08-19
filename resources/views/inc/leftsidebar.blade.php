<div class="mx-auto">
    <div class="container flex">
        <!-- LeftSidebar -->
        <div class="">
            <div class="flex flex-col gap-4 text-white text-2xl">
                <a href="{{route('index')}}"><img src="{{asset('images/x.jpg')}}" style="height:36px"></a>
                <div>
                    <a href="{{route('index')}}">
                        <i class="material-icons">home</i>
                    <span>AnaSayfa</span>
                    </a>
                </div>
                <div>
                    <i class="material-icons">search</i>
                    <span>Arama</span>
                </div>
                <div>
                    <a href="{{ route('follow.requests') }}" class="btn btn-primary">
                        <i class="material-icons">notifications</i>
                        <span>Bildirimler</span></a>
                </div>
                <div>
                    <i class="material-icons">mail</i>
                    <span>Mesajlar</span>
                </div>
                <div>
                    <i class="material-icons">inbox</i>
                    <span>Grok</span>
                </div>
                <div>
                    <i class="material-icons">bookmark_added</i>
                    <span>Yer İşaretleri</span>
                </div>
                <div>
                    <i class="material-icons">group</i>
                    <span>Topluluk</span>
                </div>
                <div>
                    <i class="material-icons">close</i>
                    <span>Premium</span>
                </div>
                <div>
                    <a href="{{route('profile.index', ['id' => auth()->user()->id])}}">
                        <i class="material-icons">person</i>
                        <span>Profil</span>
                    </a>

                </div>
                <div>
                    <i class="material-icons text-white text-2xl">more_horiz</i>
                    <span>Daha Fazlası</span>
                </div>
            </div>
            <button
                class="bg-cyan-600 hover:bg-cyan-700 rounded-full w-64 h-14 text-xl text-white mt-4">Gönder</button>
            <div class="mt-10 p-6 max-w-72 h-16 hover:bg-zinc-900 rounded-full shadow-lg flex items-center space-x-4">
                <div class="shrink-0">
                    @if(isset($user))
                    <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/profile.png') }}" alt="" class="size-10 rounded-full">
                 @endif
                </div>
                <div>
                    <div class="text-l font-medium text-white">{{ Auth::user()->name }}</div>
                    <p class="text-slate-500">@({{ Auth::user()->name }})</p>
                </div>
                <div>
                    <div class="dropdown relative">
                        <i class="material-icons text-white ml-20 cursor-pointer">more_horiz</i>
                        <div class="dropdown-content  hidden absolute right-0 mt-2 bg-gray-800 text-white rounded-lg shadow-lg">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 w-24 hover:bg-gray-700">
                                Çıkış Yap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
      //çıkışyap dropdown
      document.addEventListener('DOMContentLoaded', function () {
            const dropdown = document.querySelector('.dropdown');
            const dropdownContent = dropdown.querySelector('.dropdown-content');
            const toggleButton = dropdown.querySelector('i');

            toggleButton.addEventListener('click', function () {
                dropdownContent.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!dropdown.contains(event.target)) {
                    dropdownContent.classList.add('hidden');
                }
            });
        });
</script>
