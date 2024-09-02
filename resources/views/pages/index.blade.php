@extends('layouts.layout')
@section('content')

    <div class="mx-auto mb-16">
        <div class="container flex">
           <!-- Ana Bölüm -->
            <div class="w-full">
                <!-- topbar -- < md -->
                <div class="md:hidden ml-4 mt-2">
                    <div class="flex flex-row items-center justify-between">
                        <div><img src="{{ $profileImage }}" alt="" class="size-9 rounded-full cursor-pointer" id="profileImage"></div>
                        <div><a href="{{route('index')}}"><img src="{{asset('images/x.jpg')}}" style="height:36px" class=""></a></div>
                        <div></div>
                    </div>
                    <!-- Sidebar -->
                    <div id="sidebar" class="fixed top-0 left-0 h-full bg-black text-white z-50 transform -translate-x-full transition-transform duration-300 shadow-lg shadow-blue-500/50">
                        <div class="flex justify-end p-4">
                            <i id="closeSidebar" class="material-icons cursor-pointer">close</i>
                        </div>
                        <div class="p-4">
                            <a href="{{ route('profile.index', ['id' => auth()->user()->id]) }}" class="flex items-center space-x-2 p-2 hover:bg-gray-700 rounded">
                                <i class="material-icons">person</i>
                                <span>Profil</span>
                            </a>
                            <a href="#" class="flex items-center space-x-2 p-2 hover:bg-gray-700 rounded">
                                <i class="material-icons">star</i>
                                <span>Premium</span>
                            </a>
                            <a href="#" class="flex items-center space-x-2 p-2 hover:bg-gray-700 rounded">
                                <i class="material-icons">bookmark_added</i>
                                <span>Yer İşaretleri</span>
                            </a>
                            <a href="#" class="flex items-center space-x-2 p-2 hover:bg-gray-700 rounded">
                                <i class="material-icons">group</i>
                                <span>Topluluk</span>
                            </a>
                            <a href="#" class="flex items-center space-x-2 p-2 hover:bg-gray-700 rounded">
                                <i class="material-icons">inbox</i>
                                <span>Grok</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center space-x-2 p-2 hover:bg-gray-700 rounded">
                                <i class="material-icons">logout</i>
                                <span>Çıkış Yap</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="z-10 size-auto bg-black flex flex-row border-b border-zinc-700">
                    <div class="flex basis-1/2 hover:bg-zinc-900 h-16 justify-center items-center">
                        <input id="draft" class="peer/draft hidden" type="radio" name="status" checked />
                        <label for="draft"
                            class="peer-checked/draft:border-cyan-700 text-white text-xl border-b-4 border-transparent">Sana
                            Özel</label>
                    </div>
                    <div class="flex basis-1/2 hover:bg-zinc-900 h-16 justify-center items-center">
                        <input id="published" class="peer/published hidden" type="radio" name="status" />
                        <label for="published"
                            class="peer-checked/published:border-cyan-700 text-white text-xl border-b-4 border-transparent">Takip
                            Edilenler</label>
                    </div>
                    <!--   <div class="hidden peer-checked/draft:block text-white">Drafts are only visible to administrators.</div>-->
                    <!-- w-full h-16 p-4 text-white bg-black focus:outline-none focus:ring-2 border-b border-zinc-700  <div class="hidden peer-checked/published:block text-white">Your post will be publicly visible on your site.</div>-->
                </div>
                <div class="flex border-b border-zinc-700">
                    <div class="container p-4">
                        <div class="flex">
                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/profile.png') }}" alt="" class="size-10 rounded-full">
                            <form action="{{ route('posts') }}" method="POST" enctype="multipart/form-data" class="w-full ml-2">
                                @csrf
                                <textarea class="w-full h-16 text-white bg-black focus:outline-none focus:ring-2 border-b border-zinc-700" name="content" placeholder="Neler oluyor?"></textarea>
                                <input type="file" name="image" id="image" class="hidden">
                                <input type="file" name="video" id="video" class="hidden">
                                <div class="mt-4">
                                    <div class="flex flex-row relative space-x-2 max-[400px]:-ml-14 max-[400px]:justify-start">
                                        <label for="image" class="cursor-pointer">
                                            <div class="relative group">
                                                <i class="material-icons text-cyan-600">image</i>
                                                <span
                                                    class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">
                                                    Medya
                                                </span>
                                            </div>
                                        </label>
                                        <label for="video" class="cursor-pointer">
                                            <div class="relative group">
                                                <i class="material-icons text-cyan-600 text-xl">video_library</i>
                                                <span class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">Video</span>
                                            </div>
                                        </label>
                                        <div class="relative group">
                                            <i class="material-icons text-cyan-600 text-xl">gif_box</i>
                                            <span
                                                class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">
                                                GIF
                                            </span>
                                        </div>
                                        <div class="relative group">
                                            <i class="material-icons text-cyan-600 text-xl">sort</i>
                                            <span
                                                class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">
                                                Anket
                                            </span>
                                        </div>
                                        <div class="relative group">
                                            <i class="material-icons text-cyan-600 text-xl">mood</i>
                                            <span
                                                class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">
                                                Emoji
                                            </span>
                                        </div>
                                        <div class="relative group">
                                            <i class="material-icons text-cyan-600 text-xl">today</i>
                                            <span
                                                class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">
                                                Planla
                                            </span>
                                        </div>
                                        <div class="relative group">
                                            <i class="material-icons text-cyan-600 text-4xl">location_on</i>
                                            <span
                                                class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">
                                                Konum
                                            </span>
                                        </div>
                                        <button class="absolute right-0 bg-cyan-600 hover:bg-blue-600 text-white px-4 py-2 rounded-full focus:outline-none max-[400px]:text-sm" type="submit">Gönder</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--akış-->
                <div>
                    @foreach($posts as $post)
                        <x-post :post="$post" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const profileImage = document.getElementById('profileImage');
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        // Sidebar'ı açma
        profileImage.addEventListener('click', function () {
            sidebar.classList.remove('-translate-x-full');
        });

        // Sidebar'ı kapatma
        function closeMenu() {
            sidebar.classList.add('-translate-x-full');
        }

        closeSidebar.addEventListener('click', closeMenu);
    });
    </script>
@endsection
