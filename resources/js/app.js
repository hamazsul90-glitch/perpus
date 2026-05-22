const themeToggleButton = document.getElementById('theme-toggle');
const themeIcon = document.getElementById('theme-icon');
const htmlElement = document.documentElement;

const getPreferredTheme = () => {
    if (localStorage.getItem('theme')) {
        return localStorage.getItem('theme');
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const applyTheme = (theme) => {
    if (theme === 'dark') {
        htmlElement.classList.add('dark');
        htmlElement.classList.remove('light');
        themeIcon.textContent = '🌙';
    } else {
        htmlElement.classList.remove('dark');
        htmlElement.classList.add('light');
        themeIcon.textContent = '☀️';
    }
    localStorage.setItem('theme', theme);
};

const toggleTheme = () => {
    const currentTheme = htmlElement.classList.contains('dark') ? 'dark' : 'light';
    applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
};

if (themeToggleButton) {
    document.addEventListener('DOMContentLoaded', () => {
        applyTheme(getPreferredTheme());
        themeToggleButton.addEventListener('click', toggleTheme);
    });
}
