@extends('layouts.layout')
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-white">Profili Düzenle</h1>

    <form action="{{ route('profile.update' , $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mt-4">
            <label for="profile_image" class="block text-white">Profil Resmi</label>
            <input type="file" id="profile_image" name="profile_image" class="mt-2">
        </div>

        <div class="mt-4">
            <label for="background_image" class="block text-white">Arka Plan Resmi</label>
            <input type="file" id="background_image" name="background_image" class="mt-2">
        </div>

        <div class="mt-4">
            <label for="description" class="block text-white">Açıklama</label>
            <textarea id="description" name="description" class="mt-2 w-full h-32 p-2 border border-gray-300 rounded" placeholder="Buraya profil açıklamanızı yazın...">{{ old('description', auth()->user()->description) }}</textarea>
        </div>

        <div class="mt-4">
            <p class="text-white">Takip Edilen: {{ auth()->user()->following()->count() }}</p>
            <p class="text-white">Takipçi: {{ auth()->user()->followers()->count() }}</p>
        </div>

        <div class="form-group text-white">
            <label for="is_private">Hesabımı Gizli Yap</label>
            <input type="checkbox" id="is_private" name="is_private" value="1" {{ auth()->user()->is_private ? 'checked' : '' }}>
        </div>

        <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">
            Güncelle
        </button>
    </form>
</div>
@endsection
