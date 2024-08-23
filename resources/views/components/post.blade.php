@if($post)
    @php
       $canView = $post->user->id === auth()->id() ||
        (!$post->user->is_private && !$post->user->isBlockedBy(auth()->id())) ||
        ($post->user->followers->contains(auth()->user()) && !$post->user->isBlockedBy(auth()->id()));
    @endphp
    @if($canView)
            <div id="{{ $post->id }}" class="post border-b border-zinc-700 pb-4" data-post-id="{{ $post->id }}">
                <div>
                    <div class="flex pt-4 px-4 space-x-2">
                        <div class="">
                            <a href="{{route('profile.index', $post->user->id)}}">
                                <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : asset('images/profile.png') }}" alt="" class="size-10 rounded-full">
                            </a>
                        </div>
                        <div class="w-full ml-3 overflow-hidden max-w-lg">
                            <span class="text-white">{{ $post->user->name }} @ {{ $post->user->name }}</span>
                        </div>
                        <div class="flex justify-end relative">
                            <div class="relative group">
                                <i class="material-icons text-white text-xl cursor-pointer more-options" data-post-id="{{ $post->id }}">more_horiz</i>
                                <div class="absolute dropdown-menu right-0 hidden bg-black text-white text-xs rounded z-10">
                                    @if(auth()->user()->id === $post->user_id)
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-700 edit-button" data-post-id="{{ $post->id }}">Düzenle</a>
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-700 delete-button" data-post-id="{{ $post->id }}">Sil</a>
                                    @else
                                        <a href="#" class="block px-4 py-2 hover:bg-gray-700 block-button" data-user-id="{{ $post->user_id }}">Kullanıcıyı Engelle</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Düzenleme Formu -->
                    <div id="edit-form-{{ $post->id }}" class="flex justify-center hidden">
                        <form action="{{ route('update.post', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4 text-white">
                                <label for="content-{{ $post->id }}" class="flex items-center">Metin:</label>
                                <textarea id="content" name="content" class="w-[33rem] h-16 p-4 text-white bg-black focus:outline-none focus:ring-2 border-b border-zinc-700">{{ $post->content }}</textarea>
                            </div>
                            <div class="mb-4 text-white">
                                <label for="image-{{ $post->id }}" class="flex items-center">Yeni Resim:</label>
                                <input type="file" id="image" name="image" accept="image/*">
                            </div>
                            <div class="mb-4 text-white">
                                <label for="video-{{ $post->id }}" class="flex items-center">Yeni Video:</label>
                                <input type="file" id="video" name="video" accept="video/*">
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Güncelle</button>
                        </form>
                        <form action="{{ route('delete.post', $post->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Sil</button>
                        </form>
                    </div>
                    <!-- post -->
                    <a href="{{ route('post.show', $post->id) }}" class="block">
                        <div class="container relative flex flex-col px-10 py-2 ml-4 max-w-xl">
                            <div><p class="text-white mt-2">{{ $post->content }}</p></div>
                            <div class="flex justify-center items-center">
                                @foreach ($post->postMedia as $media)
                                    @if ($media->media_type == 'image')
                                        <img src="{{ asset('storage/' . $media->media_path) }}" alt="Uploaded Image" class="mt-4 border rounded-lg border-zinc-700">
                                    @elseif ($media->media_type == 'video')
                                        <video controls class="mt-4 border rounded-lg border-zinc-700">
                                            <source src="{{ asset('storage/' . $media->media_path) }}" type="video/mp4">
                                        </video>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </a>
                    <!-- comment fav ret icons -->
                    <div class="post-actions flex ml-16 text-white">
                        <button class="material-icons"
                                data-post-id="{{ $post->id }}">mode_comment
                        </button>
                        <span class="mr-2" id="comment-count-{{ $post->id }}">{{ $post->comments->count() }}</span>

                        <i class="material-icons">reply</i>
                        <span class="mr-2">186</span>
                        <div id="post-{{ $post->id }}" class="post-container">
                                    <button class="like-button material-icons"
                                            data-post-id="{{ $post->id }}"
                                            data-post-owner-id="{{ $post->user_id }}"
                                            data-current-user-id="{{ auth()->user()->id }}">
                                        <span id="like-icon-{{ $post->id }}" class="{{ $post->isLikedByUser() ? 'text-red-500' : 'text-gray-500' }}">
                                            {{ $post->isLikedByUser() ? 'favorite' : 'favorite_border' }}
                                        </span>
                                    </button>
                                <span class="text-white" id="like-count-{{ $post->id }}">
                                    {{ $post->like_count }}
                                </span>
                        </div>
                        <i class="material-icons ml-2">bar_chart</i>
                        <span class="mr-2">186</span>
                        <i class="material-icons ml-40">bookmark_added</i>
                        <i class="material-icons">upload</i>
                    </div>
                </div>
            </div>
    @endif
