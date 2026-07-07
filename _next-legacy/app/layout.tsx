import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: {
    default: "MinimalDigital — Minimal Digital. Maximum Impact.",
    template: "%s — MinimalDigital",
  },
  description:
    "We build simple, powerful digital systems that help businesses operate smarter.",
  metadataBase: new URL("https://minidigital.dev"),
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en">
      <body className="bg-paper font-sans text-ink">{children}</body>
    </html>
  );
}
