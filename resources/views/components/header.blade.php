{{ \Cachet\Facades\CachetView::renderHook(\Cachet\View\RenderHook::STATUS_PAGE_NAVIGATION_BEFORE) }}
<div class="flex items-center justify-between border-b border-zinc-200 px-4 sm:px-6 lg:px-8 py-4 dark:border-zinc-700"
    @if($brandingHeaderBgColor ?? false) style="background-color: {{ $brandingHeaderBgColor }}" @endif
>
    <div>
        <a href="{{ route('cachet.status-page') }}" class="flex items-center gap-2 transition hover:opacity-80">
            @if($brandingLogo ?? false)
            <img src="{{ Storage::url($brandingLogo) }}" alt="{{ $siteName }}" style="height: {{ $brandingLogoHeight ?? 32 }}px; width: auto;" />
            @elseif($appBanner)
            <img src="{{ Storage::url($appBanner) }}" alt="{{ $siteName }}" class="h-8 w-auto" />
            @else
            <span class="text-xl font-bold text-zinc-800 dark:text-white"
                @if($brandingHeaderTextColor ?? false) style="color: {{ $brandingHeaderTextColor }}" @endif
            >{{ $siteName }}</span>
            @endif
        </a>
    </div>

    <div class="flex items-center gap-2.5 sm:gap-5">
        @if(!empty($brandingHeaderLinks ?? []))
            @foreach($brandingHeaderLinks as $label => $url)
                <a href="{{ $url }}" target="_blank" rel="noopener" class="text-sm font-medium transition hover:opacity-80"
                    @if($brandingHeaderTextColor ?? false) style="color: {{ $brandingHeaderTextColor }}" @endif
                >{{ $label }}</a>
            @endforeach
        @endif

        {{-- Subscribe Button --}}
        @if($brandingShowSubscribe ?? true)
        <x-cachet::subscribe-button />
        @endif

        @if ($dashboardLoginLink)
        <a href="{{ Cachet\Cachet::dashboardPath() }}" class="rounded-sm bg-accent px-3 py-2 text-sm font-semibold text-accent-foreground">
            {{ __('filament-panels::pages/dashboard.title') }}
        </a>
        @auth
        {{-- TODO: This form sucks... --}}
        <form action="{{ \Cachet\Cachet::dashboardPath() }}/logout" method="POST">
            @csrf
            <button class="text-sm font-medium text-zinc-800 transition hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300 sm:text-base"
                @if($brandingHeaderTextColor ?? false) style="color: {{ $brandingHeaderTextColor }}" @endif
            >
                {{ __('filament-panels::layout.actions.logout.label') }}
            </button>
        </form>
        @endauth
        @endif
    </div>
</div>
{{ \Cachet\Facades\CachetView::renderHook(\Cachet\View\RenderHook::STATUS_PAGE_NAVIGATION_AFTER) }}
