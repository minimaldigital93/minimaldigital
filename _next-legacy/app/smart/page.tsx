import type { Metadata } from "next";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

export const metadata: Metadata = {
  title: "SMART System",
  description:
    "A productivity and automation platform for modern businesses.",
};

const features = [
  {
    name: "Workflow automation",
    description:
      "Automate repetitive processes so your team focuses on real work.",
  },
  {
    name: "Smart dashboards",
    description:
      "One clear view of everything that matters, updated in real time.",
  },
  {
    name: "Data insights",
    description:
      "Turn operational data into decisions — without the noise.",
  },
];

export default function SmartPage() {
  return (
    <>
      <Navbar productName="SMART" />
      <main>
        <section className="mx-auto max-w-content px-6 pb-24 pt-28 text-center sm:pb-32 sm:pt-40">
          <p className="text-sm font-medium uppercase tracking-widest text-muted">
            Productivity &amp; Automation
          </p>
          <h1 className="mx-auto mt-4 max-w-2xl text-4xl font-semibold tracking-tight sm:text-6xl">
            SMART System
          </h1>
          <p className="mx-auto mt-6 max-w-xl text-lg leading-relaxed text-muted">
            A productivity and automation platform for modern businesses.
          </p>
          <a
            href="mailto:contact@minidigital.dev?subject=SMART%20System"
            className="mt-10 inline-block rounded-full bg-ink px-7 py-3 text-sm font-medium text-paper transition-opacity hover:opacity-80"
          >
            Get Started
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
