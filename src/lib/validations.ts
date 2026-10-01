import { z } from 'zod';

export const loginSchema = z.object({
  email: z.string().email('Format email tidak valid.').min(1, 'Email wajib diisi.'),
  password: z.string().min(1, 'Password wajib diisi.'),
  remember: z.boolean().optional(),
});

export const registerSchema = z.object({
  name: z.string().min(1, 'Nama lengkap wajib diisi.'),
  email: z.string().email('Format email tidak valid.').min(1, 'Email wajib diisi.'),
  jurusan: z.string().min(1, 'Silakan pilih jurusan Anda.'),
  kelas: z.string().min(1, 'Silakan pilih kelas Anda.'),
  password: z.string().min(8, 'Password minimal terdiri dari 8 karakter.'),
  password_confirmation: z.string().min(1, 'Konfirmasi password wajib diisi.'),
}).refine((data) => data.password === data.password_confirmation, {
  message: 'Konfirmasi password tidak cocok.',
  path: ['password_confirmation'],
});

export const journalSchema = z.object({
  date: z.string().min(1, 'Tanggal wajib diisi.'),
  title: z.string().min(1, 'Judul kegiatan wajib diisi.'),
  description: z.string().min(1, 'Deskripsi kegiatan wajib diisi.'),
  photo_attachment: z.string().optional().nullable(),
});

export const journalReviewSchema = z.object({
  id: z.string().min(1, 'ID Jurnal wajib diisi.'),
  status: z.enum(['approved', 'revision', 'pending', 'rejected']),
  score: z.number().min(0).max(100).optional().nullable(),
  feedback: z.string().optional().nullable(),
}).refine((data) => {
  if (data.status === 'revision' || data.status === 'rejected') {
    return !!data.feedback && data.feedback.trim().length > 0;
  }
  return true;
}, {
  message: 'Catatan feedback wajib diisi jika meminta revisi atau menolak jurnal.',
  path: ['feedback'],
});

export const attendanceSchema = z.object({
  action: z.enum(['check_in', 'check_out']),
  location: z.string().optional().nullable(),
  photo: z.string().optional().nullable(),
  status: z.enum(['present', 'permission', 'sick', 'alpha']).default('present'),
});
