// Dark mode functionality
function initDarkMode() {
    const darkMode = localStorage.getItem('darkMode') === 'enabled';
    document.body.classList.toggle('dark-mode', darkMode);
}

// Listen for dark mode changes
document.addEventListener('darkModeChanged', function(e) {
    document.body.classList.toggle('dark-mode', e.detail.isDark);
});

// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', initDarkMode);