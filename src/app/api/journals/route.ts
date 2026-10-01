import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';
import { getSessionUser } from '@/lib/auth';
import { journalSchema, journalReviewSchema } from '@/lib/validations';
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
      // Authorization check for non-siswa accessing a specific student
      if (sessionUser.role === 'mentor') {
        const checkPlacement = await prisma.internship.findFirst({
          where: { student_id: studentId, mentor_id: sessionUser.id },
        });
        if (!checkPlacement) {
          return NextResponse.json({ message: 'Akses ditolak.' }, { status: 403 });
        }
      } else if (sessionUser.role === 'guru_pembimbing') {
        const checkPlacement = await prisma.internship.findFirst({
          where: { student_id: studentId, teacher_id: sessionUser.id },
        });
        if (!checkPlacement) {
          return NextResponse.json({ message: 'Akses ditolak.' }, { status: 403 });
        }
      }
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
      return NextResponse.json({ message: 'Akses ditolak. Hanya siswa yang dapat membuat jurnal.' }, { status: 403 });
    }

    const body = await request.json();

    const parseResult = journalSchema.safeParse(body);
    if (!parseResult.success) {
      return NextResponse.json(
        { message: parseResult.error.errors[0]?.message || 'Data jurnal tidak valid.' },
        { status: 400 }
      );
    }

    const { date, title, description, photo_attachment } = parseResult.data;

    let storageUrl = photo_attachment || null;
    if (photo_attachment && photo_attachment.startsWith('data:')) {
      const uploaded = await uploadStorageFile('journal-attachments', `journal-${sessionUser.id}.jpg`, photo_attachment);
      if (uploaded) storageUrl = uploaded;
    }

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
        photo_attachment: storageUrl,
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
    const { id } = body;

    if (!id) {
      return NextResponse.json({ message: 'ID Jurnal tidak valid.' }, { status: 400 });
    }

    const existingJournal = await prisma.journal.findUnique({
      where: { id },
    });

    if (!existingJournal) {
      return NextResponse.json({ message: 'Jurnal tidak ditemukan.' }, { status: 404 });
    }

    // Siswa Editing Own Journal
    if (sessionUser.role === 'siswa') {
      if (existingJournal.student_id !== sessionUser.id) {
        return NextResponse.json({ message: 'Akses ditolak. Jurnal ini bukan milik Anda.' }, { status: 403 });
      }

      const parseResult = journalSchema.safeParse(body);
      if (!parseResult.success) {
        return NextResponse.json(
          { message: parseResult.error.errors[0]?.message || 'Data jurnal tidak valid.' },
          { status: 400 }
        );
      }

      const { title, description, photo_attachment } = parseResult.data;

      let storageUrl = photo_attachment || existingJournal.photo_attachment;
      if (photo_attachment && photo_attachment.startsWith('data:')) {
        const uploaded = await uploadStorageFile('journal-attachments', `journal-${sessionUser.id}.jpg`, photo_attachment);
        if (uploaded) storageUrl = uploaded;
      }

      const updated = await prisma.journal.update({
        where: { id },
        data: {
          title,
          description,
          photo_attachment: storageUrl,
          status: 'pending',
        },
      });

      return NextResponse.json({ message: 'Jurnal berhasil diperbarui.', journal: updated });
    }

    // Mentor or Guru Pembimbing Reviewing Journal
    if (['mentor', 'guru_pembimbing', 'admin_sekolah'].includes(sessionUser.role)) {
      const parseResult = journalReviewSchema.safeParse(body);
      if (!parseResult.success) {
        return NextResponse.json(
          { message: parseResult.error.errors[0]?.message || 'Data penilaian tidak valid.' },
          { status: 400 }
        );
      }

      const { status, score, feedback } = parseResult.data;

      const updated = await prisma.journal.update({
        where: { id },
        data: {
          status,
          score: score !== undefined ? score : existingJournal.score,
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
