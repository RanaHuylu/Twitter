@extends('layouts.layout')
@section('content')
<div class="container mt-4 px-8">
    <h2 class="text-white">Arama Sonuçları:</h2>
    <form action="{{ route('search.index') }}" method="GET">
        <input type="text" name="query" value="{{ request('query') }}" placeholder="Ara...">
        <button type="submit">Ara</button>
    </form>

    @include('components.post-list', ['posts' => $posts])
    @include('components.user-list', ['users' => $users])
</div>
<script>
    //search
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const query = document.getElementById('query').value;

        fetch(`/searchpage?query=${query}`, {
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
</script>
@endsection
