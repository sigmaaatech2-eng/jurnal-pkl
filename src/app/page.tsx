import Link from 'next/link';
import { BookOpen, CheckCircle, Shield, ArrowRight, UserCheck } from 'lucide-react';

export default function HomePage() {
  return (
    <div className="min-h-screen bg-slate-900 text-white selection:bg-blue-500 selection:text-white">
      {/* Header / Navbar */}
      <nav className="flex items-center justify-between px-6 py-5 max-w-7xl mx-auto border-b border-slate-800">
        <div className="flex items-center gap-3">
          <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white font-black text-lg shadow-lg shadow-blue-500/30">
            PKL
          </div>
          <div>
            <h1 className="text-sm font-bold tracking-[0.16em] text-white">
              JURNAL <span className="text-blue-500">PKL</span>
            </h1>
            <p className="text-[9px] tracking-[0.3em] text-slate-400 font-semibold">ONLINE</p>
          </div>
        </div>

        <div className="flex items-center gap-4">
          <Link
            href="/login"
            className="text-sm font-semibold text-slate-300 hover:text-white transition px-4 py-2"
          >
            Masuk
          </Link>
          <Link
            href="/register"
            className="text-sm font-semibold bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/30"
          >
            Daftar Siswa
          </Link>
        </div>
      </nav>

      {/* Hero Section */}
      <section className="max-w-7xl mx-auto px-6 py-20 text-center flex flex-col items-center">
        <span className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 text-xs font-semibold mb-6">
          <Shield className="w-4 h-4" /> Platform Manajemen PKL Modern & Terintegrasi
        </span>

        <h1 className="text-4xl sm:text-6xl font-extrabold tracking-tight max-w-4xl leading-tight">
          Sistem Jurnal & Absensi <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Praktek Kerja Lapangan</span>
        </h1>

        <p className="mt-6 text-slate-400 text-base sm:text-lg max-w-2xl leading-relaxed">
          Mempermudah siswa mencatat jurnal harian dan absensi lokasi, guru memonitor perkembangan, mentor memberikan penilaian langsung, serta sekolah mengelola rekapitulasi data PKL secara presisi.
        </p>

        <div className="mt-10 flex flex-wrap justify-center gap-4">
          <Link
            href="/login"
            className="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-bold px-7 py-3.5 rounded-2xl transition shadow-xl shadow-blue-600/30 text-sm"
          >
            Masuk ke Dashboard <ArrowRight className="w-4 h-4" />
          </Link>
          <Link
            href="/register"
            className="flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold px-7 py-3.5 rounded-2xl transition border border-slate-700 text-sm"
          >
            Registrasi Akun Siswa
          </Link>
        </div>
      </section>

      {/* Feature Cards */}
      <section className="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-slate-800/50 border border-slate-800 rounded-3xl p-8 hover:border-slate-700 transition">
          <div className="h-12 w-12 rounded-2xl bg-blue-500/10 text-blue-400 flex items-center justify-center mb-6">
            <BookOpen className="w-6 h-6" />
          </div>
          <h3 className="text-lg font-bold text-white mb-2">Pencatatan Jurnal Digital</h3>
          <p className="text-slate-400 text-sm leading-relaxed">
            Siswa dapat mengunggah dokumentasi foto kegiatan harian, catatan pekerjaan, dan memantau status persetujuan dari mentor industri.
          </p>
        </div>

        <div className="bg-slate-800/50 border border-slate-800 rounded-3xl p-8 hover:border-slate-700 transition">
          <div className="h-12 w-12 rounded-2xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-6">
            <CheckCircle className="w-6 h-6" />
          </div>
          <h3 className="text-lg font-bold text-white mb-2">Absensi Presisi Geolocation</h3>
          <p className="text-slate-400 text-sm leading-relaxed">
            Absensi masuk dan pulang dilengkapi koordinat GPS dan foto bukti kehadiran untuk menjamin keabsahan kehadiran siswa PKL.
          </p>
        </div>

        <div className="bg-slate-800/50 border border-slate-800 rounded-3xl p-8 hover:border-slate-700 transition">
          <div className="h-12 w-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-6">
            <UserCheck className="w-6 h-6" />
          </div>
          <h3 className="text-lg font-bold text-white mb-2">6 Role Aktor Terintegrasi</h3>
          <p className="text-slate-400 text-sm leading-relaxed">
            Mendukung akses penuh untuk Siswa, Guru Pembimbing, Mentor Industri, Admin Sekolah, Kepala Sekolah, dan Admin Platform.
          </p>
        </div>
      </section>

      {/* Footer */}
      <footer className="border-t border-slate-800 py-8 text-center text-slate-500 text-xs mt-12">
        © 2026 Jurnal PKL Online. Powered by Next.js & TypeScript on Vercel.
      </footer>
    </div>
  );
}
