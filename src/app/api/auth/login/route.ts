import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';
import { comparePassword, hashPassword, signToken } from '@/lib/auth';
import { loginSchema } from '@/lib/validations';

const DEFAULT_ACCOUNTS = [
  {
    name: 'Siswa PKL',
    email: 'siswa@sekolah.sch.id',
    role: 'siswa',
    kelas: 'XII RPL 1',
    jurusan: 'Rekayasa Perangkat Lunak (RPL)',
  },
  {
    name: 'Bpk. Rudi Santoso, S.Kom.',
    email: 'guru@sekolah.sch.id',
    role: 'guru_pembimbing',
    bidang: 'Rekayasa Perangkat Lunak',
  },
  {
    name: 'Bpk. Hendra Pratama, S.T.',
    email: 'mentor@perusahaan.com',
    role: 'mentor',
    company_name: 'PT Solusi Teknologi Nusantara',
  },
  {
    name: 'Admin Sekolah',
    email: 'admin.sekolah@jurnal-pkl.test',
    role: 'admin_sekolah',
  },
  {
    name: 'Drs. H. Bambang Purnomo, M.Pd.',
    email: 'kepsek@sekolah.sch.id',
    role: 'kepala_sekolah',
    school_name: 'SMK Negeri 1 Indonesia',
  },
  {
    name: 'Admin Platform',
    email: 'admin@platform.test',
    role: 'admin_platform',
  },
];

export async function POST(request: Request) {
  try {
    const body = await request.json();
    
    // Zod validation
    const parseResult = loginSchema.safeParse(body);
    if (!parseResult.success) {
      return NextResponse.json(
        { message: parseResult.error.errors[0]?.message || 'Data tidak valid.' },
        { status: 400 }
      );
    }

    const { email, password, remember } = parseResult.data;

    let user = await prisma.user.findUnique({
      where: { email },
    });

    // Auto-seed account if missing on cold start / new environment
    if (!user) {
      const matchDefault = DEFAULT_ACCOUNTS.find((acc) => acc.email === email);
      if (matchDefault && password === 'password') {
        const hashedPassword = await hashPassword('password');
        user = await prisma.user.create({
          data: {
            name: matchDefault.name,
            email: matchDefault.email,
            password: hashedPassword,
            role: matchDefault.role,
            kelas: matchDefault.kelas || null,
            jurusan: matchDefault.jurusan || null,
            company_name: matchDefault.company_name || null,
            school_name: matchDefault.school_name || null,
          },
        });
      }
    }

    if (!user) {
      return NextResponse.json(
        { message: 'Email atau password yang Anda masukkan tidak sesuai.' },
        { status: 401 }
      );
    }

    const isMatch = await comparePassword(password, user.password);
    if (!isMatch) {
      return NextResponse.json(
        { message: 'Email atau password yang Anda masukkan tidak sesuai.' },
        { status: 401 }
      );
    }

    const token = await signToken({
      id: user.id,
      email: user.email,
      name: user.name,
      role: user.role,
      avatar: user.avatar,
    });

    const response = NextResponse.json({
      message: 'Login berhasil.',
      role: user.role,
    });

    response.cookies.set('token', token, {
      httpOnly: true,
      secure: process.env.NODE_ENV === 'production',
      sameSite: 'lax',
      maxAge: remember ? 60 * 60 * 24 * 30 : 60 * 60 * 24 * 7,
      path: '/',
    });

    return response;
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Terjadi kesalahan pada server: ' + error.message },
      { status: 500 }
    );
  }
}
