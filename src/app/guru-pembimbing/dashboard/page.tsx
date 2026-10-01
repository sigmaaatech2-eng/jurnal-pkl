import AppLayout from '@/components/layout/AppLayout';
import { getSessionUser } from '@/lib/auth';
import { prisma } from '@/lib/prisma';
import Link from 'next/link';
import { Users, BookOpen, CalendarCheck, BarChart3, ChevronRight, CheckCircle2, Clock } from 'lucide-react';

export default async function GuruDashboardPage() {
  const user = await getSessionUser();
  if (!user) return null;

  // Fetch assigned students and journals
  const [internships, pendingJournals] = await Promise.all([
    prisma.internship.findMany({
      where: { teacher_id: user.id },
      include: { student: true, mentor: true },
    }),
    prisma.journal.findMany({
      where: { status: 'pending' },
      include: { student: true },
      take: 5,
    }),
  ]);

  const studentCount = internships.length;

  return (
    <AppLayout user={user}>
      <div className="space-y-6">
        {/* Banner */}
        <div className="rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-600 p-6 sm:p-8 text-white shadow-xl shadow-emerald-600/20">
          <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3">
            Guru Pembimbing
          </span>
          <h1 className="text-xl sm:text-2xl font-black">Selamat datang, {user.name}! 👨‍🏫</h1>
          <p className="text-xs sm:text-sm text-emerald-100 mt-1 max-w-2xl leading-relaxed">
            Monitor perkembangan siswa bimbingan Anda, periksa jurnal harian, serta lakukan evaluasi rekapitulasi nilai PKL.
          </p>
        </div>

        {/* Stats */}
        <div className="grid grid-cols-2 lg:grid-cols-3 gap-4">
          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <div className="flex items-center justify-between">
              <span className="text-xs font-semibold text-slate-500">Siswa Bimbingan</span>
              <div className="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                <Users className="w-5 h-5" />
              </div>
            </div>
            <p className="text-2xl font-extrabold text-slate-800 dark:text-white mt-3">{studentCount}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <div className="flex items-center justify-between">
              <span className="text-xs font-semibold text-slate-500">Jurnal Pending</span>
              <div className="p-2.5 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                <Clock className="w-5 h-5" />
              </div>
            </div>
            <p className="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-3">{pendingJournals.length}</p>
          </div>

          <div className="col-span-2 lg:col-span-1 rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm flex items-center justify-between">
            <div>
              <span className="text-xs font-semibold text-slate-500">Rekap Nilai PKL</span>
              <p className="text-xs text-slate-400 mt-1">Export laporan ke Excel & PDF</p>
            </div>
            <Link
              href="/guru-pembimbing/recap"
              className="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition shadow-md shadow-emerald-600/20"
            >
              Lihat Rekap
            </Link>
          </div>
        </div>

        {/* Assigned Students */}
        <div className="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
          <h3 className="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4">
            Daftar Siswa Bimbingan
          </h3>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {internships.map((i) => (
              <div key={i.id} className="p-4 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/40">
                <h4 className="text-sm font-bold text-slate-800 dark:text-white">{i.student.name}</h4>
                <p className="text-xs text-blue-600 dark:text-blue-400 font-medium">{i.student.kelas || 'Siswa PKL'}</p>
                <div className="mt-3 pt-3 border-t border-slate-200/60 dark:border-slate-800 text-[11px] text-slate-500 space-y-1">
                  <p><span className="font-semibold text-slate-700 dark:text-slate-300">Perusahaan:</span> {i.company_name}</p>
                  <p><span className="font-semibold text-slate-700 dark:text-slate-300">Mentor:</span> {i.mentor?.name || '-'}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
