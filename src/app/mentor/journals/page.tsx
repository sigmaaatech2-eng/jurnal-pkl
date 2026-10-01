'use client';

import React, { useState, useEffect } from 'react';
import AppLayout from '@/components/layout/AppLayout';
import { BookOpen, CheckCircle2, AlertCircle, Clock, Save } from 'lucide-react';

export default function MentorJournalsPage() {
  const [user, setUser] = useState<any>(null);
  const [journals, setJournals] = useState<any[]>([]);
  const [selectedJournal, setSelectedJournal] = useState<any>(null);
  const [status, setStatus] = useState('approved');
  const [score, setScore] = useState('90');
  const [feedback, setFeedback] = useState('');
  const [loading, setLoading] = useState(false);
  const [msg, setMsg] = useState('');

  useEffect(() => {
    fetch('/api/auth/me')
      .then((res) => res.json())
      .then((data) => {
        if (data.user) setUser(data.user);
      });

    loadJournals();
  }, []);

  const loadJournals = async () => {
    const res = await fetch('/api/journals');
    const data = await res.json();
    if (data.journals) setJournals(data.journals);
  };

  const handleValidate = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedJournal) return;
    setLoading(true);
    setMsg('');

    try {
      const res = await fetch('/api/journals', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          id: selectedJournal.id,
          status,
          score,
          feedback,
        }),
      });

      const data = await res.json();
      setLoading(false);

      if (res.ok) {
        setMsg('Validasi jurnal berhasil disimpan.');
        setSelectedJournal(null);
        loadJournals();
      }
    } catch (err) {
      setLoading(false);
    }
  };

  return (
    <AppLayout user={user || { name: 'Mentor Industri', email: '', role: 'mentor' }}>
      <div className="space-y-6">
        <div>
          <h1 className="text-xl font-bold text-slate-800 dark:text-white">Validasi Jurnal Siswa</h1>
          <p className="text-xs text-slate-500 mt-1">Evaluasi dan berikan nilai serta penilaian pada jurnal harian siswa PKL.</p>
        </div>

        {msg && (
          <div className="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold">
            {msg}
          </div>
        )}

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* Journal List */}
          <div className="lg:col-span-2 space-y-4">
            {journals.map((j) => (
              <div
                key={j.id}
                onClick={() => {
                  setSelectedJournal(j);
                  setStatus(j.status === 'pending' ? 'approved' : j.status);
                  setScore(j.score ? String(j.score) : '90');
                  setFeedback(j.feedback || '');
                }}
                className={`p-5 rounded-3xl border transition cursor-pointer ${
                  selectedJournal?.id === j.id
                    ? 'border-amber-500 bg-amber-500/5 dark:bg-amber-500/10'
                    : 'border-slate-200/80 bg-white dark:border-slate-800 dark:bg-slate-900 hover:border-slate-300'
                }`}
              >
                <div className="flex items-center justify-between">
                  <span className="text-xs font-bold text-slate-700 dark:text-slate-200">{j.student.name} ({j.student.kelas})</span>
                  <span className="text-[10px] text-slate-400 font-semibold">{j.date}</span>
                </div>
                <h4 className="text-sm font-bold text-slate-800 dark:text-white mt-2">{j.title}</h4>
                <p className="text-xs text-slate-500 line-clamp-2 mt-1">{j.description}</p>
                <div className="mt-3 flex items-center justify-between">
                  <span className="text-[10px] uppercase font-bold text-slate-400">Status: {j.status}</span>
                  <span className="text-xs font-bold text-amber-600 dark:text-amber-400">Klik untuk Review & Nilai →</span>
                </div>
              </div>
            ))}
          </div>

          {/* Validation Form */}
          <div>
            {selectedJournal ? (
              <div className="sticky top-24 p-6 rounded-3xl border border-slate-200/80 bg-white dark:border-slate-800 dark:bg-slate-900 shadow-xl space-y-4">
                <h3 className="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">
                  Form Penilaian Jurnal
                </h3>
                <p className="text-xs font-bold text-amber-600 dark:text-amber-400">{selectedJournal.title}</p>

                <form onSubmit={handleValidate} className="space-y-4">
                  <div>
                    <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Status Persetujuan</label>
                    <select
                      value={status}
                      onChange={(e) => setStatus(e.target.value)}
                      className="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-800 dark:text-white"
                    >
                      <option value="approved">Setujui (Approved)</option>
                      <option value="revision">Minta Revisi (Revision)</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nilai (0-100)</label>
                    <input
                      type="number"
                      min="0"
                      max="100"
                      value={score}
                      onChange={(e) => setScore(e.target.value)}
                      className="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-800 dark:text-white"
                    />
                  </div>

                  <div>
                    <label className="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Catatan / Feedback</label>
                    <textarea
                      rows={4}
                      value={feedback}
                      onChange={(e) => setFeedback(e.target.value)}
                      placeholder="Tuliskan apresiasi atau saran perbaikan..."
                      className="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-800 dark:text-white"
                    />
                  </div>

                  <button
                    type="submit"
                    disabled={loading}
                    className="w-full py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs shadow-lg shadow-amber-600/20 transition flex items-center justify-center gap-2"
                  >
                    <Save className="w-4 h-4" /> Simpan Penilaian
                  </button>
                </form>
              </div>
            ) : (
              <div className="p-8 rounded-3xl border border-slate-200/80 bg-white dark:border-slate-800 dark:bg-slate-900 text-center text-xs text-slate-400">
                Pilih salah satu jurnal di sebelah kiri untuk melakukan review.
              </div>
            )}
          </div>
        </div>
      </div>
    </AppLayout>
  );
}
