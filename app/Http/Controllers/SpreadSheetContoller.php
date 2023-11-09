<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class SpreadSheetContoller extends Controller
{
    public function index()
    {
        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();

        // Buat worksheet baru
        $worksheet = $spreadsheet->createSheet();

        // Ambil semua struktur table dari database
        $result = DB::select('SHOW COLUMNS FROM tiket');
        $columns = [];

        // Looping untuk menambahkan nama-nama kolom ke dalam array
        foreach ($result as $results) {
            $columns[] = $row['Field'];
        }
        
        $worksheet->fromArray([$columns], null, 'A1');
        // Kirim spreadsheet ke browser
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="database-structure.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
