<div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-30 bg-black/40 lg:hidden" @click="sidebarOpen = false"></div>

<aside
    class="fixed inset-y-0 left-0 z-40 w-64 bg-ink text-white flex flex-col transform transition-transform duration-200 ease-in-out lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="h-16 flex items-center gap-2 px-5 border-b border-white/10">
        <div class="h-8 w-8 rounded-md bg-teal flex items-center justify-center font-display font-semibold text-sm">KS</div>
        <span class="font-display font-semibold tracking-tight">Kunjungan Sales</span>
    </div>

    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <x-slot name="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.122 0L22.28 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
            </x-slot>
            Dashboard
        </x-sidebar-link>

        <x-sidebar-link :href="route('stok-barang.index')" :active="request()->routeIs('stok-barang.*')">
            <x-slot name="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </x-slot>
            Stok Barang
        </x-sidebar-link>

        <x-sidebar-link :href="route('kategori-barang.index')" :active="request()->routeIs('kategori-barang.*')">
            <x-slot name="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.83.699 2.528 0l4.318-4.318a1.79 1.79 0 000-2.528L10.5 3.659A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </x-slot>
            Kategori Barang
        </x-sidebar-link>

        <x-sidebar-link :href="route('toko.index')" :active="request()->routeIs('toko.*')">
            <x-slot name="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21M3 10.5V21a.75.75 0 00.75.75h16.5A.75.75 0 0021 21V10.5M3.75 6h16.5M4.5 6l1.045-4.184A.75.75 0 016.27 1.5h11.46a.75.75 0 01.725.316L19.5 6M9 21v-6.375c0-.621.504-1.125 1.125-1.125h1.75c.621 0 1.125.504 1.125 1.125V21" />
            </x-slot>
            Toko
        </x-sidebar-link>

        <x-sidebar-link :href="route('kunjungan.index')" :active="request()->routeIs('kunjungan.*')">
            <x-slot name="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
            </x-slot>
            Kunjungan
        </x-sidebar-link>

        <x-sidebar-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')">
            <x-slot name="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5V21h4.5v-7.5H3zM9.75 8.25V21h4.5V8.25h-4.5zM16.5 3v18H21V3h-4.5z" />
            </x-slot>
            Laporan
        </x-sidebar-link>

        @if (Auth::user()->isOwner() || Auth::user()->isAdmin())
            <div class="pt-3 mt-3 border-t border-white/10">
                <p class="px-3 pb-1 text-xs font-medium uppercase tracking-wider text-white/40">Administrasi</p>
                <x-sidebar-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    <x-slot name="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </x-slot>
                    Manajemen User
                </x-sidebar-link>
            </div>
        @endif
    </nav>

    <div class="border-t border-white/10 p-3">
        <x-dropdown align="right" width="56" direction="up">
            <x-slot name="trigger">
                <button class="w-full flex items-center gap-3 rounded-md px-2 py-2 hover:bg-white/10 transition">
                    <div class="h-9 w-9 rounded-full bg-teal/80 flex items-center justify-center text-sm font-medium shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="text-left min-w-0">
                        <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-white/50 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</aside>
