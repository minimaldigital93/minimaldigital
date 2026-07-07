export default function Footer() {
  return (
    <footer className="border-t border-line">
      <div className="mx-auto flex max-w-content flex-col gap-6 px-6 py-12 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <p className="text-sm font-semibold tracking-tight">MinimalDigital</p>
          <a
            href="mailto:contact@minidigital.dev"
            className="mt-1 block text-sm text-muted transition-colors hover:text-ink"
          >
            contact@minidigital.dev
          </a>
        </div>
        <div className="flex gap-8">
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
        </div>
        <p className="text-sm text-muted">
          © {new Date().getFullYear()} MinimalDigital
        </p>
      </div>
    </footer>
  );
}
