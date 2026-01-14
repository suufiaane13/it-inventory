<div x-data="{ 
    darkMode: false,
    init() {
        // Check localStorage first, then system preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            this.darkMode = savedTheme === 'dark';
        } else {
            this.darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        this.updateTheme();
    },
    toggle() {
        this.darkMode = !this.darkMode;
        this.updateTheme();
    },
    updateTheme() {
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }
}" class="flex items-center">
    <button 
        @click="toggle()"
        type="button"
        class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-700"
        role="switch"
        :aria-checked="darkMode"
    >
        <span class="sr-only">Basculer le mode sombre</span>
        <span 
            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 translate-x-1 dark:translate-x-6"
        ></span>
    </button>
    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
        <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 010 8z" />
        </svg>
        <svg x-show="darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </span>
</div>
