import type { Metadata } from "next";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

export const metadata: Metadata = {
  title: "AMS — Asset Management System",
  description:
    "A clean enterprise system to track, manage, and report assets efficiently.",
};

const features = [
  {
    name: "Asset tracking",
    description:
      "Every asset registered, located, and accounted for — in one place.",
  },
  {
    name: "Reporting dashboard",
    description:
      "Clear, real-time reports on asset value, status, and history.",
  },
  {
    name: "User roles & permissions",
    description:
      "Fine-grained access control so the right people see the right data.",
  },
];

export default function AmsPage() {
  return (
    <>
      <Navbar productName="AMS" />
      <main>
        <section className="mx-auto max-w-content px-6 pb-24 pt-28 text-center sm:pb-32 sm:pt-40">
          <p className="text-sm font-medium uppercase tracking-widest text-muted">
            Asset Management System
          </p>
          <h1 className="mx-auto mt-4 max-w-2xl text-4xl font-semibold tracking-tight sm:text-6xl">
            AMS
          </h1>
          <p className="mx-auto mt-6 max-w-xl text-lg leading-relaxed text-muted">
            A clean enterprise system to track, manage, and report assets
            efficiently.
          </p>
          <a
            href="mailto:contact@minidigital.dev?subject=AMS%20Demo%20Request"
            className="mt-10 inline-block rounded-full bg-ink px-7 py-3 text-sm font-medium text-paper transition-opacity hover:opacity-80"
          >
            Request Demo
          </a>
        </section>

        <section className="border-t border-line bg-mist">
          <div className="mx-auto max-w-content px-6 py-24 sm:py-32">
            <div className="grid gap-12 sm:grid-cols-3">
              {features.map((feature) => (
                <div key={feature.name}>
                  <h2 className="text-lg font-semibold tracking-tight">
                    {feature.name}
                  </h2>
                  <p className="mt-3 leading-relaxed text-muted">
                    {feature.description}
                  </p>
                </div>
              ))}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </>
  );
}
