type ProductCardProps = {
  name: string;
  description: string;
  href: string;
};

export default function ProductCard({
  name,
  description,
  href,
}: ProductCardProps) {
  return (
    <a
      href={href}
      className="group flex flex-col justify-between rounded-2xl border border-line bg-paper p-8 transition-colors hover:border-ink sm:p-10"
    >
      <div>
        <h3 className="text-xl font-semibold tracking-tight">{name}</h3>
        <p className="mt-3 leading-relaxed text-muted">{description}</p>
      </div>
      <span className="mt-8 text-sm font-medium">
        View Product{" "}
        <span
          aria-hidden
          className="inline-block transition-transform group-hover:translate-x-1"
        >
          →
        </span>
      </span>
    </a>
  );
}
