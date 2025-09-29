<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class ConvertExcel extends Command
{
    protected $signature = 'ml:convert-excel {file=storage/app/ml_input/dataset.xlsx}';
    protected $description = 'Convert Excel dataset.xlsx menjadi dataset.csv untuk ML (menjaga kolom Bulan jika ada)';

    public function handle()
    {
        $fileArg = $this->argument('file');
        $file = base_path($fileArg);

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: $file");
            return 1;
        }

        $this->info("Membaca file: $file");

        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();

        // Pastikan folder ml_input ada di storage/app
        $csvPathRel = 'ml_input/dataset.csv';
        $csvPath = storage_path('app/' . $csvPathRel);
        @mkdir(dirname($csvPath), 0755, true);

        // Simpan sebagai CSV UTF-8
        $writer = IOFactory::createWriter($spreadsheet, 'Csv');
        // Default delimiter = comma; jika butuh semicolon bisa diset
        $writer->setDelimiter(',');
        $writer->setEnclosure('"');
        $writer->setLineEnding("\n");
        $writer->save($csvPath);

        $this->info("✅ Berhasil convert ke storage/app/{$csvPathRel}");
        return 0;
    }
}
