<?php

namespace App\Support;

use App\Models\AdminMenuItem;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminMenuBuilder
{
    public static function defaultItems(): array
    {
        return [
            ['type' => 'link', 'name' => 'Dashboard', 'url' => '/admin/dashboard', 'icon' => 'menu-icon icon-base bx bx-home-smile', 'slug' => 'admin.dashboard', 'sort_order' => 1],
            ['type' => 'header', 'name' => 'CMS', 'sort_order' => 2],
            ['type' => 'link', 'name' => 'Home', 'url' => '/Home-page-index', 'icon' => 'menu-icon icon-base bx bx-home-alt', 'slug' => 'content.dashboard.admin.index', 'sort_order' => 3],
            ['type' => 'link', 'name' => 'About', 'url' => '/admin/about-page', 'icon' => 'menu-icon icon-base bx bx-chat', 'slug' => 'admin.about.edit', 'sort_order' => 4],
            ['type' => 'link', 'name' => 'Pastors', 'url' => '/admin/pastors', 'icon' => 'menu-icon icon-base bx bx-user', 'slug' => 'admin.pastors.index', 'sort_order' => 5],
            ['type' => 'link', 'name' => 'Gallery', 'url' => '/admin/gallery', 'icon' => 'menu-icon icon-base bx bx-images', 'slug' => 'admin.gallery.index', 'sort_order' => 6],
            ['type' => 'link', 'name' => 'Calendar', 'url' => '/admin/calendar', 'icon' => 'menu-icon icon-base bx bx-calendar', 'slug' => 'admin.calendar.index', 'sort_order' => 7],
            ['type' => 'link', 'name' => 'Events', 'url' => '/admin/Events-page', 'icon' => 'menu-icon icon-base bx bx-grid', 'slug' => 'admin.events.index', 'sort_order' => 8],
            ['type' => 'header', 'name' => 'Pages', 'sort_order' => 9],
            ['type' => 'link', 'name' => 'Find Us', 'url' => '/admin/locations', 'icon' => 'menu-icon icon-base bx bx-map', 'slug' => 'admin.locations.index', 'sort_order' => 10],
            ['type' => 'link', 'name' => 'Contact', 'url' => '/admin/contact', 'icon' => 'menu-icon icon-base bx bx-envelope', 'slug' => 'admin.contact.index', 'sort_order' => 11],
            ['type' => 'header', 'name' => 'Branches', 'sort_order' => 12],
            ['type' => 'link', 'name' => 'Branch Accounts', 'url' => '/admin/branches', 'icon' => 'menu-icon icon-base bx bx-buildings', 'slug' => 'admin.branches.index', 'sort_order' => 13],
            ['type' => 'header', 'name' => 'Settings', 'sort_order' => 14],
            ['type' => 'link', 'name' => 'Sidebar Menu', 'url' => '/admin/menu', 'icon' => 'menu-icon icon-base bx bx-menu', 'slug' => 'admin.menu.index', 'sort_order' => 15],
            ['type' => 'link', 'name' => 'Account Settings', 'url' => '/admin/account-settings', 'icon' => 'menu-icon icon-base bx bx-dock-top', 'slug' => 'admin.account.index', 'sort_order' => 16],
        ];
    }

    /** Slugs a branch account may see in the sidebar. */
    public static function branchAllowedSlugs(): array
    {
        return [
            'admin.dashboard',
            'admin.pastors.index',
            'admin.gallery.index',
            'admin.locations.index',
            'admin.account.index',
        ];
    }

    /** Header names shown above branch-allowed links. */
    public static function branchAllowedHeaders(): array
    {
        return ['CMS', 'Pages', 'Settings'];
    }

    public static function ensureDefaults(): void
    {
        if (! AdminMenuItem::query()->exists()) {
            foreach (self::defaultItems() as $item) {
                AdminMenuItem::create($item);
            }

            return;
        }

        foreach (self::defaultItems() as $item) {
            $type = $item['type'] ?? 'link';

            if ($type === 'header') {
                $header = AdminMenuItem::where('type', 'header')
                    ->where('name', $item['name'])
                    ->first();

                if ($header) {
                    $header->update([
                        'sort_order' => $item['sort_order'],
                        'is_active' => true,
                    ]);
                } else {
                    AdminMenuItem::create($item);
                }
                continue;
            }

            if (empty($item['slug'])) {
                continue;
            }

            $existing = AdminMenuItem::where('slug', $item['slug'])->first();
            if ($existing) {
                // Keep custom labels/urls, but align section order
                $existing->update(['sort_order' => $item['sort_order']]);
            } else {
                AdminMenuItem::create($item);
            }
        }
    }

    public static function toMenuTree(): array
    {
        self::ensureDefaults();
        User::ensureColumns();

        $user = Auth::user();
        $isBranch = $user && $user->isBranch();
        $branchSlugs = self::branchAllowedSlugs();
        $branchHeaders = self::branchAllowedHeaders();

        $unread = 0;
        if (! $isBranch) {
            try {
                if (ContactMessage::tableReady()) {
                    $unread = ContactMessage::where('is_read', false)->count();
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        $roots = AdminMenuItem::with(['children' => fn ($q) => $q->active()->orderBy('sort_order')])
            ->roots()
            ->active()
            ->get();

        $menu = [];
        $pendingHeader = null;

        foreach ($roots as $item) {
            if ($item->type === 'header') {
                if ($isBranch && ! in_array($item->name, $branchHeaders, true)) {
                    $pendingHeader = null;
                    continue;
                }
                $pendingHeader = $item->name;
                continue;
            }

            if ($isBranch && ! in_array($item->slug, $branchSlugs, true)) {
                continue;
            }

            if ($pendingHeader !== null) {
                $menu[] = (object) ['menuHeader' => $pendingHeader];
                $pendingHeader = null;
            }

            $node = [
                'name' => $item->name,
                'url' => $item->url,
                'icon' => $item->icon,
                'slug' => $item->slug,
                'target' => $item->target ?: '_self',
            ];

            if ($item->slug === 'admin.contact.index' && $unread > 0) {
                $node['badge'] = ['danger', (string) $unread];
            } elseif ($item->badge_text) {
                $node['badge'] = [$item->badge_class ?: 'label-primary', $item->badge_text];
            }

            $children = $item->children;
            if ($children->isNotEmpty()) {
                $node['submenu'] = $children->map(function (AdminMenuItem $child) {
                    return (object) [
                        'name' => $child->name,
                        'url' => $child->url,
                        'icon' => $child->icon,
                        'slug' => $child->slug,
                        'target' => $child->target ?: '_self',
                    ];
                })->all();
            }

            $menu[] = (object) $node;
        }

        return $menu;
    }
}
