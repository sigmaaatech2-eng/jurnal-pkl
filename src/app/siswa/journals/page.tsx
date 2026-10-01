import AppLayout from '@/components/layout/AppLayout';
import { getSessionUser } from '@/lib/auth';
import { prisma } from '@/lib/prisma';
import Link from 'next/link';
import { Plus, BookOpen, Clock, CheckCircle2, AlertCircle, FileText } from 'lucide-react';

export default async function SiswaJournalsPage() {
  const user = await getSessionUser();
  if (!user) return null;

  const journals = await prisma.journal.findMany({
    where: { student_id: user.id },
    orderBy: { date: 'desc' },
  });

  return (
    <AppLayout user={user}>
      <div className="space-y-6">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div>
            <h1 className="text-xl font-bold text-slate-800 dark:text-white">Jurnal Kegiatan Saya</h1>
            <p className="text-xs text-slate-500 mt-1">Daftar seluruh riwayat jurnal harian PKL yang telah Anda catat.</p>
          </div>

          <Link
            href="/siswa/journals/create"
            className="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-lg shadow-blue-600/20 transition"
          >
            <Plus className="w-4 h-4" /> Catat Jurnal Baru
          </Link>
        </div>

        <div className="space-y-4">
          {journals.length > 0 ? (
            journals.map((journal) => (
              <div
                key={journal.id}
                className="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm transition hover:border-blue-500/30"
              >
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                  <div>
                    <span className="text-[11px] font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 px-2.5 py-1 rounded-lg">
                      Tanggal: {journal.date}
                    </span>
                    <h3 className="text-base font-extrabold text-slate-800 dark:text-white mt-2">{journal.title}</h3>
                  </div>

                  <div>
                    {journal.status === 'approved' && (
                      <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 text-xs font-bold">
                        <CheckCircle2 className="w-4 h-4" /> Disetujui
                      </span>
                    )}
                    {journal.status === 'pending' && (
                      <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 text-xs font-bold">
                        <Clock className="w-4 h-4" /> Menunggu Review
                      </span>
                    )}
                    {journal.status === 'revision' && (
                      <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 text-xs font-bold">
                        <AlertCircle className="w-4 h-4" /> Perlu Revisi
                      </span>
                    )}
                  </div>
                </div>

                <div className="mt-4">
                  <p className="text-xs text-slate-600 dark:text-slate-300 whitespace-pre-line leading-relaxed">
                    {journal.description}
                  </p>
                </div>

                {journal.photo_attachment && (
                  <div className="mt-4">
                    <img
                      src={journal.photo_attachment}
                      alt="Dokumentasi"
                      className="max-h-48 rounded-2xl object-cover border border-slate-200 dark:border-slate-700"
                    />
                  </div>
                )}

                {(journal.feedback || journal.score !== null) && (
                  <div className="mt-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800">
                    <p className="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Feedback Mentor:</p>
                    {journal.score !== null && (
                      <span className="inline-block mt-1 text-xs font-black text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 px-2 py-0.5 rounded">
                        Nilai: {journal.score}/100
                      </span>
                    )}
                    {journal.feedback && (
                      <p className="text-xs text-slate-700 dark:text-slate-200 mt-1 font-medium italic">
                        "{journal.feedback}"
                      </p>
                    )}
                  </div>
                )}
              </div>
            ))
          ) : (
            <div className="rounded-3xl border border-slate-200/80 bg-white p-12 dark:border-slate-800 dark:bg-slate-900 text-center">
              <BookOpen className="w-12 h-12 text-slate-300 mx-auto mb-3" />
              <h3 className="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada jurnal</h3>
              <p className="text-xs text-slate-500 mt-1 mb-4">Klik tombol di atas untuk membuat catatan jurnal pertama Anda.</p>
            </div>
          )}
        </div>
      </div>
    </AppLayout>
  );
}
