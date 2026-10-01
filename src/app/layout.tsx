import type { Metadata } from 'next';
import './globals.css';

export const metadata: Metadata = {
  title: 'Jurnal PKL Online',
  description: 'Sistem Manajemen Jurnal & Presensi PKL Online',
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="id" suppressHydrationWarning>
      <body className="bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#070b18] dark:text-slate-100 antialiased">
        {children}
      </body>
    </html>
  );
}
