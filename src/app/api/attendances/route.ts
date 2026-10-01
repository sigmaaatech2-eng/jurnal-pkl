import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';
import { getSessionUser } from '@/lib/auth';
import { attendanceSchema } from '@/lib/validations';
import { uploadStorageFile } from '@/lib/supabase/storage';

export async function GET(request: Request) {
  try {
    const sessionUser = await getSessionUser();
    if (!sessionUser) {
      return NextResponse.json({ message: 'Unauthorized' }, { status: 401 });
    }

    const { searchParams } = new URL(request.url);
    const studentId = searchParams.get('student_id');

    let whereClause: any = {};
    if (sessionUser.role === 'siswa') {
      whereClause.student_id = sessionUser.id;
    } else if (studentId) {
      whereClause.student_id = studentId;
    }

    const attendances = await prisma.attendance.findMany({
      where: whereClause,
      include: {
        student: {
          select: {
            id: true,
            name: true,
            kelas: true,
            jurusan: true,
          },
        },
      },
      orderBy: { date: 'desc' },
    });

    return NextResponse.json({ attendances });
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Gagal mengambil data absensi: ' + error.message },
      { status: 500 }
    );
  }
}

export async function POST(request: Request) {
  try {
    const sessionUser = await getSessionUser();
    if (!sessionUser || sessionUser.role !== 'siswa') {
      return NextResponse.json({ message: 'Akses ditolak.' }, { status: 403 });
    }

    const body = await request.json();

    const parseResult = attendanceSchema.safeParse(body);
    if (!parseResult.success) {
      return NextResponse.json(
        { message: parseResult.error.errors[0]?.message || 'Data absensi tidak valid.' },
        { status: 400 }
      );
    }

    const { action, location, photo, status } = parseResult.data;

    // Server-side trusted timestamp
    const now = new Date();
    const today = now.toISOString().split('T')[0];
    const nowTime = now.toTimeString().split(' ')[0];

    let photoUrl = photo || null;
    if (photo && photo.startsWith('data:')) {
      const uploaded = await uploadStorageFile('attendance-photos', `attendance-${sessionUser.id}-${action}.jpg`, photo);
      if (uploaded) photoUrl = uploaded;
    }

    const internship = await prisma.internship.findFirst({
      where: { student_id: sessionUser.id, status: 'active' },
    });

    let attendance = await prisma.attendance.findFirst({
      where: {
        student_id: sessionUser.id,
        date: today,
      },
    });

    if (action === 'check_in') {
      if (attendance) {
        return NextResponse.json(
          { message: 'Anda sudah melakukan absensi masuk hari ini.' },
          { status: 400 }
        );
      }

      attendance = await prisma.attendance.create({
        data: {
          student_id: sessionUser.id,
          internship_id: internship?.id || null,
          date: today,
          check_in: nowTime,
          check_in_photo: photoUrl,
          check_in_location: location || null,
          status,
        },
      });

      return NextResponse.json({
        message: 'Absensi masuk berhasil dicatat.',
        attendance,
      });
    } else if (action === 'check_out') {
      if (!attendance) {
        return NextResponse.json(
          { message: 'Anda belum melakukan absensi masuk hari ini.' },
          { status: 400 }
        );
      }

      if (attendance.check_out) {
        return NextResponse.json(
          { message: 'Anda sudah melakukan absensi pulang hari ini.' },
          { status: 400 }
        );
      }

      attendance = await prisma.attendance.update({
        where: { id: attendance.id },
        data: {
          check_out: nowTime,
          check_out_photo: photoUrl,
          check_out_location: location || null,
        },
      });

      return NextResponse.json({
        message: 'Absensi pulang berhasil dicatat.',
        attendance,
      });
    }

    return NextResponse.json({ message: 'Aksi tidak valid.' }, { status: 400 });
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Gagal mencatat absensi: ' + error.message },
      { status: 500 }
    );
  }
}
