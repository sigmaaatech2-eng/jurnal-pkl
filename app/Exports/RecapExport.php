<?php

namespace App\Exports;

use App\Models\Internship;
use Shuchkin\SimpleXLSXGen;

class RecapExport
{
    protected $internships;
    protected string $teacherName;

    public function __construct($internships, string $teacherName)
    {
        $this->internships = $internships;
        $this->teacherName = $teacherName;
    }

    /**
     * Export ke file XLSX dan kembalikan response download.
     */
    public function downloadXlsx(string $filename = 'rekap-pkl.xlsx'): \Illuminate\Http\Response
    {
        $rows = $this->buildRows();

        $xlsx    = SimpleXLSXGen::fromArray($rows);
        $content = (string) $xlsx; // menggunakan __toString() untuk mendapat binary content

        return response($content, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($content),
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    /**
     * Export ke file CSV dan kembalikan response download.
     */
    public function downloadCsv(string $filename = 'rekap-pkl.csv'): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $rows = $this->buildRows();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');

            // BOM untuk Excel agar bisa baca UTF-8
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            foreach ($rows as $row) {
                fputcsv($out, $row, ',', '"');
            }

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Bangun baris data untuk export.
     */
    protected function buildRows(): array
    {
        $now = now()->translatedFormat('d F Y, H:i');

        $rows = [];

        // Baris judul
        $rows[] = ['REKAPITULASI PKL SISWA'];
        $rows[] = ['Guru Pembimbing: ' . $this->teacherName];
        $rows[] = ['Tanggal Ekspor: ' . $now];
        $rows[] = ['']; // baris kosong

        // Header kolom
        $rows[] = [
            'No',
            'Nama Siswa',
            'Email Siswa',
            'Tempat PKL',
            'Alamat PKL',
            'Mentor Lapangan',
            'Periode Mulai',
            'Periode Selesai',
            'Status PKL',
            'Total Jurnal',
            'Jurnal Disetujui',
            'Jurnal Pending',
            'Jurnal Ditolak',
            'Total Kehadiran (Hari)',
        ];

        // Data per siswa
        $no = 1;
        foreach ($this->internships as $internship) {
            $journals = $internship->journals;
            $total      = $journals->count();
            $approved   = $journals->where('status', 'approved')->count();
            $pending    = $journals->where('status', 'pending')->count();
            $rejected   = $journals->where('status', 'rejected')->count();
            $attendance = $internship->attendances->count();

            $statusLabel = match ($internship->status) {
                'active'    => 'Aktif',
                'completed' => 'Selesai',
                default     => ucfirst($internship->status ?? '-'),
            };

            $rows[] = [
                $no++,
                $internship->student->name ?? '-',
                $internship->student->email ?? '-',
                $internship->company_name ?? '-',
                $internship->company_address ?? '-',
                $internship->mentor->name ?? '-',
                $internship->start_date ? $internship->start_date->format('d/m/Y') : '-',
                $internship->end_date ? $internship->end_date->format('d/m/Y') : '-',
                $statusLabel,
                $total,
                $approved,
                $pending,
                $rejected,
                $attendance,
            ];
        }

        return $rows;
    }
}
