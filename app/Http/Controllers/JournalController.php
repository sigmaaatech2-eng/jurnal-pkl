<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\User;
use App\Notifications\JournalPendingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    /**
     * Menampilkan form tambah jurnal.
     */
    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        $internship = $user
            ->studentInternships()
            ->where('status', 'active')
            ->latest()
            ->first();

        if (! $internship) {
            return redirect()
                ->route('siswa.journals.index')
                ->with('error', 'Kamu belum memiliki data PKL aktif.');
        }

        return view('siswa.journals.create', compact('internship'));
    }


    /**
     * Menyimpan jurnal baru.
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $internship = $user
            ->studentInternships()
            ->where('status', 'active')
            ->latest()
            ->first();

        if (! $internship) {
            return redirect()
                ->route('siswa.journals.index')
                ->with('error', 'Data PKL aktif tidak ditemukan.');
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:5120',
            ],
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request
                ->file('attachment')
                ->store('journal-attachments', 'public');
        }

        $journal = Journal::create([
            'student_id'    => $user->id,
            'internship_id' => $internship->id,
            'date'          => $validated['date'],
            'title'         => $validated['title'],
            'description'   => $validated['description'],
            'attachment'    => $attachmentPath,
            'status'        => 'pending',
        ]);

        // Kirim notifikasi ke mentor agar segera mereview jurnal
        $journal->load('internship.mentor');
        $mentor = $journal->internship?->mentor;
        if ($mentor) {
            $mentor->notify(new JournalPendingNotification($journal));
        }

        return redirect()
            ->route('siswa.journals.index')
            ->with('success', 'Jurnal berhasil ditambahkan. Mentor akan segera mereview.');
    }


    /**
     * Menampilkan detail jurnal.
     */
    public function show(Journal $journal)
    {
        /** @var User $user */
        $user = Auth::user();

        // Pastikan jurnal hanya bisa dilihat oleh pemiliknya
        if ($journal->student_id !== $user->id) {
            abort(403);
        }

        return view('siswa.journals.show', compact('journal'));
    }
    public function edit(Journal $journal)
{
    /** @var User $user */
    $user = Auth::user();

    // Pastikan jurnal milik siswa yang sedang login
    if ($journal->student_id !== $user->id) {
        abort(403);
    }

    // Jurnal yang sudah disetujui tidak dapat diedit
    if ($journal->status === 'approved') {
        return redirect()
            ->route('siswa.journals.show', $journal)
            ->with(
                'error',
                'Jurnal yang sudah disetujui tidak dapat diedit.'
            );
    }

    return view('siswa.journals.edit', compact('journal'));
}
public function update(Request $request, Journal $journal)
{
    /** @var User $user */
    $user = Auth::user();

    // Pastikan jurnal milik siswa yang sedang login
    if ($journal->student_id !== $user->id) {
        abort(403);
    }

    // Jurnal yang sudah disetujui tidak dapat diedit
    if ($journal->status === 'approved') {
        return redirect()
            ->route('siswa.journals.show', $journal)
            ->with(
                'error',
                'Jurnal yang sudah disetujui tidak dapat diedit.'
            );
    }

    $validated = $request->validate([
        'date' => ['required', 'date'],
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'attachment' => [
            'nullable',
            'file',
            'mimes:pdf,doc,docx,jpg,jpeg,png',
            'max:5120',
        ],
    ]);

    // Cek apakah jurnal sebelumnya ditolak (akan diresubmit ke pending)
    $wasRejected = $journal->status === 'rejected';

    // Data yang akan diupdate
    $data = [
        'date'        => $validated['date'],
        'title'       => $validated['title'],
        'description' => $validated['description'],
    ];

    if ($wasRejected) {
        $data['status']   = 'pending';
        $data['feedback'] = null;
    }

    // Simpan path file lama
    $oldAttachment = $journal->attachment;

    // Jika ada file baru
    if ($request->hasFile('attachment')) {
        $newAttachment = $request
            ->file('attachment')
            ->store('journal-attachments', 'public');
        $data['attachment'] = $newAttachment;
    }

    // Update data jurnal ke database
    $journal->update($data);

    // Hapus file lama jika diganti
    if ($request->hasFile('attachment') && $oldAttachment) {
        Storage::disk('public')->delete($oldAttachment);
    }

    // Jika jurnal diresubmit setelah revisi, notifikasi ulang ke mentor
    if ($wasRejected) {
        $journal->load('internship.mentor');
        $mentor = $journal->internship?->mentor;
        if ($mentor) {
            $mentor->notify(new JournalPendingNotification($journal));
        }
    }

    return redirect()
        ->route('siswa.journals.show', $journal)
        ->with('success', 'Jurnal berhasil diperbarui.');
}

public function indexGuru()
{
    $journals = Journal::with([
        'student',
        'internship',
    ])
    ->latest('date')
    ->get();

    return view(
        'guru-pembimbing.journals.index',
        compact('journals')
    );
}
    /**
     * Menghapus jurnal.
     */
    public function destroy(Journal $journal)
    {
        /** @var User $user */
        $user = Auth::user();

        // Pastikan jurnal milik siswa yang sedang login
        if ($journal->student_id !== $user->id) {
            abort(403);
        }

        // Jurnal yang sudah disetujui tidak boleh dihapus
        if ($journal->status === 'approved') {
            return redirect()
                ->route('siswa.journals.show', $journal)
                ->with(
                    'error',
                    'Jurnal yang sudah disetujui tidak dapat dihapus.'
                );
        }

        // Hapus file jika ada
        if ($journal->attachment) {
            Storage::disk('public')->delete($journal->attachment);
        }

        // Hapus data jurnal
        $journal->delete();

        return redirect()
            ->route('siswa.journals.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}