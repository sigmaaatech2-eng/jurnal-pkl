<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi yang dikirim ke MENTOR ketika ada jurnal siswa
 * yang perlu di-review (status = pending).
 */
class JournalPendingNotification extends Notification
{
    use Queueable;

    protected Journal $journal;

    public function __construct(Journal $journal)
    {
        $this->journal = $journal;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $student = $this->journal->student;
        $dateFormatted = $this->journal->date
            ? $this->journal->date->translatedFormat('d F Y')
            : '-';

        return [
            'journal_id' => $this->journal->id,
            'type'       => 'journal_pending',

            'title'   => 'Jurnal Baru Menunggu Review',
            'message' => ($student->name ?? 'Siswa') . ' mengirimkan jurnal baru pada '
                . $dateFormatted . ': "' . $this->journal->title . '".',

            'status' => 'pending',

            // URL langsung ke halaman review jurnal di dashboard mentor
            'url' => route('mentor.journals.show', $this->journal),
        ];
    }
}
