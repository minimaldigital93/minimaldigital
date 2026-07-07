import { NextRequest, NextResponse } from "next/server";

// Maps a subdomain to the internal route that serves it.
// ams.minidigital.dev  -> /ams
// smart.minidigital.dev -> /smart
const SUBDOMAIN_ROUTES: Record<string, string> = {
  ams: "/ams",
  smart: "/smart",
};

export function middleware(request: NextRequest) {
  const host = request.headers.get("host") ?? "";
  const hostname = host.split(":")[0];
  const subdomain = hostname.split(".")[0];
  const target = SUBDOMAIN_ROUTES[subdomain];

  if (!target) {
    return NextResponse.next();
  }

  const url = request.nextUrl.clone();

  // Block direct access to sibling product routes from a subdomain
  // (e.g. ams.minidigital.dev/smart) by pinning everything to the
  // subdomain's own route.
  if (!url.pathname.startsWith(target)) {
    url.pathname =
      url.pathname === "/" ? target : `${target}${url.pathname}`;
    return NextResponse.rewrite(url);
  }

  return NextResponse.next();
}

export const config = {
  // Skip Next internals and static assets.
  matcher: ["/((?!_next|api|favicon.ico|.*\\..*).*)"],
};
