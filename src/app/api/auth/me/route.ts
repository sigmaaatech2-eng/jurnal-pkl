import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';
import { getSessionUser } from '@/lib/auth';

export async function GET() {
  try {
    const sessionUser = await getSessionUser();
    if (!sessionUser) {
      return NextResponse.json({ message: 'Unauthorized' }, { status: 401 });
    }

    const dbUser = await prisma.user.findUnique({
      where: { id: sessionUser.id },
      select: {
        id: true,
        name: true,
        email: true,
        role: true,
        avatar: true,
        phone: true,
        nisn: true,
        nip: true,
        jurusan: true,
        kelas: true,
        company_name: true,
        position: true,
        school_name: true,
        address: true,
      },
    });

    return NextResponse.json({ user: dbUser });
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Gagal mengambil profil: ' + error.message },
      { status: 500 }
    );
  }
}

export async function PUT(request: Request) {
  try {
    const sessionUser = await getSessionUser();
    if (!sessionUser) {
      return NextResponse.json({ message: 'Unauthorized' }, { status: 401 });
    }

    const body = await request.json();
    const { name, phone, address } = body;

    const updated = await prisma.user.update({
      where: { id: sessionUser.id },
      data: {
        name: name || undefined,
        phone: phone !== undefined ? phone : undefined,
        address: address !== undefined ? address : undefined,
      },
    });

    return NextResponse.json({ message: 'Profil berhasil diperbarui.', user: updated });
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Gagal memperbarui profil: ' + error.message },
      { status: 500 }
    );
  }
}
