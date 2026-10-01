import AppLayout from '@/components/layout/AppLayout';
import { getSessionUser } from '@/lib/auth';
import { prisma } from '@/lib/prisma';
import Link from 'next/link';
import { Users, Clock, ChevronRight } from 'lucide-react';

export default async function MentorDashboardPage() {
  const sessionUser = await getSessionUser();
  if (!sessionUser) return null;

  const [dbUser, internships, pendingJournals] = await Promise.all([
    prisma.user.findUnique({ where: { id: sessionUser.id } }),
    prisma.internship.findMany({
      where: { mentor_id: sessionUser.id },
      include: { student: true },
    }),
    prisma.journal.findMany({
      where: { status: 'pending' },
      include: { student: true },
    }),
  ]);

  return (
    <AppLayout user={sessionUser}>
      <div className="space-y-6">
        <div className="rounded-3xl bg-gradient-to-r from-amber-600 to-orange-600 p-6 sm:p-8 text-white shadow-xl shadow-amber-600/20">
          <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3">
            Mentor Industri
          </span>
          <h1 className="text-xl sm:text-2xl font-black">Selamat datang, {sessionUser.name}! 🏢</h1>
          <p className="text-xs sm:text-sm text-amber-100 mt-1 max-w-2xl leading-relaxed">
            Perusahaan: <span className="font-bold">{dbUser?.company_name || 'PT Solusi Teknologi Nusantara'}</span>
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <div className="flex items-center justify-between">
              <span className="text-xs font-semibold text-slate-500">Siswa Dibimbing</span>
              <Users className="w-5 h-5 text-amber-600" />
            </div>
            <p className="text-2xl font-extrabold text-slate-800 dark:text-white mt-3">{internships.length}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <div className="flex items-center justify-between">
              <span className="text-xs font-semibold text-slate-500">Jurnal Perlu Validasi</span>
              <Clock className="w-5 h-5 text-amber-600" />
            </div>
            <p className="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-3">{pendingJournals.length}</p>
          </div>
        </div>

        <div className="flex justify-end">
          <Link
            href="/mentor/journals"
            className="flex items-center gap-2 px-5 py-3 rounded-2xl bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs shadow-lg shadow-amber-600/20 transition"
          >
            Review & Validasi Jurnal Siswa <ChevronRight className="w-4 h-4" />
          </Link>
        </div>
      </div>
    </AppLayout>
  );
}
