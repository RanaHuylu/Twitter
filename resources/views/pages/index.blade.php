@extends('layouts.layout')
@section('content')

    <div class="mx-auto">
        <div class="container flex">
           <!-- Ana Bölüm -->
            <div class="border-x border-zinc-700">
                <div class="z-10 fixed bg-slate-950 w-[39%] flex flex-row border-b border-zinc-700">
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
                <div class="mt-16 flex border-b border-zinc-700">
                    <div class="container p-4">
                        <div class="flex">
                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/profile.png') }}" alt="" class="size-10 rounded-full">
                            <form action="{{ route('posts') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <textarea class="w-[33rem] h-16 p-4 text-white bg-black focus:outline-none focus:ring-2 border-b border-zinc-700" name="content" placeholder="Neler oluyor?" required></textarea>
                                <input type="file" name="image" id="image" class="hidden">
                                <div class="flex justify-between mt-4">
                                    <div class="flex flex-row ml-8 space-x-2">
                                        <label for="image" class="cursor-pointer">
                                            <div class="relative group">
                                                <i class="material-icons text-cyan-600 text-xl">image</i>
                                                <span
                                                    class="absolute left-1/2 transform -translate-x-1/2 -translate-y-full mt-2 w-max bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100">
                                                    Medya
                                                </span>
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
                                        <button class="flex justify-end bg-cyan-600 hover:bg-blue-600 text-white px-4 py-2 rounded-full focus:outline-none" type="submit">Gönder</button>
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
@endsection
