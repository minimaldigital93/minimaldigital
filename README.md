# MinimalDigital — Product Showcase & CMS

Minimal Digital. Maximum Impact.

A premium SaaS-style product showcase (Apple/Linear/Stripe-inspired) with a full admin CMS. Built with Laravel 12, Blade, Tailwind CSS, Alpine.js, GSAP and Swiper.

> The previous Next.js site is preserved untouched in [`_next-legacy/`](_next-legacy/).

## Stack

- **Laravel 12** (PHP 8.4+), MySQL, Laravel Breeze (Blade)
- **Tailwind CSS 3** (dark mode via `class`), Vite, Alpine.js
- **Swiper** (hero slideshow), **GSAP + ScrollTrigger** (scroll reveals, counters, parallax), **SortableJS** (drag-and-drop admin)
- Inter font, inline Heroicons, PWA manifest + service worker

## Quick start

```bash
composer install
npm install
cp .env.example .env            # then set DB_* credentials
php artisan key:generate
php artisan migrate --seed      # creates schema + demo content + admin user
php artisan storage:link
npm run build                   # or: npm run dev
php artisan serve
```

## Admin CMS

| Item | Value |
| --- | --- |
| URL | `/admin` (redirects to `/login` when signed out) |
| Username | `017552223` (email `admin@minidigital.dev` also works) |
| Password | `12345678` — **change this after first login** |

Features: dashboard stats · product CRUD (images, gallery, tags, SEO, theming) · slideshow manager (drag-to-reorder, enable/disable, autoplay & transition settings) · media library (drag-and-drop multi-upload, folders, search, replace, alt text, auto-downscale > 2560px) · homepage builder (drag-to-reorder + toggle sections) · website settings (brand, contact, social, footer, SEO, theme).

Public registration is disabled; admins are seeded (`database/seeders/AdminUserSeeder.php`).

## Project structure (key paths)

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php            # homepage (sections + slides + products)
│   │   ├── ProductPageController.php     # /products/{slug}
│   │   ├── SitemapController.php         # /sitemap.xml
│   │   └── Admin/                        # Dashboard, Product, HeroSlide,
│   │                                     # Media, Settings, HomepageSection
│   ├── Middleware/EnsureUserIsAdmin.php  # 'admin' alias (bootstrap/app.php)
│   └── Requests/                         # ProductRequest, HeroSlideRequest
├── Models/            # Product, ProductImage, Category, Tag, HeroSlide,
│                      # WebsiteSetting, Media, HomepageSection
├── Services/          # Settings (cached key-value), MediaService (upload/optimize)
└── Support/helpers.php  # media_url(), setting()

database/
├── migrations/        # products, product_images, hero_slides, website_settings,
│                      # media_library, categories, tags, product_tag,
│                      # homepage_sections, users.username
└── seeders/           # AdminUser, Category, Product (AMS + SmartSell),
                       # HeroSlide, WebsiteSetting, HomepageSection

resources/
├── css/app.css        # design system: glass, cards, buttons, badges, skeletons,
│                      # hero slide animations, reveal states
├── js/
│   ├── app.js
│   └── modules/       # theme.js (light/dark/auto), hero-slider.js (Swiper),
│                      # animations.js (GSAP), admin.js (Sortable + dropzone)
└── views/
    ├── layouts/       # site.blade.php (public), admin.blade.php (CMS)
    ├── partials/      # seo, navbar, footer, theme-toggle
    ├── home/sections/ # hero, products, features, mission, stats, faq, contact
    ├── components/    # product-card.blade.php
    ├── products/show.blade.php
    ├── admin/         # dashboard, products/, slides/, media/, homepage/, settings/
    └── auth/login.blade.php  # premium glass login (email OR username)

public/
├── images/            # brand + product placeholder SVGs
├── manifest.webmanifest, sw.js, robots.txt
```

## Common commands

```bash
php artisan migrate               # run migrations
php artisan migrate:fresh --seed  # reset everything + reseed
php artisan db:seed               # reseed only
npm run dev                       # Vite dev server (HMR)
npm run build                     # production assets
```

## Homepage sections

Rendered in the order stored in `homepage_sections` (drag-to-reorder in **Admin → Homepage Builder**). Each key maps to a Blade partial in `resources/views/home/sections/` — add a new section by creating a partial and inserting a row.

## Deployment checklist

- [ ] `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://minidigital.dev`
- [ ] Production DB credentials; run `php artisan migrate --force --seed`
- [ ] `php artisan storage:link`
- [ ] `npm run build` (commit or build in CI)
- [ ] `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] Change the seeded admin password
- [ ] HTTPS + DNS for `minidigital.dev` (products link out to `ams.` / `smart.` subdomains)
- [ ] Update `Sitemap:` URL in `public/robots.txt` if the domain changes
- [ ] Set real social links / analytics snippet in **Admin → Settings**
- [ ] Replace placeholder SVG artwork with real product screenshots via the Media Library
- [ ] Cron: `* * * * * php artisan schedule:run` (future-proofing)
- [ ] Queue/cache drivers (Redis) if traffic grows

## Future enhancements

- Visitor analytics (the dashboard card is a ready placeholder)
- Testimonials & partners as CMS-managed sections
- Contact form with mail notifications (currently mailto CTA)
- Image cropping UI in the media library (server-side GD is already in place)
- Localization (Khmer/English)
- Blog / changelog module
- Per-product brochure PDF upload (CTA placeholder exists)
# minimaldigital
