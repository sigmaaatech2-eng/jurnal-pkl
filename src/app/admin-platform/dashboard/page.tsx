import AppLayout from '@/components/layout/AppLayout';
import { getSessionUser } from '@/lib/auth';
import { prisma } from '@/lib/prisma';
import { Building, Package, CreditCard, Users, ShieldAlert } from 'lucide-react';

export default async function AdminPlatformDashboardPage() {
  const user = await getSessionUser();
  if (!user) return null;

  const [schoolCount, packageCount, userCount] = await Promise.all([
    prisma.schoolSubscription.count(),
    prisma.subscriptionPackage.count(),
    prisma.user.count(),
  ]);

  return (
    <AppLayout user={user}>
      <div className="space-y-6">
        <div className="rounded-3xl bg-gradient-to-r from-rose-600 to-red-600 p-6 sm:p-8 text-white shadow-xl shadow-rose-600/20">
          <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3">
            Admin Platform (Superadmin)
          </span>
          <h1 className="text-xl sm:text-2xl font-black">Platform SAAS Admin Dashboard 🚀</h1>
          <p className="text-xs sm:text-sm text-rose-100 mt-1 max-w-2xl leading-relaxed">
            Kelola langganan sekolah, paket fitur, persetujuan pembayaran, role permission, dan sistem platform.
          </p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Sekolah Berlangganan</span>
            <p className="text-2xl font-extrabold text-rose-600 dark:text-rose-400 mt-3">{schoolCount}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Paket Tersedia</span>
            <p className="text-2xl font-extrabold text-slate-800 dark:text-white mt-3">{packageCount}</p>
          </div>

          <div className="rounded-2xl border border-slate-200/80 bg-white p-5 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
            <span className="text-xs font-semibold text-slate-500">Pengguna Seluruh Platform</span>
            <p className="text-2xl font-extrabold text-blue-600 dark:text-blue-400 mt-3">{userCount}</p>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
