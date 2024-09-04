<div class="mx-auto">
    <div class="container">
        <!-- LeftSidebar -- > md -->
        <div class="max-md:hidden">
            <div class="flex flex-col gap-4 text-white text-2xl">
                <a href="{{route('index')}}"><img src="{{asset('images/x-white.png')}}" style="height:36px"></a>
                <div>
                    <a href="{{route('index')}}">
                        <i class="material-icons">home</i>
                    <span class="max-xl:hidden">AnaSayfa</span>
                    </a>
                </div>
                <div>
                    <a href="{{ route('search.index') }}">
                        <i class="material-icons">search</i>
                        <span class="max-xl:hidden">Arama</span>
                    </a>
                </div>
                <div>
                    <a href="{{ route('notifications.index') }}" class="btn btn-primary">
                        <i class="material-icons">notifications</i>
                        <span class="max-xl:hidden">Bildirimler</span></a>
                </div>
                <div>
                    <a href="{{ url('').'/'.config('chatify.routes.prefix') }}">
                        <i class="material-icons">mail</i>
                        <span class="max-xl:hidden">Mesajlar</span>
                    </a>
                </div>
                <div>
                    <i class="material-icons">inbox</i>
                    <span class="max-xl:hidden">Grok</span>
                </div>
                <div>
                    <i class="material-icons">bookmark_added</i>
                    <span class="max-xl:hidden">Yer İşaretleri</span>
                </div>
                <div>
                    <i class="material-icons">group</i>
                    <span class="max-xl:hidden">Topluluk</span>
                </div>
                <div>
                    <i class="material-icons">close</i>
                    <span class="max-xl:hidden">Premium</span>
                </div>
                <div>
                    <a href="{{route('profile.index', ['id' => auth()->user()->id])}}">
                        <i class="material-icons">person</i>
                        <span class="max-xl:hidden">Profil</span>
                    </a>
                </div>
                <div>
                    <i class="material-icons text-white text-2xl">more_horiz</i>
                    <span class="max-xl:hidden">Daha Fazlası</span>
                </div>
            </div>
            <button class="bg-cyan-600 hover:bg-cyan-700 rounded-full w-64 h-14 text-xl text-white mt-4 max-xl:hidden">Gönder</button>
            <!-- max-xl modu için çıkış yap alanı -->
            <div class="xl:hidden">
                <div class="dropdown relative">
                    <img src="{{ $profileImage }}" alt="" class="size-9 rounded-full cursor-pointer">
                    <div class="dropdown-content  hidden absolute right-0 mt-2 bg-gray-800 text-white rounded-xl shadow-xl">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 w-24 hover:bg-gray-700">
                            Çıkış Yap
                        </a>
                    </div>
                </div>
            </div>
            <!-- xl modu için çıkış yap alanı -->
            <div class="mt-10 p-6 max-w-72 h-16 hover:bg-zinc-900 rounded-full shadow-xl flex items-center space-x-4 max-xl:hidden">
                <div class="shrink-0">
                    @if(isset($user))
                        <img src="{{ $profileImage }}" alt="" class="size-10 rounded-full">
                    @endif
                </div>
                <div>
                    <div class="text-l font-medium text-white">{{ Auth::user()->name }}</div>
                    <p class="text-slate-500">@({{ Auth::user()->name }})</p>
                </div>
                <div>
                    <div class="dropdown relative">
                        <i class="material-icons text-white ml-20 cursor-pointer">more_horiz</i>
                        <div class="dropdown-content  hidden absolute right-0 mt-2 bg-gray-800 text-white rounded-xl shadow-xl">
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
         <!-- Alt Bar < md -->
         <div class="md:hidden fixed bottom-0 left-0 right-0 bg-black text-white shadow-xl flex justify-around items-center py-2 z-50">
            <div>
                <a href="{{route('index')}}">
                    <i class="material-icons">home</i>
                </a>
            </div>
            <div class="flex flex-col items-center">
                <a href="{{ route('search.index') }}">
                    <i class="material-icons">search</i>
                </a>
            </div>
            <div class="flex flex-col items-center">
                <i class="material-icons">inbox</i>
            </div>
            <div class="flex flex-col items-center">
                <a href="{{ route('notifications.index') }}" class="text-white">
                    <i class="material-icons">notifications</i>
                </a>
            </div>
            <div class="flex flex-col items-center">
                <a href="{{ url('').'/'.config('chatify.routes.prefix') }}" class="text-white">
                    <i class="material-icons">mail</i>
                </a>
            </div>
            <div class="flex flex-col items-center">
                <i class="material-icons">group</i>
            </div>
        </div>
    </div>
</div>

<script>
      //çıkışyap dropdown
      document.addEventListener('DOMContentLoaded', function () {
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(function(dropdown) {
            const dropdownContent = dropdown.querySelector('.dropdown-content');
            const toggleButton = dropdown.querySelector('i, img');

            toggleButton.addEventListener('click', function (event) {
                event.stopPropagation();
                dropdownContent.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!dropdown.contains(event.target)) {
                    dropdownContent.classList.add('hidden');
                }
            });
        });
    });
</script>
