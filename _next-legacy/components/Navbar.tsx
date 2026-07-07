import Link from "next/link";

type NavbarProps = {
  /** When set, the navbar shows a single "MinimalDigital" link back to the main site. */
  productName?: string;
};

export default function Navbar({ productName }: NavbarProps) {
  return (
    <header className="sticky top-0 z-50 border-b border-line bg-paper/80 backdrop-blur-md">
      <nav className="mx-auto flex h-14 max-w-content items-center justify-between px-6">
        {productName ? (
          <>
            <span className="text-sm font-semibold tracking-tight">
              {productName}
            </span>
            <a
              href="https://minidigital.dev"
              className="text-sm text-muted transition-colors hover:text-ink"
            >
              MinimalDigital
            </a>
          </>
        ) : (
          <>
            <Link href="/" className="text-sm font-semibold tracking-tight">
              MinimalDigital
            </Link>
            <div className="flex items-center gap-8">
              <a
                href="https://ams.minidigital.dev"
                className="text-sm text-muted transition-colors hover:text-ink"
              >
                AMS
              </a>
              <a
                href="https://smart.minidigital.dev"
                className="text-sm text-muted transition-colors hover:text-ink"
              >
                SMART
              </a>
              <a
                href="mailto:contact@minidigital.dev"
                className="rounded-full bg-ink px-4 py-1.5 text-sm text-paper transition-opacity hover:opacity-80"
              >
                Contact
              </a>
            </div>
          </>
        )}
      </nav>
    </header>
  );
}
