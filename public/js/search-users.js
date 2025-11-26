document.getElementById('search').addEventListener('input', function () {
    let query = this.value;

    if (query.length > 1) {
        fetch(`/search-users?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                let results = document.getElementById('search-results');
                results.innerHTML = '';
                results.style.display = data.length ? 'block' : 'none';

                data.forEach(user => {
                    let item = document.createElement('a');
                    item.classList.add('search-item');
                    item.href = `/users/${user.id}`;

                    let img = document.createElement('img');
                    // mark as search result avatar for optional auto-init
                    img.classList.add('user-avatar');
                    img.setAttribute('data-user-id', user.id);
                    // If the helper is available use it; otherwise fall back to direct src
                    if (window.setUserAvatar) {
                        window.setUserAvatar(img, user.id);
                    } else {
                        img.src = `/profilePictures/${user.id}.png`;
                        img.onerror = function() {
                            if (this.dataset.attempted !== 'true') {
                                this.dataset.attempted = 'true';
                                this.src = `/profilePictures/${user.id}.jpg`;
                            } else if (this.src !== '/images/default-avatar.jpg') {
                                this.src = '/images/default-avatar.jpg';
                            }
                        };
                    }

                    let name = document.createElement('span');
                    name.textContent = `${user.first_name} ${user.last_name}`

                    item.appendChild(img);
                    item.appendChild(name);
                    results.appendChild(item);
                });
            });
    } else {
        document.getElementById('search-results').style.display = 'none';
    }
});
