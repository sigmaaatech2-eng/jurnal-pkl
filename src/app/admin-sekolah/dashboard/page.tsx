import AppLayout from '@/components/layout/AppLayout';
import { getSessionUser } from '@/lib/auth';
import { prisma } from '@/lib/prisma';
import Link from 'next/link';
import { Users, Briefcase, GraduationCap, Building, UserCheck, ChevronRight } from 'lucide-react';

export default async function AdminSekolahDashboardPage() {
  const user = await getSessionUser();
  if (!user) return null;

  const [studentCount, majorCount, classCount, placementCount] = await Promise.all([
    prisma.user.count({ where: { role: 'siswa' } }),
    prisma.schoolMajor.count(),
    prisma.schoolClass.count(),
    prisma.internship.count(),
  ]);

  return (
    <AppLayout user={user}>
      <div className="space-y-6">
        <div className="rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 sm:p-8 text-white shadow-xl shadow-blue-600/20">
          <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3">
            Admin Sekolah
          </span>
          <h1 className="text-xl sm:text-2xl font-black">Selamat datang, {user.name}! 🏫</h1>
          <p className="text-xs sm:text-sm text-blue-100 mt-1 max-w-2xl leading-relaxed">
            Kelola data master jurusan, kelas, pendaftaran akun siswa, serta penempatan PKL untuk seluruh siswa.
          </p>
        </div>

        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Total Siswa</span>
            <p className="text-2xl font-extrabold text-slate-800 dark:text-white mt-3">{studentCount}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Penempatan PKL</span>
            <p className="text-2xl font-extrabold text-blue-600 dark:text-blue-400 mt-3">{placementCount}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Data Jurusan</span>
            <p className="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-3">{majorCount}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Data Kelas</span>
            <p className="text-2xl font-extrabold text-purple-600 dark:text-purple-400 mt-3">{classCount}</p>
          </div>
        </div>

        {/* Quick Menu Links */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <Link
            href="/admin-sekolah/students"
            className="p-5 rounded-3xl border border-slate-200/80 bg-white dark:border-slate-800 dark:bg-slate-900 hover:border-blue-500/50 transition flex items-center justify-between"
          >
            <div className="flex items-center gap-3">
              <Users className="w-5 h-5 text-blue-600" />
              <span className="text-xs font-bold text-slate-800 dark:text-white">Manajemen Data Siswa</span>
            </div>
            <ChevronRight className="w-4 h-4 text-slate-400" />
          </Link>

          <Link
            href="/admin-sekolah/internships"
            className="p-5 rounded-3xl border border-slate-200/80 bg-white dark:border-slate-800 dark:bg-slate-900 hover:border-blue-500/50 transition flex items-center justify-between"
          >
            <div className="flex items-center gap-3">
              <Briefcase className="w-5 h-5 text-indigo-600" />
              <span className="text-xs font-bold text-slate-800 dark:text-white">Penempatan PKL</span>
            </div>
            <ChevronRight className="w-4 h-4 text-slate-400" />
          </Link>

          <Link
            href="/admin-sekolah/school-data/majors"
            className="p-5 rounded-3xl border border-slate-200/80 bg-white dark:border-slate-800 dark:bg-slate-900 hover:border-blue-500/50 transition flex items-center justify-between"
          >
            <div className="flex items-center gap-3">
              <GraduationCap className="w-5 h-5 text-purple-600" />
              <span className="text-xs font-bold text-slate-800 dark:text-white">Data Jurusan & Kelas</span>
            </div>
            <ChevronRight className="w-4 h-4 text-slate-400" />
          </Link>
        </div>
      </div>
    </AppLayout>
  );
}
