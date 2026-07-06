
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#0D0D0D">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="description" content="@yield('meta_description', 'Professional auto shop job card management system for PKR pricing, bilingual Urdu support, and complete customer and vehicle tracking.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=IBM+Plex+Sans:wght@300;400;500;600;700&family=Noto+Nastaliq+Urdu:wght@400;600&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        (function() {
            const storageKey = 'autoshop-theme';
            const storedTheme = localStorage.getItem(storageKey);
            const preferredTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const activeTheme = storedTheme || preferredTheme;

            document.documentElement.classList.toggle('dark', activeTheme === 'dark');
            document.documentElement.dataset.theme = activeTheme;
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[var(--app-bg)] text-[var(--app-text)] antialiased">
    <div class="relative min-h-screen lg:grid lg:grid-cols-[15rem_minmax(0,1fr)]">
        <aside role="complementary" aria-label="Main navigation sidebar" data-sidebar data-open="false"
            class="fixed inset-y-0 left-0 z-40 flex w-60 -translate-x-full flex-col border-r border-[var(--app-border)] bg-[var(--app-surface)]/95 backdrop-blur-xl transition-transform duration-300 ease-out lg:sticky lg:top-0 lg:z-auto lg:h-screen lg:w-auto lg:translate-x-0 lg:self-start lg:shadow-none">
            <div class="flex items-center gap-3 border-b border-[var(--app-border)] px-6 py-5">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl border border-[color:color-mix(in_srgb,var(--app-accent)_30%,transparent)] bg-[color:color-mix(in_srgb,var(--app-accent)_14%,transparent)] text-sm font-bold text-[var(--app-accent)]">
                    AS
                </div>
                <div>
                    <div class="font-display text-lg font-bold tracking-wide">AutoShop</div>
                </div>
            </div>

            <nav role="navigation" aria-label="Main application navigation" class="flex-1 px-4 py-5 overflow-y-auto">
                @php
                    $navItems = [
                        [
                            'url'   => route('dashboard'),
                            'label' => 'Dashboard',
                            'match' => 'dashboard',
                            'svg'   => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
                        ],
                        [
                            'url'   => route('intake.create'),
                            'label' => 'Quick Intake',
                            'match' => 'intake.*',
                            'svg'   => '<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
                        ],
                        [
                            'url'   => route('customers.index'),
                            'label' => 'Customers',
                            'match' => 'customers.*',
                            'svg'   => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                        ],
                        [
                            'url'   => route('cars.index'),
                            'label' => 'Cars',
                            'match' => 'cars.*',
                            'svg'   => '<path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v9a2 2 0 0 1-2 2h-2"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
                        ],
                        [
                            'url'   => route('jobs.index'),
                            'label' => 'Job Cards',
                            'match' => 'jobs.*',
                            'svg'   => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/>',
                        ],
                        [
                            'url'   => route('presets.index'),
                            'label' => 'Services',
                            'match' => 'presets.*',
                            'svg'   => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
                        ],
                        [
                            'url'   => route('parts.index'),
                            'label' => 'Parts',
                            'match' => 'parts.*',
                            'svg'   => '<polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"/><line x1="12" y1="22" x2="12" y2="15.5"/><polyline points="22 8.5 12 15.5 2 8.5"/>',
                        ],
                        [
                            'url'   => route('reports.revenue'),

                            'label' => 'Reports',
                            'match' => 'reports.*',
                            'svg'   => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
                        ],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    @php $isActive = request()->routeIs($item['match']); @endphp
                    <a href="{{ $item['url'] }}"
                        class="mt-1 flex items-center gap-3 rounded-2xl border px-3 py-3 text-sm font-medium transition
                            {{ $isActive
                                ? 'border-[var(--app-accent)]/30 bg-[color:color-mix(in_srgb,var(--app-accent)_10%,transparent)] text-[var(--app-accent)]'
                                : 'border-transparent text-[var(--app-text)] hover:border-[var(--app-border)] hover:bg-[color:color-mix(in_srgb,var(--app-accent)_5%,transparent)]' }}"
                        @if ($isActive) aria-current="page" @endif>
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.75"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            {!! $item['svg'] !!}
                        </svg>
                        <span class="block font-display text-base leading-tight">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            {{-- Mode box removed --}}
        </aside>

        <div class="flex min-h-screen min-w-0 flex-1 flex-col">
            <header role="banner"
                class="sticky top-0 z-30 border-b border-[var(--app-border)] bg-[color:color-mix(in_srgb,var(--app-bg)_76%,transparent)] backdrop-blur-xl">
                <div
                    class="mx-auto flex w-full max-w-[90rem] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button type="button" data-sidebar-toggle
                            class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-[var(--app-border)] bg-[var(--app-surface)] text-[var(--app-text)] transition hover:border-[var(--app-accent)] lg:hidden"
                            aria-label="Toggle navigation sidebar">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 stroke-current" stroke-width="1.8"
                                stroke-linecap="round" aria-hidden="true">
                                <path d="M4 6h16" />
                                <path d="M4 12h16" />
                                <path d="M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h1 class="font-display text-xl font-bold tracking-wide">@yield('page_title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" data-theme-toggle aria-label="Toggle dark/light theme"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[var(--app-border)] bg-[var(--app-surface)] text-[var(--app-text)] transition hover:border-[var(--app-accent)] hover:text-[var(--app-accent)]">
                            <svg class="h-5 w-5 stroke-current theme-icon-light" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="5"></circle>
                                <line x1="12" y1="1" x2="12" y2="3"></line>
                                <line x1="12" y1="21" x2="12" y2="23"></line>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                <line x1="1" y1="12" x2="3" y2="12"></line>
                                <line x1="21" y1="12" x2="23" y2="12"></line>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                            </svg>
                            <svg class="h-5 w-5 stroke-current theme-icon-dark" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>


            <div x-data="{ show: false, message: '', type: 'success' }" 
                 @notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
                 x-show="show" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4"
                 class="fixed z-50 rounded-xl px-6 py-4 shadow-xl text-white font-medium normal-case tracking-normal"
                 :class="type === 'success' ? 'bg-emerald-600' : 'bg-red-600'"
                 style="display: none; bottom: 1.5rem; right: 1.5rem;">
                <span x-text="message"></span>
            </div>

            @if (session('success'))
                <script>
                    document.addEventListener('alpine:init', () => {
                        setTimeout(() => window.dispatchEvent(new CustomEvent('notify', { detail: { message: "{{ session('success') }}", type: 'success' }})), 100);
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    document.addEventListener('alpine:init', () => {
                        setTimeout(() => window.dispatchEvent(new CustomEvent('notify', { detail: { message: "{{ session('error') }}", type: 'error' }})), 100);
                    });
                </script>
            @endif

            <main role="main" class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                <div class="mx-auto w-full max-w-[90rem]">
                    @yield('content')
                </div>
            </main>
        </div>

        <div data-sidebar-backdrop
            class="pointer-events-none fixed inset-0 z-30 bg-black/50 opacity-0 transition-opacity duration-300 lg:hidden">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggles = document.querySelectorAll('[data-sidebar-toggle]');
            const sidebar = document.querySelector('[data-sidebar]');
            const backdrop = document.querySelector('[data-sidebar-backdrop]');
            let isOpen = false;

            function toggleSidebar() {
                isOpen = !isOpen;
                
                if (isOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    backdrop.classList.remove('pointer-events-none', 'opacity-0');
                    backdrop.classList.add('opacity-100');
                } else {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('pointer-events-none', 'opacity-0');
                }
            }

            toggles.forEach(btn => btn.addEventListener('click', toggleSidebar));
            backdrop.addEventListener('click', toggleSidebar);
        });
    </script>
</body>

</html>
