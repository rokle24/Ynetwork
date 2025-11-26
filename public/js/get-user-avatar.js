//Loads a user avatar in order, first png then jpg and if these don't work it falls back to a default image
window.setUserAvatar = function(imgElement, userId, options) {
    options = options || {};
    const folder = options.folder || '/profilePictures';
    const defaultSrc = options.defaultSrc || '/images/default-avatar.jpg';

    // Clear any previous data
    imgElement.removeAttribute('data-attempted');
    imgElement.onerror = null;

    //Try PNG first
    imgElement.src = `${folder}/${userId}.png`;

    imgElement.onerror = function() {
        // Check if we already tried jpg, if not try it
        if (!this.dataset.attempted) {
            this.dataset.attempted = 'true';
            this.src = `${folder}/${userId}.jpg`;
            return;
        }

        // jpg also failed so use default image
        if (this.src !== defaultSrc) {
            this.src = defaultSrc;
        }
    };
};

// Auto-initialize images with class `user-avatar` and `data-user-id`
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('img.user-avatar[data-user-id]').forEach(function(img) {
        try {
            const id = img.getAttribute('data-user-id');
            if (id) window.setUserAvatar(img, id);
        } catch (e) { /* ignore */ }
    });
});
