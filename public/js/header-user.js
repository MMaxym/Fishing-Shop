document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const searchIcon = document.querySelector('.search-icon');

    function performSearch() {
        const query = searchInput.value.trim();
        if (query) {
            window.location.href = `/search?query=${encodeURIComponent(query)}`;
        }
        else {
            window.location.href = `/user/main`;
        }
    }

    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    searchIcon.addEventListener('click', () => {
        performSearch();
    });
});
