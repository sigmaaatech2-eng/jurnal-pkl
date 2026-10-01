'use client';

import React, { useState, useEffect } from 'react';
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import {
  Home,
  BookOpen,
  CalendarCheck,
  Users,
  Briefcase,
  UserCheck,
  GraduationCap,
  Building,
  Package,
  CheckCircle,
  CreditCard,
  ShieldAlert,
  Clock,
  BarChart3,
  User,
  Moon,
  Sun,
  LogOut,
  Menu,
  X,
  Bell,
  ChevronDown
} from 'lucide-react';

interface AppLayoutProps {
  children: React.ReactNode;
  user: {
    id: string;
    name: string;
    email: string;
    role: string;
    avatar?: string | null;
    jurusan?: string | null;
    kelas?: string | null;
  };
}

export default function AppLayout({ children, user }: AppLayoutProps) {
  const pathname = usePathname();
  const router = useRouter();
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [darkMode, setDarkMode] = useState(false);
  const [userDropdownOpen, setUserDropdownOpen] = useState(false);

  useEffect(() => {
    const savedTheme = localStorage.getItem('theme');
    const isDark = savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches);
    setDarkMode(isDark);
    if (isDark) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  }, []);

  const toggleDarkMode = () => {
    const nextDark = !darkMode;
    setDarkMode(nextDark);
    if (nextDark) {
      document.documentElement.classList.add('dark');
      localStorage.setItem('theme', 'dark');
    } else {
      document.documentElement.classList.remove('dark');
      localStorage.setItem('theme', 'light');
    }
  };

  const handleLogout = async () => {
    await fetch('/api/auth/logout', { method: 'POST' });
    router.push('/login');
    router.refresh();
  };

  const getRoleDisplayName = (role: string) => {
    switch (role) {
      case 'siswa':
        return 'Siswa PKL';
      case 'guru_pembimbing':
        return 'Guru Pembimbing';
      case 'mentor':
        return 'Mentor Industri';
      case 'admin_sekolah':
        return 'Admin Sekolah';
      case 'kepala_sekolah':
        return 'Kepala Sekolah';
      case 'admin_platform':
        return 'Admin Platform';
      default:
        return role;
    }
  };

  const getAvatarUrl = () => {
    if (user.avatar) return user.avatar;
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=2563eb&color=ffffff&bold=true`;
  };

  const navLinks = () => {
    switch (user.role) {
      case 'siswa':
        return [
          { href: '/siswa/dashboard', label: 'Dashboard', icon: Home },
          { href: '/siswa/journals', label: 'Jurnal Saya', icon: BookOpen },
          { href: '/siswa/attendances', label: 'Absensi', icon: CalendarCheck },
        ];
      case 'guru_pembimbing':
        return [
          { href: '/guru-pembimbing/dashboard', label: 'Dashboard', icon: Home },
          { href: '/guru-pembimbing/journals', label: 'Monitoring Jurnal', icon: BookOpen },
          { href: '/guru-pembimbing/students', label: 'Siswa Bimbingan', icon: Users },
          { href: '/guru-pembimbing/attendances', label: 'Monitoring Absensi', icon: CalendarCheck },
          { href: '/guru-pembimbing/recap', label: 'Rekap PKL', icon: BarChart3 },
        ];
      case 'mentor':
        return [
          { href: '/mentor/dashboard', label: 'Dashboard', icon: Home },
          { href: '/mentor/students', label: 'Daftar Siswa', icon: Users },
          { href: '/mentor/journals', label: 'Jurnal Siswa', icon: BookOpen },
        ];
      case 'admin_sekolah':
        return [
          { href: '/admin-sekolah/dashboard', label: 'Dashboard', icon: Home },
          { href: '/admin-sekolah/students', label: 'Data Siswa', icon: Users },
          { href: '/admin-sekolah/internships', label: 'Penempatan PKL', icon: Briefcase },
          { href: '/admin-sekolah/users', label: 'Manajemen User', icon: UserCheck },
          { href: '/admin-sekolah/school-data/majors', label: 'Data Jurusan', icon: GraduationCap },
          { href: '/admin-sekolah/school-data/classes', label: 'Data & Form Kelas', icon: Building },
        ];
      case 'kepala_sekolah':
        return [
          { href: '/kepala-sekolah/dashboard', label: 'Dashboard', icon: Home },
          { href: '/kepala-sekolah/students', label: 'Monitoring Siswa', icon: Users },
          { href: '/kepala-sekolah/journals', label: 'Monitoring Jurnal', icon: BookOpen },
          { href: '/kepala-sekolah/attendances', label: 'Monitoring Absensi', icon: CalendarCheck },
          { href: '/kepala-sekolah/recap', label: 'Rekap PKL', icon: BarChart3 },
        ];
      case 'admin_platform':
        return [
          { href: '/admin-platform/dashboard', label: 'Dashboard', icon: Home },
          { href: '/admin-platform/schools', label: 'Subscriber Sekolah', icon: Building },
          { href: '/admin-platform/packages', label: 'Kelola Paket', icon: Package },
          { href: '/admin-platform/approvals', label: 'Persetujuan Langganan', icon: CheckCircle },
          { href: '/admin-platform/payments', label: 'Riwayat Pembayaran', icon: CreditCard },
          { href: '/admin-platform/users', label: 'Kelola User', icon: Users },
          { href: '/admin-platform/roles', label: 'Role & Permission', icon: ShieldAlert },
          { href: '/admin-platform/logs', label: 'Log Aktivitas', icon: Clock },
          { href: '/admin-platform/reports', label: 'Laporan Platform', icon: BarChart3 },
        ];
      default:
        return [];
    }
  };

  const links = navLinks();

  return (
    <div className="flex min-h-screen bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-[#070b18] dark:text-slate-100">
      {/* Mobile Overlay */}
      {sidebarOpen && (
        <div
          onClick={() => setSidebarOpen(false)}
          className="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden transition-opacity duration-300"
        />
      )}

      {/* Sidebar */}
      <aside
        className={`fixed inset-y-0 left-0 z-50 flex w-[280px] sm:w-[290px] flex-col border-r border-slate-200/80 bg-white transition-transform duration-300 ease-in-out dark:border-slate-800 dark:bg-slate-900 lg:static lg:translate-x-0 lg:shadow-none ${
          sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'
        }`}
      >
        {/* Sidebar Header / Logo */}
        <div className="flex h-16 sm:h-20 items-center justify-between px-6 border-b border-slate-100 dark:border-slate-800">
          <Link href="/dashboard" className="flex items-center gap-3">
            <div className="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl bg-blue-600 text-white font-black text-lg shadow-md shadow-blue-500/20">
              PKL
            </div>
            <div>
              <h1 className="text-sm font-bold tracking-[0.16em] text-slate-800 dark:text-white">
                JURNAL <span className="text-blue-600">PKL</span>
              </h1>
              <p className="text-[9px] tracking-[0.3em] text-slate-400 font-semibold">ONLINE</p>
            </div>
          </Link>

          <button
            onClick={() => setSidebarOpen(false)}
            className="lg:hidden flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800"
          >
            <X className="h-5 w-5" />
          </button>
        </div>

        {/* Sidebar Nav Items */}
        <nav className="flex-1 overflow-y-auto px-4 py-6 custom-scrollbar">
          <p className="mb-3 px-3 text-[11px] font-bold tracking-wider uppercase text-slate-400">
            MENU UTAMA
          </p>

          <div className="space-y-1">
            {links.map((link) => {
              const Icon = link.icon;
              const isActive = pathname === link.href || (link.href !== '/siswa/dashboard' && link.href !== '/guru-pembimbing/dashboard' && link.href !== '/mentor/dashboard' && link.href !== '/admin-sekolah/dashboard' && link.href !== '/kepala-sekolah/dashboard' && link.href !== '/admin-platform/dashboard' && pathname.startsWith(link.href));
              return (
                <Link
                  key={link.href}
                  href={link.href}
                  onClick={() => setSidebarOpen(false)}
                  className={`flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition ${
                    isActive
                      ? 'bg-blue-50 text-blue-600 font-semibold dark:bg-blue-500/10 dark:text-blue-400'
                      : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800/60'
                  }`}
                >
                  <Icon className="h-5 w-5" />
                  <span>{link.label}</span>
                </Link>
              );
            })}
          </div>

          <p className="mb-3 mt-6 px-3 text-[11px] font-bold tracking-wider uppercase text-slate-400">
            PENGATURAN
          </p>
          <Link
            href="/profile"
            onClick={() => setSidebarOpen(false)}
            className={`flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition ${
              pathname.startsWith('/profile')
                ? 'bg-blue-50 text-blue-600 font-semibold dark:bg-blue-500/10 dark:text-blue-400'
                : 'text-slate-600 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800/60'
            }`}
          >
            <User className="h-5 w-5" />
            <span>Profil Saya</span>
          </Link>
        </nav>

        {/* User Badge Footer */}
        <div className="p-4 border-t border-slate-100 dark:border-slate-800">
          <div className="flex items-center gap-3 rounded-xl bg-slate-50 p-3 dark:bg-slate-800/50">
            <img
              src={getAvatarUrl()}
              alt={user.name}
              className="h-9 w-9 rounded-full object-cover border border-slate-200 dark:border-slate-700"
            />
            <div className="flex-1 overflow-hidden">
              <p className="truncate text-xs font-semibold text-slate-800 dark:text-slate-100">{user.name}</p>
              <p className="truncate text-[10px] text-blue-600 dark:text-blue-400 font-medium">{getRoleDisplayName(user.role)}</p>
            </div>
          </div>
        </div>
      </aside>

      {/* Main Content Area */}
      <div className="flex flex-1 flex-col overflow-hidden min-w-0">
        {/* Header Bar */}
        <header className="sticky top-0 z-30 flex h-16 sm:h-20 items-center justify-between border-b border-slate-200/80 bg-white/80 px-4 sm:px-8 backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/80">
          <div className="flex items-center gap-3">
            <button
              onClick={() => setSidebarOpen(true)}
              className="flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 lg:hidden"
            >
              <Menu className="h-6 w-6" />
            </button>
            <h2 className="text-base sm:text-lg font-bold text-slate-800 dark:text-white truncate">
              {getRoleDisplayName(user.role)}
            </h2>
          </div>

          <div className="flex items-center gap-2 sm:gap-3">
            {/* Dark mode toggle */}
            <button
              onClick={toggleDarkMode}
              className="flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 transition"
              title="Toggle Theme"
            >
              {darkMode ? <Sun className="h-5 w-5 text-amber-400" /> : <Moon className="h-5 w-5 text-slate-600" />}
            </button>

            {/* Logout button */}
            <button
              onClick={handleLogout}
              className="flex items-center gap-2 rounded-xl bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20 transition"
            >
              <LogOut className="h-4 w-4" />
              <span className="hidden sm:inline">Keluar</span>
            </button>
          </div>
        </header>

        {/* Dynamic Page Content */}
        <main className="flex-1 overflow-y-auto p-4 sm:p-8 custom-scrollbar">
          {children}
        </main>
      </div>
    </div>
  );
}
