import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';
import { getSessionUser } from '@/lib/auth';

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

    const journals = await prisma.journal.findMany({
      where: whereClause,
      include: {
        student: {
          select: {
            id: true,
            name: true,
            email: true,
            kelas: true,
            jurusan: true,
            avatar: true,
          },
        },
      },
      orderBy: { date: 'desc' },
    });

    return NextResponse.json({ journals });
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Gagal mengambil data jurnal: ' + error.message },
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
    const { date, title, description, photo_attachment } = body;

    if (!date || !title || !description) {
      return NextResponse.json(
        { message: 'Tanggal, Judul, dan Deskripsi kegiatan wajib diisi.' },
        { status: 400 }
      );
    }

    // Find active placement
    const internship = await prisma.internship.findFirst({
      where: { student_id: sessionUser.id, status: 'active' },
    });

    const newJournal = await prisma.journal.create({
      data: {
        student_id: sessionUser.id,
        internship_id: internship?.id || null,
        date,
        title,
        description,
        photo_attachment: photo_attachment || null,
        status: 'pending',
      },
    });

    return NextResponse.json({
      message: 'Jurnal berhasil disimpan.',
      journal: newJournal,
    });
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Gagal membuat jurnal: ' + error.message },
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
    const { id, title, description, photo_attachment, status, score, feedback } = body;

    if (!id) {
      return NextResponse.json({ message: 'ID Jurnal tidak valid.' }, { status: 400 });
    }

    const existingJournal = await prisma.journal.findUnique({
      where: { id },
    });

    if (!existingJournal) {
      return NextResponse.json({ message: 'Jurnal tidak ditemukan.' }, { status: 404 });
    }

    // Role checks
    if (sessionUser.role === 'siswa') {
      if (existingJournal.student_id !== sessionUser.id) {
        return NextResponse.json({ message: 'Akses ditolak.' }, { status: 403 });
      }

      const updated = await prisma.journal.update({
        where: { id },
        data: {
          title: title || existingJournal.title,
          description: description || existingJournal.description,
          photo_attachment: photo_attachment !== undefined ? photo_attachment : existingJournal.photo_attachment,
          status: 'pending', // reset to pending on edit
        },
      });

      return NextResponse.json({ message: 'Jurnal berhasil diperbarui.', journal: updated });
    }

    // Mentor or Teacher feedback & validation
    if (['mentor', 'guru_pembimbing', 'admin_sekolah'].includes(sessionUser.role)) {
      const updated = await prisma.journal.update({
        where: { id },
        data: {
          status: status || existingJournal.status,
          score: score !== undefined ? (score ? parseInt(score) : null) : existingJournal.score,
          feedback: feedback !== undefined ? feedback : existingJournal.feedback,
        },
      });

      return NextResponse.json({ message: 'Penilaian jurnal berhasil disimpan.', journal: updated });
    }

    return NextResponse.json({ message: 'Akses ditolak.' }, { status: 403 });
  } catch (error: any) {
    return NextResponse.json(
      { message: 'Gagal memperbarui jurnal: ' + error.message },
      { status: 500 }
    );
  }
}
