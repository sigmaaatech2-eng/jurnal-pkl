'use client';

import React, { useState, useEffect, useRef } from 'react';
import AppLayout from '@/components/layout/AppLayout';
import { CalendarCheck, MapPin, Camera, CheckCircle2, Clock, LogOut, AlertCircle, X, Eye } from 'lucide-react';

export default function SiswaAttendancesPage() {
  const [user, setUser] = useState<any>(null);
  const [attendances, setAttendances] = useState<any[]>([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  // Camera UX States
  const [cameraOpen, setCameraOpen] = useState(false);
  const [activeAction, setActiveAction] = useState<'check_in' | 'check_out'>('check_in');
  const [capturedPhoto, setCapturedPhoto] = useState<string | null>(null);
  const [cameraError, setCameraError] = useState('');
  const videoRef = useRef<HTMLVideoElement | null>(null);
  const canvasRef = useRef<HTMLCanvasElement | null>(null);

  // Lightbox Photo Modal State
  const [activePhotoModal, setActivePhotoModal] = useState<string | null>(null);

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

  const startCamera = async (action: 'check_in' | 'check_out') => {
    setActiveAction(action);
    setCapturedPhoto(null);
    setCameraError('');
    setCameraOpen(true);

    try {
      const stream = await navigator.mediaDevices.getUserMedia({
        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
      });
      if (videoRef.current) {
        videoRef.current.srcObject = stream;
      }
    } catch (err: any) {
      setCameraError('Izin kamera ditolak atau kamera tidak ditemukan.');
    }
  };

  const stopCamera = () => {
    if (videoRef.current && videoRef.current.srcObject) {
      const stream = videoRef.current.srcObject as MediaStream;
      stream.getTracks().forEach((track) => track.stop());
      videoRef.current.srcObject = null;
    }
    setCameraOpen(false);
  };

  const capturePhoto = () => {
    if (videoRef.current && canvasRef.current) {
      const video = videoRef.current;
      const canvas = canvasRef.current;
      canvas.width = video.videoWidth || 640;
      canvas.height = video.videoHeight || 480;
      const context = canvas.getContext('2d');
      if (context) {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
        setCapturedPhoto(dataUrl);
        stopCamera();
      }
    }
  };

  const handleAttendanceSubmit = async (action: 'check_in' | 'check_out', photoData?: string | null) => {
    setError('');
    setSuccess('');
    setLoading(true);

    let locationStr = '';
    if (navigator.geolocation) {
      try {
        const position: any = await new Promise((resolve, reject) => {
          navigator.geolocation.getCurrentPosition(resolve, reject, { timeout: 5000 });
        });
        locationStr = `${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)}`;
      } catch (e) {
        locationStr = 'Lokasi GPS tidak diaktifkan';
      }
    }

    try {
      const res = await fetch('/api/attendances', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          action,
          location: locationStr,
          photo: photoData || capturedPhoto,
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
      setCapturedPhoto(null);
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
          <p className="text-xs text-slate-500 mt-1">
            Lakukan absensi masuk dan pulang dilengkapi foto swafoto dan lokasi GPS.
          </p>
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

        {/* Attendance Action Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {/* Check-In Card */}
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

            <div className="mt-6 space-y-2">
              {!todayRecord?.check_in && (
                <button
                  onClick={() => startCamera('check_in')}
                  className="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-2xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-500 transition shadow-lg shadow-blue-600/20"
                >
                  <Camera className="w-4 h-4" /> Buka Kamera Swafoto Masuk
                </button>
              )}

              {todayRecord?.check_in && (
                <div className="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-bold text-center">
                  Absensi Masuk Selesai ({todayRecord.check_in})
                </div>
              )}
            </div>
          </div>

          {/* Check-Out Card */}
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

            <div className="mt-6 space-y-2">
              {todayRecord?.check_in && !todayRecord?.check_out && (
                <button
                  onClick={() => startCamera('check_out')}
                  className="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-2xl text-xs font-bold text-white bg-purple-600 hover:bg-purple-500 transition shadow-lg shadow-purple-600/20"
                >
                  <Camera className="w-4 h-4" /> Buka Kamera Swafoto Pulang
                </button>
              )}

              {!todayRecord?.check_in && (
                <div className="p-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 text-xs font-medium text-center">
                  Lakukan Absensi Masuk Terlebih Dahulu
                </div>
              )}

              {todayRecord?.check_out && (
                <div className="p-3 rounded-xl bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 text-xs font-bold text-center">
                  Absensi Pulang Selesai ({todayRecord.check_out})
                </div>
              )}
            </div>
          </div>
        </div>

        {/* History Table */}
        <div className="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm">
          <h3 className="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4">
            Riwayat Presensi Saya
          </h3>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs">
              <thead className="border-b border-slate-100 dark:border-slate-800 text-slate-400 uppercase text-[10px] font-bold">
                <tr>
                  <th className="py-3 px-4">Tanggal</th>
                  <th className="py-3 px-4">Jam Masuk</th>
                  <th className="py-3 px-4">Jam Pulang</th>
                  <th className="py-3 px-4">Lokasi GPS</th>
                  <th className="py-3 px-4">Foto Bukti</th>
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
                      <td className="py-3 px-4 text-slate-500 text-[11px]">{item.check_in_location || '-'}</td>
                      <td className="py-3 px-4">
                        {item.check_in_photo ? (
                          <button
                            onClick={() => setActivePhotoModal(item.check_in_photo)}
                            className="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 font-semibold text-[11px]"
                          >
                            <Eye className="w-3.5 h-3.5" /> Lihat Foto
                          </button>
                        ) : (
                          <span className="text-slate-400 text-[11px]">-</span>
                        )}
                      </td>
                      <td className="py-3 px-4">
                        <span className="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                          {item.status === 'present' ? 'Hadir' : item.status}
                        </span>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan={6} className="py-6 text-center text-slate-400">Belum ada riwayat absensi.</td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {/* Camera Modal UX */}
      {cameraOpen && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4">
          <div className="w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl relative space-y-4">
            <div className="flex items-center justify-between">
              <h3 className="text-sm font-bold text-white uppercase tracking-wider">
                Ambil Foto Swafoto ({activeAction === 'check_in' ? 'Masuk' : 'Pulang'})
              </h3>
              <button onClick={stopCamera} className="text-slate-400 hover:text-white">
                <X className="w-5 h-5" />
              </button>
            </div>

            {cameraError ? (
              <div className="p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs text-center font-semibold">
                {cameraError}
              </div>
            ) : (
              <div className="relative rounded-2xl overflow-hidden bg-black aspect-video border border-slate-800">
                <video ref={videoRef} autoPlay playsInline className="w-full h-full object-cover" />
                <canvas ref={canvasRef} className="hidden" />
              </div>
            )}

            <div className="flex gap-3 pt-2">
              <button
                onClick={stopCamera}
                className="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-300 text-xs font-semibold hover:bg-slate-800"
              >
                Tutup
              </button>
              {!cameraError && (
                <button
                  onClick={capturePhoto}
                  className="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-lg shadow-blue-600/30"
                >
                  Ambil Foto
                </button>
              )}
            </div>
          </div>
        </div>
      )}

      {/* Captured Photo Preview Modal */}
      {capturedPhoto && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4">
          <div className="w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl space-y-4 text-center">
            <h3 className="text-sm font-bold text-white">Konfirmasi Foto Swafoto</h3>
            <img src={capturedPhoto} alt="Swafoto" className="w-full max-h-60 rounded-2xl object-cover border border-slate-800 mx-auto" />

            <div className="flex gap-3 pt-2">
              <button
                onClick={() => setCapturedPhoto(null)}
                className="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-300 text-xs font-semibold hover:bg-slate-800"
              >
                Ulangi Foto
              </button>
              <button
                onClick={() => handleAttendanceSubmit(activeAction, capturedPhoto)}
                disabled={loading}
                className="flex-1 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-lg shadow-emerald-600/30"
              >
                {loading ? 'Kirim...' : 'Kirim Presensi'}
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Lightbox Photo Preview Modal */}
      {activePhotoModal && (
        <div onClick={() => setActivePhotoModal(null)} className="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-md p-4 cursor-pointer">
          <div className="relative max-w-lg w-full bg-slate-900 p-4 rounded-3xl border border-slate-800" onClick={(e) => e.stopPropagation()}>
            <button onClick={() => setActivePhotoModal(null)} className="absolute top-4 right-4 text-slate-400 hover:text-white">
              <X className="w-6 h-6" />
            </button>
            <h4 className="text-xs font-bold text-slate-300 mb-3">Foto Bukti Presensi</h4>
            <img src={activePhotoModal} alt="Preview" className="w-full rounded-2xl max-h-[70vh] object-contain border border-slate-800" />
          </div>
        </div>
      )}
    </AppLayout>
  );
}
