<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SchoolMajor;
use App\Models\SchoolClass;
use App\Models\Internship;
use App\Models\Journal;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ResetDataAndSeedActorsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Pastikan role-role dasar sudah ada
        $roles = [
            'admin_platform',
            'admin_sekolah',
            'kepala_sekolah',
            'guru_pembimbing',
            'mentor',
            'siswa',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. SEED DATA SEKOLAH (JURUSAN & KELAS)
        $this->command->info('🏫 Mengisi data sekolah (Jurusan & Kelas)...');

        $majorsData = [
            [
                'name' => 'Rekayasa Perangkat Lunak (RPL)',
                'code' => 'RPL',
                'description' => 'Konsentrasi keahlian pengembangan aplikasi desktop, web, dan mobile.',
                'classes' => [
                    ['name' => 'XII RPL 1', 'grade' => 'XII'],
                    ['name' => 'XII RPL 2', 'grade' => 'XII'],
                ]
            ],
            [
                'name' => 'Teknik Komputer dan Jaringan (TKJ)',
                'code' => 'TKJ',
                'description' => 'Konsentrasi keahlian infrastruktur jaringan komputer, server, dan keamanan siber.',
                'classes' => [
                    ['name' => 'XII TKJ 1', 'grade' => 'XII'],
                    ['name' => 'XII TKJ 2', 'grade' => 'XII'],
                ]
            ],
            [
                'name' => 'Desain Komunikasi Visual (DKV)',
                'code' => 'DKV',
                'description' => 'Konsentrasi keahlian desain grafis, ilustrasi digital, dan multimedia interaktif.',
                'classes' => [
                    ['name' => 'XII DKV 1', 'grade' => 'XII'],
                ]
            ],
            [
                'name' => 'Akuntansi dan Keuangan Lembaga (AKL)',
                'code' => 'AKL',
                'description' => 'Konsentrasi keahlian akuntansi keuangan, perpajakan, dan perbankan syariah.',
                'classes' => [
                    ['name' => 'XII AKL 1', 'grade' => 'XII'],
                ]
            ],
            [
                'name' => 'Manajemen Perkantoran (MP)',
                'code' => 'MP',
                'description' => 'Konsentrasi keahlian tata kelola administrasi perkantoran modern.',
                'classes' => [
                    ['name' => 'XII MP 1', 'grade' => 'XII'],
                ]
            ],
        ];

        foreach ($majorsData as $m) {
            $major = SchoolMajor::updateOrCreate(
                ['code' => $m['code']],
                [
                    'name' => $m['name'],
                    'description' => $m['description'],
                    'is_active' => true,
                ]
            );

            foreach ($m['classes'] as $c) {
                SchoolClass::updateOrCreate(
                    [
                        'school_major_id' => $major->id,
                        'name' => $c['name'],
                    ],
                    [
                        'grade' => $c['grade'],
                        'is_active' => true,
                    ]
                );
            }
        }

        // 3. IDENTIFIKASI AKUN ADMIN SEKOLAH YANG AKAN DIPERTAHANKAN
        $adminSekolah = User::role('admin_sekolah')->first();

        if (!$adminSekolah) {
            $adminSekolah = User::updateOrCreate(
                ['email' => 'admin.sekolah@jurnal-pkl.test'],
                [
                    'name' => 'Admin Sekolah',
                    'email' => 'admin.sekolah@jurnal-pkl.test',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $adminSekolah->syncRoles(['admin_sekolah']);
        } else {
            // Pastikan password-nya diketahui (password)
            $adminSekolah->update([
                'password' => Hash::make('password'),
            ]);
        }

        $preserveUserIds = [$adminSekolah->id];

        // 4. HAPUS SELURUH PENGGUNA LAIN (KECUALI ADMIN SEKOLAH)
        $this->command->info('🧹 Menghapus seluruh akun lama kecuali Admin Sekolah...');

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        // Hapus data transaksi anak terlebih dahulu
        Attendance::query()->delete();
        Journal::query()->delete();
        Internship::query()->delete();

        // Hapus user yang bukan admin sekolah
        $usersToDelete = User::whereNotIn('id', $preserveUserIds)->get();
        foreach ($usersToDelete as $u) {
            $u->roles()->detach();
            $u->delete();
        }

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 5. BUAT MASING-MASING AKTOR 1 AKUN
        $this->command->info('👤 Membuat 1 akun untuk masing-masing aktor...');

        // 0. ADMIN PLATFORM (Super Admin Sistem)
        $adminPlatform = User::create([
            'name' => 'Admin Platform',
            'email' => 'admin@platform.test',
            'password' => Hash::make('password'),
            'phone' => '081100000001',
            'email_verified_at' => now(),
        ]);
        $adminPlatform->assignRole('admin_platform');

        // A. KEPALA SEKOLAH
        $kepsek = User::create([
            'name' => 'Drs. H. Bambang Purnomo, M.Pd.',
            'email' => 'kepsek@sekolah.sch.id',
            'password' => Hash::make('password'),
            'nip' => '196805121993031005',
            'school_name' => 'SMK Negeri 1 Indonesia',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);
        $kepsek->assignRole('kepala_sekolah');

        // B. GURU PEMBIMBING
        $guru = User::create([
            'name' => 'Bpk. Rudi Santoso, S.Kom.',
            'email' => 'guru@sekolah.sch.id',
            'password' => Hash::make('password'),
            'nip' => '198203152006041002',
            'bidang' => 'Rekayasa Perangkat Lunak',
            'phone' => '081234567891',
            'email_verified_at' => now(),
        ]);
        $guru->assignRole('guru_pembimbing');

        // C. MENTOR INDUSTRI
        $mentor = User::create([
            'name' => 'Bpk. Hendra Pratama, S.T.',
            'email' => 'mentor@perusahaan.com',
            'password' => Hash::make('password'),
            'company_name' => 'PT Solusi Teknologi Nusantara',
            'position' => 'Senior Software Engineer / Mentor PKL',
            'phone' => '081234567892',
            'email_verified_at' => now(),
        ]);
        $mentor->assignRole('mentor');

        // D. SISWA
        $siswa = User::create([
            'name' => 'Ahmad Rizki Pratama',
            'email' => 'siswa@sekolah.sch.id',
            'password' => Hash::make('password'),
            'nisn' => '0061234567',
            'jurusan' => 'Rekayasa Perangkat Lunak (RPL)',
            'kelas' => 'XII RPL 1',
            'phone' => '081234567893',
            'email_verified_at' => now(),
        ]);
        $siswa->assignRole('siswa');

        // 6. BUAT DATA PENEMPATAN PKL AKTIF (MENGHUBUNGKAN SISWA, GURU, MENTOR)
        $this->command->info('🔗 Menghubungkan Siswa, Guru Pembimbing, dan Mentor dalam penempatan PKL...');

        $internship = Internship::create([
            'student_id' => $siswa->id,
            'mentor_id' => $mentor->id,
            'teacher_id' => $guru->id,
            'company_name' => 'PT Solusi Teknologi Nusantara',
            'company_address' => 'Jl. Sudirman No. 123, Gedung Cyber Lt. 5, Jakarta Selatan',
            'start_date' => now()->subMonth()->startOfMonth()->toDateString(),
            'end_date' => now()->addMonths(2)->endOfMonth()->toDateString(),
            'status' => 'active',
        ]);

        // 7. BUAT DATA ABSENSI & JURNAL CONTOH UNTUK SISWA
        Attendance::create([
            'student_id' => $siswa->id,
            'internship_id' => $internship->id,
            'date' => now()->toDateString(),
            'check_in' => '07:45:00',
            'check_out' => null,
            'status' => 'present',
        ]);

        Journal::create([
            'student_id' => $siswa->id,
            'internship_id' => $internship->id,
            'date' => now()->subDay()->toDateString(),
            'title' => 'Implementasi Fitur Autentikasi dan Payment Gateway',
            'description' => 'Melakukan implementasi fitur autentikasi dan integrasi API payment gateway pada modul checkout web aplikasi.',
            'status' => 'approved',
            'feedback' => 'Bagus sekali! Logika kode rapi dan penanganan exception sudah baik.',
        ]);

        Journal::create([
            'student_id' => $siswa->id,
            'internship_id' => $internship->id,
            'date' => now()->toDateString(),
            'title' => 'Perbaikan Antarmuka Pengguna Responsif',
            'description' => 'Mengerjakan perbaikan layout antarmuka responsif pada form pendaftaran dan verifikasi data kelas serta jurusan.',
            'status' => 'pending',
        ]);

        $this->command->info('🎉 Berhasil! Seluruh data sekolah & akun aktor berhasil diperbarui.');
        $this->command->table(
            ['Aktor (Peran)', 'Nama Lengkap', 'Email', 'Password', 'Keterangan Tambahan'],
            [
                ['Admin Platform', $adminPlatform->name, $adminPlatform->email, 'password', 'Super Admin Pengelola Platform'],
                ['Admin Sekolah', $adminSekolah->name, $adminSekolah->email, 'password', 'Akun Utama Admin Sekolah'],
                ['Kepala Sekolah', $kepsek->name, $kepsek->email, 'password', 'Drs. H. Bambang Purnomo, M.Pd.'],
                ['Guru Pembimbing', $guru->name, $guru->email, 'password', 'Bpk. Rudi Santoso, S.Kom.'],
                ['Mentor Industri', $mentor->name, $mentor->email, 'password', 'PT Solusi Teknologi Nusantara'],
                ['Siswa PKL', $siswa->name, $siswa->email, 'password', "Kelas: {$siswa->kelas} | Jurusan: {$siswa->jurusan}"],
            ]
        );
    }
}
