import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';
import { hashPassword, signToken } from '@/lib/auth';

export async function POST(request: Request) {
  try {
    const body = await request.json();
    const { name, email, jurusan, kelas, password, password_confirmation } = body;

    if (!name || !email || !jurusan || !kelas || !password) {
      return NextResponse.json(
        { message: 'Semua bidang wajib diisi.' },
        { status: 400 }
      );
    }

    if (password.length < 8) {
      return NextResponse.json(
        { message: 'Password minimal terdiri dari 8 karakter.' },
        { status: 400 }
      );
    }

    if (password !== password_confirmation) {
      return NextResponse.json(
        { message: 'Konfirmasi password tidak cocok.' },
        { status: 400 }
      );
    }

    const existingUser = await prisma.user.findUnique({
      where: { email },
    });

    if (existingUser) {
      return NextResponse.json(
        { message: 'Email ini sudah terdaftar di sistem.' },
        { status: 400 }
      );
    }

    const schoolClass = await prisma.schoolClass.findFirst({
      where: { name: kelas },
    });

    const hashedPassword = await hashPassword(password);

    const newUser = await prisma.user.create({
      data: {
        name,
        email,
        jurusan,
        kelas,
        school_class_id: schoolClass?.id || null,
        password: hashedPassword,
        role: 'siswa',
      },
    });

    const token = await signToken({
      id: newUser.id,
      email: newUser.email,
      name: newUser.name,
      role: newUser.role,
      avatar: newUser.avatar,
    });

    const response = NextResponse.json({
      message: 'Akun siswa berhasil didaftarkan.',
      role: newUser.role,
    });

    response.cookies.set('token', token, {
      httpOnly: true,
      secure: process.env.NODE_ENV === 'production',
      sameSite: 'lax',
      maxAge: 60 * 60 * 24 * 7,
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
