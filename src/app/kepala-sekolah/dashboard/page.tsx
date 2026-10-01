import AppLayout from '@/components/layout/AppLayout';
import { getSessionUser } from '@/lib/auth';
import { prisma } from '@/lib/prisma';

export default async function KepalaSekolahDashboardPage() {
  const sessionUser = await getSessionUser();
  if (!sessionUser) return null;

  const [dbUser, studentCount, journalCount, attendanceCount] = await Promise.all([
    prisma.user.findUnique({ where: { id: sessionUser.id } }),
    prisma.user.count({ where: { role: 'siswa' } }),
    prisma.journal.count(),
    prisma.attendance.count(),
  ]);

  return (
    <AppLayout user={sessionUser}>
      <div className="space-y-6">
        <div className="rounded-3xl bg-gradient-to-r from-purple-600 to-indigo-600 p-6 sm:p-8 text-white shadow-xl shadow-purple-600/20">
          <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3">
            Kepala Sekolah
          </span>
          <h1 className="text-xl sm:text-2xl font-black">Selamat datang, {sessionUser.name}! 👔</h1>
          <p className="text-xs sm:text-sm text-purple-100 mt-1 max-w-2xl leading-relaxed">
            NIP: {dbUser?.nip || '196805121993031005'} | {dbUser?.school_name || 'SMK Negeri 1 Indonesia'}
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Total Siswa Terdaftar</span>
            <p className="text-2xl font-extrabold text-slate-800 dark:text-white mt-3">{studentCount}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Total Jurnal Terinput</span>
            <p className="text-2xl font-extrabold text-purple-600 dark:text-purple-400 mt-3">{journalCount}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Total Presensi Kehadiran</span>
            <p className="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-3">{attendanceCount}</p>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
