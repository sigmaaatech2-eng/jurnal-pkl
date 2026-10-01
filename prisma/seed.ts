import { PrismaClient } from '@prisma/client';
import bcrypt from 'bcryptjs';

const prisma = new PrismaClient();

async function main() {
  console.log('🌱 Seeding database...');

  const hashedPassword = await bcrypt.hash('password', 10);

  // 1. Seed Majors & Classes
  const rpl = await prisma.schoolMajor.upsert({
    where: { code: 'RPL' },
    update: {},
    create: {
      name: 'Rekayasa Perangkat Lunak (RPL)',
      code: 'RPL',
      description: 'Konsentrasi keahlian pengembangan aplikasi desktop, web, dan mobile.',
      is_active: true,
    },
  });

  const tkj = await prisma.schoolMajor.upsert({
    where: { code: 'TKJ' },
    update: {},
    create: {
      name: 'Teknik Komputer dan Jaringan (TKJ)',
      code: 'TKJ',
      description: 'Konsentrasi keahlian infrastruktur jaringan komputer dan server.',
      is_active: true,
    },
  });

  const dkv = await prisma.schoolMajor.upsert({
    where: { code: 'DKV' },
    update: {},
    create: {
      name: 'Desain Komunikasi Visual (DKV)',
      code: 'DKV',
      description: 'Konsentrasi keahlian desain grafis dan multimedia.',
      is_active: true,
    },
  });

  const classRpl1 = await prisma.schoolClass.create({
    data: {
      school_major_id: rpl.id,
      name: 'XII RPL 1',
      grade: 'XII',
      is_active: true,
    },
  });

  await prisma.schoolClass.create({
    data: {
      school_major_id: rpl.id,
      name: 'XII RPL 2',
      grade: 'XII',
      is_active: true,
    },
  });

  await prisma.schoolClass.create({
    data: {
      school_major_id: tkj.id,
      name: 'XII TKJ 1',
      grade: 'XII',
      is_active: true,
    },
  });

  // 2. Seed Users (All 6 Roles)
  
  // Admin Platform
  const adminPlatform = await prisma.user.upsert({
    where: { email: 'admin@platform.test' },
    update: {},
    create: {
      name: 'Admin Platform',
      email: 'admin@platform.test',
      password: hashedPassword,
      role: 'admin_platform',
      phone: '081100000001',
    },
  });

  // Admin Sekolah
  const adminSekolah = await prisma.user.upsert({
    where: { email: 'admin.sekolah@jurnal-pkl.test' },
    update: {},
    create: {
      name: 'Admin Sekolah',
      email: 'admin.sekolah@jurnal-pkl.test',
      password: hashedPassword,
      role: 'admin_sekolah',
      phone: '081200000002',
    },
  });

  // Kepala Sekolah
  const kepsek = await prisma.user.upsert({
    where: { email: 'kepsek@sekolah.sch.id' },
    update: {},
    create: {
      name: 'Drs. H. Bambang Purnomo, M.Pd.',
      email: 'kepsek@sekolah.sch.id',
      password: hashedPassword,
      role: 'kepala_sekolah',
      nip: '196805121993031005',
      school_name: 'SMK Negeri 1 Indonesia',
      phone: '081234567890',
    },
  });

  // Guru Pembimbing
  const guru = await prisma.user.upsert({
    where: { email: 'guru@sekolah.sch.id' },
    update: {},
    create: {
      name: 'Bpk. Rudi Santoso, S.Kom.',
      email: 'guru@sekolah.sch.id',
      password: hashedPassword,
      role: 'guru_pembimbing',
      nip: '198203152006041002',
      bidang: 'Rekayasa Perangkat Lunak',
      phone: '081234567891',
    },
  });

  // Mentor Industri
  const mentor = await prisma.user.upsert({
    where: { email: 'mentor@perusahaan.com' },
    update: {},
    create: {
      name: 'Bpk. Hendra Pratama, S.T.',
      email: 'mentor@perusahaan.com',
      password: hashedPassword,
      role: 'mentor',
      company_name: 'PT Solusi Teknologi Nusantara',
      position: 'Senior Software Engineer / Mentor PKL',
      phone: '081234567892',
    },
  });

  // Siswa PKL
  const siswa = await prisma.user.upsert({
    where: { email: 'siswa@sekolah.sch.id' },
    update: {},
    create: {
      name: 'Ahmad Rizki Pratama',
      email: 'siswa@sekolah.sch.id',
      password: hashedPassword,
      role: 'siswa',
      nisn: '0061234567',
      jurusan: 'Rekayasa Perangkat Lunak (RPL)',
      kelas: 'XII RPL 1',
      school_class_id: classRpl1.id,
      phone: '081234567893',
    },
  });

  // 3. Internship Placement
  const internship = await prisma.internship.create({
    data: {
      student_id: siswa.id,
      mentor_id: mentor.id,
      teacher_id: guru.id,
      company_name: 'PT Solusi Teknologi Nusantara',
      company_address: 'Jl. Sudirman No. 123, Gedung Cyber Lt. 5, Jakarta Selatan',
      start_date: new Date(Date.now() - 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
      end_date: new Date(Date.now() + 60 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
      status: 'active',
    },
  });

  // 4. Sample Attendances
  const today = new Date().toISOString().split('T')[0];
  const yesterday = new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString().split('T')[0];

  await prisma.attendance.create({
    data: {
      student_id: siswa.id,
      internship_id: internship.id,
      date: yesterday,
      check_in: '07:45:00',
      check_out: '17:00:00',
      status: 'present',
      check_in_location: '-6.2088, 106.8456',
    },
  });

  await prisma.attendance.create({
    data: {
      student_id: siswa.id,
      internship_id: internship.id,
      date: today,
      check_in: '07:50:00',
      check_out: null,
      status: 'present',
      check_in_location: '-6.2088, 106.8456',
    },
  });

  // 5. Sample Journals
  await prisma.journal.create({
    data: {
      student_id: siswa.id,
      internship_id: internship.id,
      date: yesterday,
      title: 'Implementasi Fitur Autentikasi dan Payment Gateway',
      description: 'Melakukan implementasi fitur autentikasi dan integrasi API payment gateway pada modul checkout web aplikasi.',
      status: 'approved',
      score: 95,
      feedback: 'Bagus sekali! Logika kode rapi dan penanganan exception sudah baik.',
    },
  });

  await prisma.journal.create({
    data: {
      student_id: siswa.id,
      internship_id: internship.id,
      date: today,
      title: 'Perbaikan Antarmuka Pengguna Responsif',
      description: 'Mengerjakan perbaikan layout antarmuka responsif pada form pendaftaran dan verifikasi data kelas serta jurusan.',
      status: 'pending',
    },
  });

  // 6. Subscription Packages
  const pkgPro = await prisma.subscriptionPackage.create({
    data: {
      name: 'Paket Sekolah Pro',
      price: 1500000,
      duration_months: 12,
      max_students: 500,
      features: 'Siswa Unlimited, Mentor & Guru Unlimited, Export Rekap PDF & Excel, Geolocation Check-in',
      is_active: true,
    },
  });

  const schoolSub = await prisma.schoolSubscription.create({
    data: {
      school_name: 'SMK Negeri 1 Indonesia',
      package_id: pkgPro.id,
      start_date: new Date().toISOString().split('T')[0],
      end_date: new Date(Date.now() + 365 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
      status: 'active',
    },
  });

  await prisma.paymentHistory.create({
    data: {
      subscription_id: schoolSub.id,
      amount: 1500000,
      payment_date: today,
      payment_method: 'Bank Transfer (BCA)',
      status: 'completed',
      transaction_id: 'TRX-2026-98124',
    },
  });

  console.log('✅ Seeding completed successfully!');
  console.log('Accounts created:');
  console.log('- Admin Platform : admin@platform.test / password');
  console.log('- Admin Sekolah  : admin.sekolah@jurnal-pkl.test / password');
  console.log('- Kepala Sekolah : kepsek@sekolah.sch.id / password');
  console.log('- Guru Pembimbing: guru@sekolah.sch.id / password');
  console.log('- Mentor Industri: mentor@perusahaan.com / password');
  console.log('- Siswa PKL      : siswa@sekolah.sch.id / password');
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
