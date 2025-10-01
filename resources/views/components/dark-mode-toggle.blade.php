<div x-data="darkModeHandler()" class="flex items-center">
    <button @click="toggle" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        {{-- ไอคอนพระอาทิตย์ (แสดงในโหมดมืด) --}}
        <svg x-show="isDarkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.364-8.364l-.707-.707M4.343 4.343l-.707-.707m16.364 0l-.707.707M4.343 19.657l-.707.707M21 12h-1M4 12H3m15.364 8.364l-.707-.707M5.05 5.05l-.707-.707" />
        </svg>
        {{-- ไอคอนพระจันทร์ (แสดงในโหมดสว่าง) --}}
        <svg x-show="!isDarkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>
</div>

<script>
    function darkModeHandler() {
        return {
            isDarkMode: false,
            init() {
                if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                    this.isDarkMode = true;
                } else {
                    document.documentElement.classList.remove('dark');
                    this.isDarkMode = false;
                }
            },
            toggle() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                    this.isDarkMode = false;
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                    this.isDarkMode = true;
                }
            }
        }
    }
</script>