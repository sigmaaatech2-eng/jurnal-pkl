<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSekolahSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role admin_sekolah sudah ada
        Role::firstOrCreate([
            'name' => 'admin_sekolah',
            'guard_name' => 'web',
        ]);

        // Buat user admin sekolah
        $user = User::updateOrCreate(
            ['email' => 'admin.sekolah@jurnal-pkl.test'],
            [
                'name' => 'Admin Sekolah',
                'email' => 'admin.sekolah@jurnal-pkl.test',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign role
        $user->syncRoles(['admin_sekolah']);

        $this->command->info('✅ Akun Admin Sekolah berhasil dibuat!');
        $this->command->table(
            ['Field', 'Value'],
            [
                ['Email', $user->email],
                ['Password', 'admin123'],
                ['Role', $user->getRoleNames()->first()],
            ]
        );
    }
}
