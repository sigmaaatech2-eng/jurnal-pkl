'use client';

import React, { useState } from 'react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';
import { ArrowLeft, Save, AlertCircle, Image as ImageIcon } from 'lucide-react';

export default function CreateJournalPage() {
  const router = useRouter();
  const [date, setDate] = useState(new Date().toISOString().split('T')[0]);
  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [photoAttachment, setPhotoAttachment] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handlePhotoUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onloadend = () => {
        setPhotoAttachment(reader.result as string);
      };
      reader.readAsDataURL(file);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    try {
      const res = await fetch('/api/journals', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          date,
          title,
          description,
          photo_attachment: photoAttachment,
        }),
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.message || 'Gagal menyimpan jurnal.');
        setLoading(false);
        return;
      }

      router.push('/siswa/journals');
      router.refresh();
    } catch (err: any) {
      setError('Terjadi kesalahan koneksi.');
      setLoading(false);
    }
  };

  return (
    <div className="max-w-3xl mx-auto py-8 px-4">
      <Link
        href="/siswa/journals"
        className="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white transition mb-6"
      >
        <ArrowLeft className="w-4 h-4" /> Kembali ke Daftar Jurnal
      </Link>

      <div className="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-8 dark:border-slate-800 dark:bg-slate-900 shadow-xl">
        <h1 className="text-xl font-bold text-slate-800 dark:text-white mb-1">Catat Jurnal Kegiatan PKL</h1>
        <p className="text-xs text-slate-500 mb-6">Isi ringkasan pekerjaan atau tugas yang Anda kerjakan hari ini.</p>

        {error && (
          <div className="mb-6 flex items-center gap-3 rounded-2xl bg-red-500/10 border border-red-500/20 p-4 text-xs font-semibold text-red-400">
            <AlertCircle className="w-5 h-5 shrink-0" />
            <span>{error}</span>
          </div>
        )}

        <form onSubmit={handleSubmit} className="space-y-5">
          <div>
            <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
              Tanggal Kegiatan
            </label>
            <input
              type="date"
              required
              value={date}
              onChange={(e) => setDate(e.target.value)}
              className="block w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
              Judul Kegiatan / Topik Pekerjaan
            </label>
            <input
              type="text"
              required
              value={title}
              onChange={(e) => setTitle(e.target.value)}
              placeholder="Contoh: Membuat Modul Autentikasi User"
              className="block w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
              Deskripsi Detail Kegiatan
            </label>
            <textarea
              required
              rows={5}
              value={description}
              onChange={(e) => setDescription(e.target.value)}
              placeholder="Jelaskan secara singkat apa saja yang Anda kerjakan, kendala yang dihadapi, dan solusinya..."
              className="block w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>

          <div>
            <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
              Dokumentasi Foto (Opsional)
            </label>
            <input
              type="file"
              accept="image/*"
              onChange={handlePhotoUpload}
              className="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 dark:file:bg-blue-500/10 dark:file:text-blue-400"
            />
            {photoAttachment && (
              <img
                src={photoAttachment}
                alt="Preview"
                className="mt-3 max-h-40 rounded-xl object-cover border border-slate-200 dark:border-slate-800"
              />
            )}
          </div>

          <div className="pt-4 flex justify-end gap-3">
            <Link
              href="/siswa/journals"
              className="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
            >
              Batal
            </Link>

            <button
              type="submit"
              disabled={loading}
              className="flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-lg shadow-blue-600/20 transition disabled:opacity-50"
            >
              <Save className="w-4 h-4" /> {loading ? 'Menyimpan...' : 'Simpan Jurnal'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
