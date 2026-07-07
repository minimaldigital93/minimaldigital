# MinimalDigital

Minimal Digital. Maximum Impact.

One Next.js (App Router) project serving three sites:

| Domain | Route served | Page |
|---|---|---|
| `minidigital.dev` | `/` | Main company site |
| `ams.minidigital.dev` | `/ams` | AMS product landing |
| `smart.minidigital.dev` | `/smart` | SMART product landing |

## Project structure

```
minidigital/
├── app/
│   ├── layout.tsx        # Root layout, metadata, global font
│   ├── globals.css       # Tailwind entry + base styles
│   ├── page.tsx          # Main site (minidigital.dev)
│   ├── ams/page.tsx      # AMS landing (ams.minidigital.dev)
│   └── smart/page.tsx    # SMART landing (smart.minidigital.dev)
├── components/
│   ├── Navbar.tsx
│   ├── Footer.tsx
│   └── ProductCard.tsx
├── middleware.ts         # Subdomain → route rewriting
├── tailwind.config.ts
├── postcss.config.mjs
├── next.config.mjs
└── tsconfig.json
```

## Local development

```bash
npm install
npm run dev
```

- Main site: http://localhost:3000
- AMS: http://localhost:3000/ams
- SMART: http://localhost:3000/smart

To test real subdomain behavior locally, add to `/etc/hosts`:

```
127.0.0.1 minidigital.local ams.minidigital.local smart.minidigital.local
```

Then visit `http://ams.minidigital.local:3000` — the middleware rewrites it to `/ams` automatically.

## Subdomain routing strategy

All three domains point at the **same deployment**. [middleware.ts](middleware.ts) inspects the `Host` header on every request:

1. `ams.minidigital.dev/*` is internally **rewritten** (not redirected — the URL bar keeps the subdomain) to `/ams/*`.
2. `smart.minidigital.dev/*` is rewritten to `/smart/*`.
3. Any other host (the apex domain) passes through untouched and serves `/`.

This keeps one codebase, one build, one deploy — and each subdomain still gets its own metadata, title, and page.

### Option A — Vercel (recommended)

1. Push the repo to GitHub and import it into Vercel.
2. In **Project → Settings → Domains**, add all three:
   - `minidigital.dev`
   - `ams.minidigital.dev`
   - `smart.minidigital.dev`
3. At your DNS provider:
   - `minidigital.dev` → `A 76.76.21.21` (Vercel apex IP)
   - `ams` → `CNAME cname.vercel-dns.com`
   - `smart` → `CNAME cname.vercel-dns.com`
4. Done. Vercel provisions TLS for all three; the middleware handles the routing.

### Option B — Nginx (self-hosted)

Run the app with `npm run build && npm run start` (port 3000), then proxy all three hosts to it:

```nginx
server {
    listen 443 ssl;
    server_name minidigital.dev ams.minidigital.dev smart.minidigital.dev;

    # ssl_certificate ... (use certbot with -d for each domain)

    location / {
        proxy_pass http://127.0.0.1:3000;
        proxy_set_header Host $host;          # critical: middleware reads this
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

The only critical line is `proxy_set_header Host $host` — without it the middleware can't see which subdomain was requested.

## Deployment guide (production)

```bash
# 1. Verify the production build locally
npm run build

# 2a. Vercel
npx vercel --prod

# 2b. Self-hosted (e.g. behind Nginx + pm2)
npm run build
pm2 start npm --name minidigital -- start
```

Checklist:
- [ ] DNS records for apex + both subdomains
- [ ] TLS certificates cover all three hosts
- [ ] `contact@minidigital.dev` mailbox exists (footer + CTA links point to it)
