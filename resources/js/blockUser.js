function blockUser(event, userId) {
    event.preventDefault();

    fetch(`/block/${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ user_id: userId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Engelleme işlemi başarısız oldu.');
        }
        // Sayfayı yenile
        location.reload();
    })
    .catch(error => {
        console.error('Hata:', error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.block-button').forEach(button => {
        button.addEventListener('click', event => {
            const userId = button.getAttribute('data-user-id');
            blockUser(event, userId);
        });
    });
});
