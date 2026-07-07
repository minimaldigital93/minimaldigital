import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import ProductCard from "@/components/ProductCard";

const philosophy = [
  "Less features. More clarity.",
  "Systems that scale without complexity.",
  "Built for performance, not noise.",
];

export default function HomePage() {
  return (
    <>
      <Navbar />
      <main>
        {/* Hero */}
        <section className="mx-auto max-w-content px-6 pb-24 pt-28 text-center sm:pb-32 sm:pt-40">
          <h1 className="mx-auto max-w-3xl text-4xl font-semibold tracking-tight sm:text-6xl">
            Minimal Digital.
            <br />
            Maximum Impact.
          </h1>
          <p className="mx-auto mt-6 max-w-xl text-lg leading-relaxed text-muted">
            We build simple, powerful digital systems that help businesses
            operate smarter.
          </p>
          <div className="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <a
              href="https://ams.minidigital.dev"
              className="w-full rounded-full bg-ink px-7 py-3 text-sm font-medium text-paper transition-opacity hover:opacity-80 sm:w-auto"
            >
              Explore AMS
            </a>
            <a
              href="https://smart.minidigital.dev"
              className="w-full rounded-full border border-line px-7 py-3 text-sm font-medium transition-colors hover:border-ink sm:w-auto"
            >
              Explore SMART
            </a>
          </div>
        </section>

        {/* Mission */}
        <section className="border-t border-line bg-mist">
          <div className="mx-auto max-w-content px-6 py-24 sm:py-32">
            <h2 className="text-sm font-medium uppercase tracking-widest text-muted">
              Our Mission
            </h2>
            <div className="mt-8 max-w-3xl space-y-6 text-lg leading-relaxed sm:text-xl">
              <p>
                Most business software is bloated. Endless menus, features
                nobody asked for, and complexity that slows teams down instead
                of moving them forward. We believe the opposite: the best
                systems are the ones you barely notice.
              </p>
              <p>
                MinimalDigital builds clean, focused tools that automate the
                repetitive and clarify the essential. Every product starts
                from a single question — what is the simplest system that
                solves this problem completely?
              </p>
              <p>
                The result is software that scales with your business without
                scaling its complexity. Fast to learn, fast to run, and built
                to stay out of your way.
              </p>
            </div>
          </div>
        </section>

        {/* Products */}
        <section className="border-t border-line">
          <div className="mx-auto max-w-content px-6 py-24 sm:py-32">
            <h2 className="text-sm font-medium uppercase tracking-widest text-muted">
              Products
            </h2>
            <div className="mt-10 grid gap-6 sm:grid-cols-2">
              <ProductCard
                name="AMS — Asset Management System"
                description="Track, manage, and report business assets simply."
                href="https://ams.minidigital.dev"
              />
              <ProductCard
                name="SMART System"
                description="Business automation and productivity platform."
                href="https://smart.minidigital.dev"
              />
            </div>
          </div>
        </section>

        {/* Philosophy */}
        <section className="border-t border-line bg-mist">
          <div className="mx-auto max-w-content px-6 py-24 sm:py-32">
            <h2 className="text-sm font-medium uppercase tracking-widest text-muted">
              Philosophy
            </h2>
            <div className="mt-10 grid gap-10 sm:grid-cols-3">
              {philosophy.map((statement) => (
                <p
                  key={statement}
                  className="text-xl font-medium leading-snug tracking-tight sm:text-2xl"
                >
                  {statement}
                </p>
              ))}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </>
  );
}
