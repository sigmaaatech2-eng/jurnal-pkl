<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // =========================
        // PERMISSIONS
        // =========================

        $permissions = [

            // Admin Platform
            'manage-users',
            'manage-roles',
            'view-activity-logs',
            'manage-system',

            // Admin Sekolah
            'verify-accounts',
            'manage-student-placement',
            'assign-teachers',
            'monitor-pkl',
            'view-pkl-recap',

            // Kepala Sekolah
            'view-pkl-progress',
            'view-assessment-recap',
            'view-pkl-reports',
            'view-statistics',

            // Guru Pembimbing
            'view-assigned-students',
            'monitor-attendance',
            'monitor-journals',
            'monitor-mentor-assessments',
            'monitor-pkl-progress',
            'assess-students',
            'view-journal-recap',
            'download-journal-recap',

            // Mentor
            'view-student-journals',
            'validate-journals',
            'revise-journals',
            'assess-journals',

            // Siswa
            'manage-profile',
            'create-attendance',
            'create-journal',
            'upload-documentation',
            'edit-own-journal',
            'view-journal-status',
            'view-mentor-feedback',
            'download-own-report',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // =========================
        // ROLES
        // =========================

        $adminPlatform = Role::firstOrCreate([
            'name' => 'admin_platform',
            'guard_name' => 'web',
        ]);

        $adminSekolah = Role::firstOrCreate([
            'name' => 'admin_sekolah',
            'guard_name' => 'web',
        ]);

        $kepalaSekolah = Role::firstOrCreate([
            'name' => 'kepala_sekolah',
            'guard_name' => 'web',
        ]);

        $guruPembimbing = Role::firstOrCreate([
            'name' => 'guru_pembimbing',
            'guard_name' => 'web',
        ]);

        $mentor = Role::firstOrCreate([
            'name' => 'mentor',
            'guard_name' => 'web',
        ]);

        $siswa = Role::firstOrCreate([
            'name' => 'siswa',
            'guard_name' => 'web',
        ]);

        // =========================
        // ASSIGN PERMISSIONS
        // =========================

        $adminPlatform->syncPermissions([
            'manage-users',
            'manage-roles',
            'view-activity-logs',
            'manage-system',
        ]);

        $adminSekolah->syncPermissions([
            'verify-accounts',
            'manage-student-placement',
            'assign-teachers',
            'monitor-pkl',
            'view-pkl-recap',
        ]);

        $kepalaSekolah->syncPermissions([
            'view-pkl-progress',
            'view-assessment-recap',
            'view-pkl-reports',
            'view-statistics',
        ]);

        $guruPembimbing->syncPermissions([
            'view-assigned-students',
            'monitor-attendance',
            'monitor-journals',
            'monitor-mentor-assessments',
            'monitor-pkl-progress',
            'assess-students',
            'view-journal-recap',
            'download-journal-recap',
        ]);

        $mentor->syncPermissions([
            'view-assigned-students',
            'view-student-journals',
            'validate-journals',
            'revise-journals',
            'assess-journals',
        ]);

        $siswa->syncPermissions([
            'manage-profile',
            'create-attendance',
            'create-journal',
            'upload-documentation',
            'edit-own-journal',
            'view-journal-status',
            'view-mentor-feedback',
            'download-own-report',
        ]);
    }
}