function getBookmarks() {
    if (window.isLoggedIn) {
        return window.userBookmarks || [];
    }

    const name = 'bookmarked_games=';
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');

    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.indexOf(name) === 0) {
            try {
                return JSON.parse(cookie.substring(name.length, cookie.length));
            } catch (error) {
                return [];
            }
        }
    }

    return [];
}

function setBookmarks(bookmarks) {
    if (window.isLoggedIn) {
        window.userBookmarks = bookmarks;
        return;
    }

    const d = new Date();
    d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
    const expires = 'expires=' + d.toUTCString();
    document.cookie = 'bookmarked_games=' + JSON.stringify(bookmarks) + ';' + expires + ';path=/;SameSite=Lax';
}

async function toggleBookmark(gameId, genreId) {
    const key = genreId ? `${gameId}_${genreId}` : `${gameId}`;
    let bookmarks = getBookmarks();
    const index = bookmarks.indexOf(key);
    const isAdding = index === -1;

    if (isAdding) {
        bookmarks.push(key);
    } else {
        bookmarks.splice(index, 1);
    }

    // Update UI immediately for responsiveness
    setBookmarks(bookmarks);
    updateBookmarkUI(gameId, genreId);

    // Persist to server if logged in
    if (window.isLoggedIn && window.bookmarkToggleUrl) {
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch(window.bookmarkToggleUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    game_id: gameId,
                    genre_id: genreId || null
                })
            });

            if (!response.ok) {
                throw new Error('Server bookmark sync failed');
            }
        } catch (error) {
            console.error('Bookmark sync error:', error);
            // Optional: Revert UI state on failure if strictly necessary
        }
    }
}

function isBookmarked(gameId, genreId) {
    const bookmarks = getBookmarks();
    if (genreId) {
        return bookmarks.indexOf(`${gameId}_${genreId}`) > -1;
    }
    // If only gameId provided, check if it's bookmarked in ANY genre
    return bookmarks.some(b => b.startsWith(`${gameId}_`) || b === `${gameId}`);
}

function updateBookmarkUI(gameId, genreId) {
    const genreAttr = (genreId && genreId !== 'null') ? `[data-genre="${genreId}"]` : '[data-genre=""], :not([data-genre])';
    const buttons = document.querySelectorAll(`[data-id="${gameId}"]${genreAttr}, [onclick*="toggleBookmark(${gameId}, ${genreId})"]`);
    const active = isBookmarked(gameId, genreId);

    buttons.forEach((button) => {
        button.classList.toggle('active', active);
        const icon = button.querySelector('.material-symbols-outlined');
        if (icon) {
            icon.style.fontVariationSettings = active ? "'FILL' 1" : "'FILL' 0";
            icon.classList.toggle('text-primary', active);
        }
    });
}

// Ensure functions are globally accessible on window object
window.getBookmarks = getBookmarks;
window.setBookmarks = setBookmarks;
window.toggleBookmark = toggleBookmark;
window.isBookmarked = isBookmarked;
window.updateBookmarkUI = updateBookmarkUI;
