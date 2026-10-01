'use client';

import React, { useState, useEffect } from 'react';
import AppLayout from '@/components/layout/AppLayout';
import { CalendarCheck, MapPin, Camera, CheckCircle2, Clock, LogOut, AlertCircle } from 'lucide-react';

export default function SiswaAttendancesPage() {
  const [user, setUser] = useState<any>(null);
  const [attendances, setAttendances] = useState<any[]>([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  const today = new Date().toISOString().split('T')[0];

  useEffect(() => {
    fetch('/api/auth/me')
      .then((res) => res.json())
      .then((data) => {
        if (data.user) setUser(data.user);
      });

    loadAttendances();
  }, []);

  const loadAttendances = async () => {
    try {
      const res = await fetch('/api/attendances');
      const data = await res.json();
      if (data.attendances) setAttendances(data.attendances);
    } catch (e) {}
  };

  const handleAttendance = async (action: 'check_in' | 'check_out') => {
    setError('');
    setSuccess('');
    setLoading(true);

    // Capture location if available
    let locationStr = '';
    if (navigator.geolocation) {
      try {
        const position: any = await new Promise((resolve, reject) => {
          navigator.geolocation.getCurrentPosition(resolve, reject, { timeout: 5000 });
        });
        locationStr = `${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)}`;
      } catch (e) {
        locationStr = 'Lokasi tidak diaktifkan';
      }
    }

    try {
      const res = await fetch('/api/attendances', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action,
          location: locationStr,
          status: 'present',
        }),
      });

      const data = await res.json();

      if (!res.ok) {
        setError(data.message || 'Gagal memproses absensi.');
        setLoading(false);
        return;
      }

      setSuccess(data.message);
      setLoading(false);
      loadAttendances();
    } catch (err: any) {
      setError('Terjadi kesalahan sistem.');
      setLoading(false);
    }
  };

  const todayRecord = attendances.find((a) => a.date === today);

  return (
    <AppLayout user={user || { name: 'Siswa PKL', email: '', role: 'siswa' }}>
      <div className="space-y-6">
        <div>
          <h1 className="text-xl font-bold text-slate-800 dark:text-white">Presensi Kehadiran PKL</h1>
          <p className="text-xs text-slate-500 mt-1">Lakukan absensi masuk dan pulang setiap hari kerja saat di tempat PKL.</p>
        </div>

        {error && (
          <div className="flex items-center gap-3 rounded-2xl bg-red-500/10 border border-red-500/20 p-4 text-xs font-semibold text-red-400">
            <AlertCircle className="w-5 h-5 shrink-0" />
            <span>{error}</span>
          </div>
        )}

        {success && (
          <div className="flex items-center gap-3 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 p-4 text-xs font-semibold text-emerald-400">
            <CheckCircle2 className="w-5 h-5 shrink-0" />
            <span>{success}</span>
          </div>
        )}

        {/* Check-In / Check-Out Widget */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm flex flex-col justify-between">
            <div>
              <div className="flex items-center justify-between mb-4">
                <span className="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                  Absensi Masuk
                </span>
                <Clock className="w-5 h-5 text-blue-500" />
              </div>
              <p className="text-2xl font-black text-slate-800 dark:text-white">
                {todayRecord?.check_in ? todayRecord.check_in : '--:--:--'}
              </p>
              <p className="text-xs text-slate-400 mt-1">
                {todayRecord?.check_in ? 'Sudah absen masuk' : 'Belum melakukan absensi masuk'}
              </p>
            </div>

            <button
              onClick={() => handleAttendance('check_in')}
              disabled={loading || !!todayRecord?.check_in}
              className="mt-6 w-full flex items-center justify-center gap-2 py-3 px-4 rounded-2xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 transition shadow-lg shadow-blue-600/20 disabled:opacity-50"
            >
              <MapPin className="w-4 h-4" /> {todayRecord?.check_in ? 'Sudah Absen Masuk' : 'Absen Masuk Sekarang'}
            </button>
          </div>

          <div className="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm flex flex-col justify-between">
            <div>
              <div className="flex items-center justify-between mb-4">
                <span className="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider">
                  Absensi Pulang
                </span>
                <LogOut className="w-5 h-5 text-purple-500" />
              </div>
              <p className="text-2xl font-black text-slate-800 dark:text-white">
                {todayRecord?.check_out ? todayRecord.check_out : '--:--:--'}
              </p>
              <p className="text-xs text-slate-400 mt-1">
                {todayRecord?.check_out ? 'Sudah absen pulang' : 'Belum melakukan absensi pulang'}
              </p>
            </div>

            <button
              onClick={() => handleAttendance('check_out')}
              disabled={loading || !todayRecord?.check_in || !!todayRecord?.check_out}
              className="mt-6 w-full flex items-center justify-center gap-2 py-3 px-4 rounded-2xl text-xs font-bold text-white bg-purple-600 hover:bg-purple-500 transition shadow-lg shadow-purple-600/20 disabled:opacity-50"
            >
              <MapPin className="w-4 h-4" /> {todayRecord?.check_out ? 'Sudah Absen Pulang' : 'Absen Pulang Sekarang'}
            </button>
          </div>
        </div>

        {/* History Table */}
        <div className="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
          <h3 className="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4">
            Riwayat Absensi Saya
          </h3>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs">
              <thead className="border-b border-slate-100 dark:border-slate-800 text-slate-400 uppercase text-[10px] font-bold">
                <tr>
                  <th className="py-3 px-4">Tanggal</th>
                  <th className="py-3 px-4">Jam Masuk</th>
                  <th className="py-3 px-4">Jam Pulang</th>
                  <th className="py-3 px-4">Status</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
                {attendances.length > 0 ? (
                  attendances.map((item) => (
                    <tr key={item.id} className="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                      <td className="py-3 px-4 font-semibold text-slate-800 dark:text-slate-200">{item.date}</td>
                      <td className="py-3 px-4 text-emerald-600 font-semibold">{item.check_in || '-'}</td>
                      <td className="py-3 px-4 text-purple-600 font-semibold">{item.check_out || '-'}</td>
                      <td className="py-3 px-4">
                        <span className="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                          {item.status === 'present' ? 'Hadir' : item.status}
                        </span>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan={4} className="py-6 text-center text-slate-400">Belum ada riwayat absensi.</td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
