@php
    $role = Auth::user()->role;
    $unreadCount = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
@endphp

<!-- DESKTOP SIDEBAR -->
<aside 
    :class="sidebarOpen ? 'w-64' : 'w-20'" 
    class="hidden md:flex flex-col h-screen sticky top-0 bg-[#F4F1EA] border-r-[3px] border-[#0D0D0D] transition-all duration-300 z-50 flex-shrink-0"
>
    <!-- Sidebar Header (Logo) -->
    <div class="p-4 border-b-[3px] border-[#0D0D0D] flex items-center justify-between h-20 bg-white">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 bg-[#FFC700] border-[2.5px] border-[#0D0D0D] px-3 py-1 font-heading text-base tracking-wider text-[#0D0D0D] shadow-[2px_2px_0px_0px_rgba(13,13,13,1)]">
            <span x-show="sidebarOpen">BM <span class="text-white drop-shadow-[1px_1px_0px_rgba(13,13,13,1)]">STUDIO</span></span>
            <span x-show="!sidebarOpen" class="font-bold">BM</span>
        </a>
        
        <!-- Toggle arrow button (desktop only) -->
        <button 
            @click="sidebarOpen = !sidebarOpen" 
            class="p-1 border-[2.5px] border-black bg-white hover:bg-[#FFC700] transition shadow-[1px_1px_0px_0px_black] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none"
        >
            <svg 
                :class="sidebarOpen ? 'rotate-0' : 'rotate-180'" 
                class="w-4 h-4 transition-transform duration-300" 
                fill="none" stroke="currentColor" viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Links -->
    <nav class="flex-1 px-3 py-6 space-y-4 overflow-y-auto">
        @if($role === 'admin')
            <!-- Admin Links -->
            <x-sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="home" :sidebarOpen="true">
                {{ __('Overview') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')" icon="calendar" :sidebarOpen="true">
                {{ __('Bookings') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('admin.finances.index')" :active="request()->routeIs('admin.finances.*')" icon="finance" :sidebarOpen="true">
                {{ __('Keuangan (Finance)') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('admin.inventories.index')" :active="request()->routeIs('admin.inventories.*')" icon="inventory" :sidebarOpen="true">
                {{ __('Inventaris (Inventory)') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')" icon="users" :sidebarOpen="true">
                {{ __('Kelola Karyawan') }}
            </x-sidebar-link>

            <x-sidebar-link :href="route('admin.carousel.index')" :active="request()->routeIs('admin.carousel.*')" icon="carousel" :sidebarOpen="true">
                {{ __('Carousel CMS') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('admin.chat.index')" :active="request()->routeIs('admin.chat.*')" icon="chat" :sidebarOpen="true" :badgeCount="$unreadCount">
                {{ __('Chat Room') }}
            </x-sidebar-link>


        @else
            <!-- Customer Links -->
            <x-sidebar-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard') && !request()->has('anchor')" icon="home" :sidebarOpen="true">
                {{ __('Home') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('bookings.create')" :active="request()->routeIs('bookings.create')" icon="calendar-plus" :sidebarOpen="true">
                {{ __('Book Studio') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('customer.dashboard') . '#my-bookings'" :active="request()->url() == route('customer.dashboard') && str_contains(request()->fullUrl(), '#my-bookings')" icon="list" :sidebarOpen="true">
                {{ __('My Bookings') }}
            </x-sidebar-link>
            
            <x-sidebar-link :href="route('chat.index')" :active="request()->routeIs('chat.index')" icon="chat" :sidebarOpen="true" :badgeCount="$unreadCount">
                {{ __('Chat Admin') }}
            </x-sidebar-link>
        @endif
        
        <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" icon="profile" :sidebarOpen="true">
            {{ __('Profile') }}
        </x-sidebar-link>
    </nav>

    <!-- Sidebar Footer / Profile info & Logout -->
    <div class="p-4 border-t-[3px] border-[#0D0D0D] bg-white flex flex-col space-y-3">
        <div class="flex items-center space-x-3" x-show="sidebarOpen">
            <div class="w-10 h-10 bg-[#FFC700] border-2 border-black flex items-center justify-center font-heading text-sm uppercase tracking-wider shadow-[2px_2px_0px_0px_black]">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-[#0D0D0D] truncate leading-tight">{{ Auth::user()->name }}</p>
                <p class="text-[9px] font-bold text-[#E14D2A] uppercase tracking-wider leading-none">{{ ucfirst($role) }}</p>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button 
                type="submit" 
                class="w-full inline-flex items-center justify-center px-4 py-2 border-[2.5px] border-black bg-white hover:bg-[#E14D2A] hover:text-white font-heading text-xs uppercase tracking-wider shadow-[2px_2px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all"
            >
                <!-- Log out icon -->
                <svg class="w-4 h-4" :class="sidebarOpen ? 'mr-2' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="sidebarOpen">LOG OUT</span>
            </button>
        </form>
    </div>
</aside>

<!-- MOBILE DRAWER -->
<div>
    <!-- Backdrop backdrop overlay -->
    <div 
        x-show="mobileOpen" 
        x-transition.opacity 
        @click="mobileOpen = false" 
        class="fixed inset-0 bg-black/60 z-50 md:hidden"
    ></div>

    <!-- Drawer container -->
    <aside 
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 w-64 bg-[#F4F1EA] border-r-[3px] border-[#0D0D0D] z-55 flex flex-col md:hidden shadow-[4px_0px_0px_0px_black]"
    >
        <!-- Drawer Header -->
        <div class="p-4 border-b-[3px] border-[#0D0D0D] flex items-center justify-between h-20 bg-white">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 bg-[#FFC700] border-[2.5px] border-[#0D0D0D] px-3 py-1.5 font-heading text-base tracking-wider text-[#0D0D0D] shadow-[2.5px_2.5px_0px_0px_rgba(13,13,13,1)]">
                <span>BM <span class="text-white drop-shadow-[1px_1px_0px_rgba(13,13,13,1)]">STUDIO</span></span>
            </a>
            
            <button 
                @click="mobileOpen = false" 
                class="p-2 border-[2.5px] border-black bg-white hover:bg-[#FFC700] text-black active:translate-x-0.5 active:translate-y-0.5 transition shadow-[1px_1px_0px_0px_black]"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Drawer Links -->
        <nav class="flex-1 px-4 py-6 space-y-4 overflow-y-auto" @click="mobileOpen = false">
            @if($role === 'admin')
                <x-sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="home" :sidebarOpen="true">
                    {{ __('Overview') }}
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')" icon="calendar" :sidebarOpen="true">
                    {{ __('Bookings') }}
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('admin.finances.index')" :active="request()->routeIs('admin.finances.*')" icon="finance" :sidebarOpen="true">
                    {{ __('Keuangan (Finance)') }}
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('admin.inventories.index')" :active="request()->routeIs('admin.inventories.*')" icon="inventory" :sidebarOpen="true">
                    {{ __('Inventaris (Inventory)') }}
                </x-sidebar-link>

                <x-sidebar-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')" icon="users" :sidebarOpen="true">
                    {{ __('Kelola Karyawan') }}
                </x-sidebar-link>

                <x-sidebar-link :href="route('admin.carousel.index')" :active="request()->routeIs('admin.carousel.*')" icon="carousel" :sidebarOpen="true">
                    {{ __('Carousel CMS') }}
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('admin.chat.index')" :active="request()->routeIs('admin.chat.*')" icon="chat" :sidebarOpen="true" :badgeCount="$unreadCount">
                    {{ __('Chat Room') }}
                </x-sidebar-link>


            @else
                <x-sidebar-link :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard') && !request()->has('anchor')" icon="home" :sidebarOpen="true">
                    {{ __('Home') }}
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('bookings.create')" :active="request()->routeIs('bookings.create')" icon="calendar-plus" :sidebarOpen="true">
                    {{ __('Book Studio') }}
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('customer.dashboard') . '#my-bookings'" :active="request()->url() == route('customer.dashboard') && str_contains(request()->fullUrl(), '#my-bookings')" icon="list" :sidebarOpen="true">
                    {{ __('My Bookings') }}
                </x-sidebar-link>
                
                <x-sidebar-link :href="route('chat.index')" :active="request()->routeIs('chat.index')" icon="chat" :sidebarOpen="true" :badgeCount="$unreadCount">
                    {{ __('Chat Admin') }}
                </x-sidebar-link>
            @endif
            
            <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" icon="profile" :sidebarOpen="true">
                {{ __('Profile') }}
            </x-sidebar-link>
        </nav>

        <!-- Drawer Footer -->
        <div class="p-4 border-t-[3px] border-[#0D0D0D] bg-white flex flex-col space-y-3">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-[#FFC700] border-2 border-black flex items-center justify-center font-heading text-sm uppercase tracking-wider shadow-[2px_2px_0px_0px_black]">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div>
                    <p class="text-xs font-bold text-[#0D0D0D]">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-bold text-[#E14D2A] uppercase tracking-wider leading-none">{{ ucfirst($role) }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button 
                    type="submit" 
                    class="w-full inline-flex items-center justify-center px-4 py-2 border-[2.5px] border-black bg-white hover:bg-[#E14D2A] hover:text-white font-heading text-xs uppercase tracking-wider shadow-[2px_2px_0px_0px_black]"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    LOG OUT
                </button>
            </form>
        </div>
    </aside>
</div>
