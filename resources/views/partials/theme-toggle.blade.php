<button x-data @click="$store.theme.cycle()"
        class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
        :title="'Theme: ' + $store.theme.preference"
        aria-label="Switch theme (light / dark / auto)">
    {{-- sun --}}
    <svg x-show="$store.theme.preference === 'light'" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 3v2m0 14v2M5.6 5.6l1.4 1.4m10 10 1.4 1.4M3 12h2m14 0h2M5.6 18.4 7 17m10-10 1.4-1.4"/>
    </svg>
    {{-- moon --}}
    <svg x-show="$store.theme.preference === 'dark'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.8A8.5 8.5 0 1 1 11.2 3a6.6 6.6 0 0 0 9.8 9.8Z"/>
    </svg>
    {{-- auto --}}
    <svg x-show="$store.theme.preference === 'auto'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="12" cy="12" r="9"/><path d="M12 3a9 9 0 0 1 0 18Z" fill="currentColor" stroke="none"/>
    </svg>
</button>