@endif
@vite('resources/js/blockUser.js')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let isProcessing = false; // Tüm işlem bayrağı

        // like butonu
        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', function() {
                if (isProcessing) return;
                isProcessing = true;

                const postId = this.getAttribute('data-post-id');
                const postOwnerId = this.getAttribute('data-post-owner-id');
                const currentUserId = this.getAttribute('data-current-user-id');

                if (postOwnerId !== currentUserId) {
                    fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.text();
                        } else {
                            return response.text().then(text => {
                                throw new Error(text);
                            });
                        }
                    })
                    .then(data => {
                        const likeIcon = document.getElementById(`like-icon-${postId}`);
                        const likeCountSpan = document.getElementById(`like-count-${postId}`);
                        const isLiked = likeIcon.textContent.trim() === 'favorite';

                        if (data.includes('Beğeni işlemi başarılı.')) {
                            likeIcon.textContent = isLiked ? 'favorite_border' : 'favorite';
                            likeIcon.className = isLiked ? 'text-gray-500' : 'text-red-500';
                            likeCountSpan.textContent = parseInt(likeCountSpan.textContent) + (isLiked ? -1 : 1);
                        } else {
                            alert("Beğenme işlemi başarısız oldu.");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("Beğenme işlemi başarısız oldu.");
                    })
                    .finally(() => {
                        isProcessing = false; // İşlem bitti
                    });
                } else {
                    alert("Kendi postunuzu beğenemezsiniz.");
                    isProcessing = false; // İşlem bitti
                }
            });
        });

        // post daha-fazlası
        document.querySelectorAll('.more-options').forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                const postId = this.getAttribute('data-post-id');
                const dropdownMenu = this.nextElementSibling;
                const editForm = document.getElementById('edit-form-' + postId);

                dropdownMenu.classList.toggle('hidden');

                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (menu !== dropdownMenu) {
                        menu.classList.add('hidden');
                    }
                });

                document.querySelectorAll('.edit-form').forEach(form => {
                    if (form !== editForm) {
                        form.classList.add('hidden');
                    }
                });
            });
        });

        // post dropdown
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.more-options') && !event.target.closest('.dropdown-menu')) {
                document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
        });

        // post-edit
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();
                const postId = this.getAttribute('data-post-id');
                const editForm = document.getElementById('edit-form-' + postId);

                if (editForm) {
                    editForm.classList.toggle('hidden');
                }
            });
        });

        // post-delete
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const postId = this.getAttribute('data-post-id');

                fetch(`/posts/${postId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    } else {
                        throw new Error('Silme işlemi başarısız oldu');
                    }
                })
                .then(data => {
                    alert('Post başarıyla silindi!');
                    location.reload(); // Sayfayı yenile
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            },
            { once: true }); // 'once: true' kullanarak bu event listener'ın sadece bir kez çalışması hedefleniyor
        });
});

</script>
