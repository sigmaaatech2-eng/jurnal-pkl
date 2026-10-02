<?php

namespace App\Notifications;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class JournalReviewedNotification extends Notification
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
        return [
            'journal_id' => $this->journal->id,

            'title' => $this->journal->status === 'approved'
                ? 'Jurnal Disetujui'
                : 'Jurnal Perlu Revisi',

            'message' => $this->journal->status === 'approved'
                ? 'Jurnal tanggal ' . $this->journal->date->format('d M Y') . ' telah disetujui.'
                : 'Jurnal tanggal ' . $this->journal->date->format('d M Y') . ' memerlukan revisi.',

            'status' => $this->journal->status,

            'url' => route(
                'siswa.journals.show',
                $this->journal
            ),
        ];
    }
}