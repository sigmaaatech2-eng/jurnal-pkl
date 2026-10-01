import AppLayout from '@/components/layout/AppLayout';
import { getSessionUser } from '@/lib/auth';
import { prisma } from '@/lib/prisma';
import Link from 'next/link';
import { BookOpen, CalendarCheck, CheckCircle2, Clock, AlertCircle, Plus, Building2, User, ChevronRight } from 'lucide-react';

export default async function SiswaDashboardPage() {
  const user = await getSessionUser();
  if (!user) return null;

  const today = new Date().toISOString().split('T')[0];

  // Fetch student stats
  const [journals, attendances, internship] = await Promise.all([
    prisma.journal.findMany({
      where: { student_id: user.id },
      orderBy: { date: 'desc' },
      take: 5,
    }),
    prisma.attendance.findMany({
      where: { student_id: user.id },
      orderBy: { date: 'desc' },
    }),
    prisma.internship.findFirst({
      where: { student_id: user.id, status: 'active' },
      include: { mentor: true, teacher: true },
    }),
  ]);

  const totalJournals = journals.length;
  const approvedJournals = journals.filter((j) => j.status === 'approved').length;
  const pendingJournals = journals.filter((j) => j.status === 'pending').length;
  const todayAttendance = attendances.find((a) => a.date === today);

  return (
    <AppLayout user={user}>
      <div className="space-y-6">
        {/* Welcome Banner */}
        <div className="rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 sm:p-8 text-white shadow-xl shadow-blue-600/20">
          <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3">
            Siswa PKL
          </span>
          <h1 className="text-xl sm:text-2xl font-black">Selamat datang, {user.name}! 👋</h1>
          <p className="text-xs sm:text-sm text-blue-100 mt-1 max-w-2xl leading-relaxed">
            Pantau dan catat kegiatan harian PKL Anda secara berkala serta pastikan absensi kehadiran Anda selalu terisi dengan benar.
          </p>
        </div>

        {/* Quick Stats Grid */}
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <div className="flex items-center justify-between">
              <span className="text-xs font-semibold text-slate-500">Total Jurnal</span>
              <div className="p-2.5 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                <BookOpen className="w-5 h-5" />
              </div>
            </div>
            <p className="text-2xl font-extrabold text-slate-800 dark:text-white mt-3">{totalJournals}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <div className="flex items-center justify-between">
              <span className="text-xs font-semibold text-slate-500">Jurnal Disetujui</span>
              <div className="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                <CheckCircle2 className="w-5 h-5" />
              </div>
            </div>
            <p className="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-3">{approvedJournals}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <div className="flex items-center justify-between">
              <span className="text-xs font-semibold text-slate-500">Pending Review</span>
              <div className="p-2.5 rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                <Clock className="w-5 h-5" />
              </div>
            </div>
            <p className="text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-3">{pendingJournals}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <div className="flex items-center justify-between">
              <span className="text-xs font-semibold text-slate-500">Absensi Hari Ini</span>
              <div className="p-2.5 rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-500/10 dark:text-purple-400">
                <CalendarCheck className="w-5 h-5" />
              </div>
            </div>
            <p className="text-xs font-bold mt-4">
              {todayAttendance ? (
                <span className="text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2.5 py-1 rounded-lg">
                  Hadir ({todayAttendance.check_in})
                </span>
              ) : (
                <span className="text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10 px-2.5 py-1 rounded-lg">
                  Belum Absen
                </span>
              )}
            </p>
          </div>
        </div>

        {/* Internship Info & Quick Actions */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* Internship Placement Card */}
          <div className="lg:col-span-2 rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <h3 className="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
              <Building2 className="w-4 h-4 text-blue-600" /> Informasi Tempat PKL
            </h3>

            {internship ? (
              <div className="space-y-4">
                <div className="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                  <h4 className="text-base font-extrabold text-blue-600 dark:text-blue-400">{internship.company_name}</h4>
                  <p className="text-xs text-slate-500 mt-1">{internship.company_address}</p>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div className="p-3.5 rounded-xl border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <div className="p-2 rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                      <User className="w-4 h-4" />
                    </div>
                    <div>
                      <p className="text-[10px] text-slate-400 font-semibold">Mentor Industri</p>
                      <p className="text-xs font-bold text-slate-700 dark:text-slate-200">{internship.mentor?.name || '-'}</p>
                    </div>
                  </div>

                  <div className="p-3.5 rounded-xl border border-slate-100 dark:border-slate-800 flex items-center gap-3">
                    <div className="p-2 rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                      <User className="w-4 h-4" />
                    </div>
                    <div>
                      <p className="text-[10px] text-slate-400 font-semibold">Guru Pembimbing</p>
                      <p className="text-xs font-bold text-slate-700 dark:text-slate-200">{internship.teacher?.name || '-'}</p>
                    </div>
                  </div>
                </div>
              </div>
            ) : (
              <div className="p-6 text-center text-slate-400 text-xs">
                Belum ada penempatan PKL aktif. Silakan hubungi Admin Sekolah.
              </div>
            )}
          </div>

          {/* Quick Action Box */}
          <div className="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm flex flex-col justify-between">
            <div>
              <h3 className="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-2">Aksi Cepat</h3>
              <p className="text-xs text-slate-500 mb-6">Pilih menu di bawah untuk pengisian cepat hari ini.</p>
            </div>

            <div className="space-y-3">
              <Link
                href="/siswa/journals/create"
                className="w-full flex items-center justify-between p-3.5 rounded-2xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-500 transition shadow-lg shadow-blue-600/20"
              >
                <span className="flex items-center gap-2">
                  <Plus className="w-4 h-4" /> Tambah Jurnal PKL
                </span>
                <ChevronRight className="w-4 h-4" />
              </Link>

              <Link
                href="/siswa/attendances"
                className="w-full flex items-center justify-between p-3.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold text-xs hover:bg-slate-200 dark:hover:bg-slate-700 transition"
              >
                <span className="flex items-center gap-2">
                  <CalendarCheck className="w-4 h-4 text-purple-600" /> Presensi Kehadiran
                </span>
                <ChevronRight className="w-4 h-4" />
              </Link>
            </div>
          </div>
        </div>

        {/* Recent Journals List */}
        <div className="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
          <div className="flex items-center justify-between mb-6">
            <h3 className="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Jurnal Terakhir</h3>
            <Link href="/siswa/journals" className="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
              Lihat Semua
            </Link>
          </div>

          <div className="space-y-3">
            {journals.length > 0 ? (
              journals.map((j) => (
                <div key={j.id} className="p-4 rounded-2xl border border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                  <div>
                    <span className="text-[10px] font-bold text-slate-400">{j.date}</span>
                    <h4 className="text-sm font-bold text-slate-800 dark:text-slate-100 mt-0.5">{j.title}</h4>
                    <p className="text-xs text-slate-500 line-clamp-1 mt-1">{j.description}</p>
                  </div>
                  <div>
                    {j.status === 'approved' && (
                      <span className="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 text-xs font-bold">
                        Approved
                      </span>
                    )}
                    {j.status === 'pending' && (
                      <span className="px-3 py-1 rounded-full bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 text-xs font-bold">
                        Pending
                      </span>
                    )}
                    {j.status === 'revision' && (
                      <span className="px-3 py-1 rounded-full bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400 text-xs font-bold">
                        Revisi
                      </span>
                    )}
                  </div>
                </div>
              ))
            ) : (
              <p className="text-center py-6 text-xs text-slate-400">Belum ada jurnal yang diinput.</p>
            )}
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
