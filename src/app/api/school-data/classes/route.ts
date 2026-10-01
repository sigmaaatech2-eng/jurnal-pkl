import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';

export async function GET() {
  try {
    const majors = await prisma.schoolMajor.findMany({
      where: { is_active: true },
      orderBy: { name: 'asc' },
    });

    const classes = await prisma.schoolClass.findMany({
      where: { is_active: true },
      include: { major: true },
      orderBy: { name: 'asc' },
    });

    return NextResponse.json({ majors, classes });
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Gagal mengambil data sekolah: ' + error.message },
      { status: 500 }
    );
  }
}
