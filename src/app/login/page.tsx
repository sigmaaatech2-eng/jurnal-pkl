'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { Lock, Mail, AlertCircle, ArrowRight, CheckCircle2, UserCheck } from 'lucide-react';

export default function LoginPage() {
  const router = useRouter();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [remember, setRemember] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handleLogin = async (e?: React.FormEvent, customEmail?: string, customPassword?: string) => {
    if (e) e.preventDefault();

    setError('');
    setLoading(true);

    const loginEmail = customEmail || email;
    const loginPassword = customPassword || password;

    try {
      const res = await fetch('/api/auth/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: loginEmail, password: loginPassword, remember }),
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.message || 'Login gagal.');
        setLoading(false);
        return;
      }

      router.push('/dashboard');
      router.refresh();
    } catch (err: any) {
      setError('Terjadi kesalahan koneksi.');
      setLoading(false);
    }
  };

  const quickLoginActors = [
    { role: 'Siswa PKL', email: 'siswa@sekolah.sch.id', pass: 'password', badge: 'bg-blue-500/10 text-blue-400 border-blue-500/20' },
    { role: 'Guru Pembimbing', email: 'guru@sekolah.sch.id', pass: 'password', badge: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' },
    { role: 'Mentor Industri', email: 'mentor@perusahaan.com', pass: 'password', badge: 'bg-amber-500/10 text-amber-400 border-amber-500/20' },
    { role: 'Admin Sekolah', email: 'admin.sekolah@jurnal-pkl.test', pass: 'password', badge: 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20' },
    { role: 'Kepala Sekolah', email: 'kepsek@sekolah.sch.id', pass: 'password', badge: 'bg-purple-500/10 text-purple-400 border-purple-500/20' },
    { role: 'Admin Platform', email: 'admin@platform.test', pass: 'password', badge: 'bg-rose-500/10 text-rose-400 border-rose-500/20' },
  ];

  return (
    <div className="min-h-screen bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 text-slate-100">
      <div className="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <Link href="/" className="inline-flex items-center gap-3 mb-4">
          <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white font-black text-xl shadow-lg shadow-blue-600/30">
            PKL
          </div>
        </Link>
        <h2 className="text-2xl font-black tracking-tight text-white">
          Masuk ke Jurnal PKL Online
        </h2>
        <p className="mt-2 text-xs text-slate-400">
          Silakan masukkan kredensial akun Anda untuk mengakses sistem.
        </p>
      </div>

      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
        <div className="bg-slate-900 border border-slate-800 py-8 px-6 shadow-2xl rounded-3xl sm:px-10">
          {error && (
            <div className="mb-6 flex items-center gap-3 rounded-2xl bg-red-500/10 border border-red-500/20 p-4 text-xs font-semibold text-red-400">
              <AlertCircle className="w-5 h-5 shrink-0" />
              <span>{error}</span>
            </div>
          )}

          <form className="space-y-5" onSubmit={(e) => handleLogin(e)}>
            <div>
              <label className="block text-xs font-semibold text-slate-300 mb-2">
                Alamat Email
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                  <Mail className="h-4 w-4" />
                </div>
                <input
                  type="email"
                  required
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="nama@email.com"
                  className="block w-full pl-10 pr-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                />
              </div>
            </div>

            <div>
              <label className="block text-xs font-semibold text-slate-300 mb-2">
                Password
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                  <Lock className="h-4 w-4" />
                </div>
                <input
                  type="password"
                  required
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="••••••••"
                  className="block w-full pl-10 pr-4 py-3 bg-slate-950 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                />
              </div>
            </div>

            <div className="flex items-center justify-between">
              <label className="flex items-center gap-2 text-xs text-slate-400 cursor-pointer">
                <input
                  type="checkbox"
                  checked={remember}
                  onChange={(e) => setRemember(e.target.checked)}
                  className="rounded border-slate-800 bg-slate-950 text-blue-600 focus:ring-blue-500"
                />
                Ingat saya
              </label>
            </div>

            <button
              type="submit"
              disabled={loading}
              className="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-lg shadow-blue-600/30 disabled:opacity-50"
            >
              {loading ? 'Memproses...' : 'Masuk Sekarang'}
              {!loading && <ArrowRight className="w-4 h-4" />}
            </button>
          </form>

          {/* Quick Login Section */}
          <div className="mt-8 pt-6 border-t border-slate-800">
            <div className="flex items-center gap-2 mb-3">
              <UserCheck className="w-4 h-4 text-blue-400" />
              <span className="text-xs font-bold text-slate-300 uppercase tracking-wider">
                Quick Login Aktor Pengujian
              </span>
            </div>
            <p className="text-[11px] text-slate-500 mb-4">
              Klik salah satu peran di bawah untuk login instant tanpa mengetik manual:
            </p>

            <div className="grid grid-cols-2 gap-2">
              {quickLoginActors.map((actor) => (
                <button
                  key={actor.email}
                  type="button"
                  onClick={() => {
                    setEmail(actor.email);
                    setPassword(actor.pass);
                    handleLogin(undefined, actor.email, actor.pass);
                  }}
                  className={`text-left p-2.5 rounded-xl border text-[11px] font-semibold transition hover:scale-[1.02] active:scale-95 ${actor.badge}`}
                >
                  <div className="font-bold truncate">{actor.role}</div>
                  <div className="text-[10px] opacity-75 truncate">{actor.email}</div>
                </button>
              ))}
            </div>
          </div>

          <div className="mt-6 text-center text-xs text-slate-400">
            Belum memiliki akun siswa?{' '}
            <Link href="/register" className="font-bold text-blue-400 hover:underline">
              Daftar disini
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
}
