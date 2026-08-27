@php
use Illuminate\Support\Facades\Route;
$brandName = isset($siteSettings) ? $siteSettings->brandName() : 'CNCI';
$brandTagline = isset($siteSettings) ? $siteSettings->brandTagline() : '';
$logoUrl = isset($siteSettings) ? $siteSettings->logoUrl() : asset('assets/img/avatars/cnciLogo.png');
$menuItems = $menuData[0]->menu ?? [];
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin/dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ $logoUrl }}" alt="{{ $brandName }} Logo" width="32" height="32">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">
                {{ $brandName }}
                @if($brandTagline)
                    <small class="d-block fw-normal" style="font-size:0.7rem;opacity:.75;line-height:1.1;">{{ $brandTagline }}</small>
                @endif
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="icon-base bx bx-chevron-left icon-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuItems as $menu)

        @if (isset($menu->menuHeader))
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
        </li>
        @else
        @php
            $activeClass = null;
            $currentRouteName = Route::currentRouteName() ?? '';
            $menuSlug = $menu->slug ?? null;

            if ($menuSlug && $currentRouteName === $menuSlug) {
                $activeClass = 'active';
            } elseif (isset($menu->submenu)) {
                if (is_array($menuSlug)) {
                    foreach ($menuSlug as $slug) {
                        if ($currentRouteName === $slug || str_starts_with($currentRouteName, $slug . '.')) {
                            $activeClass = 'active open';
                            break;
                        }
                    }
                } elseif ($menuSlug && (str_starts_with($currentRouteName, $menuSlug) || str_contains($currentRouteName, $menuSlug))) {
                    $activeClass = 'active open';
                }
            } elseif ($menuSlug) {
                $base = preg_replace('/\.index$/', '', $menuSlug);
                if ($base && str_starts_with($currentRouteName, $base)) {
                    $activeClass = 'active';
                }
            }

            $href = 'javascript:void(0);';
            if (!empty($menu->url)) {
                $href = \Illuminate\Support\Str::startsWith($menu->url, ['http://', 'https://', '#'])
                    ? $menu->url
                    : url($menu->url);
            }
        @endphp

        <li class="menu-item {{ $activeClass }}">
            <a href="{{ $href }}"
                class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                @if (!empty($menu->target)) target="{{ $menu->target }}" @endif>

                @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
                @endisset

                <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>

                @isset($menu->badge)
                <div class="badge rounded-pill bg-{{ $menu->badge[0] }} text-uppercase ms-auto">
                    {{ $menu->badge[1] }}
                </div>
                @endisset
            </a>

            @isset($menu->submenu)
                @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
            @endisset
        </li>
        @endif
        @endforeach
    </ul>

</aside>
