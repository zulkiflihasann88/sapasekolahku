<?php

namespace App\Controllers;

use App\Models\MasukModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Report extends BaseController
{
    public function index()
    {
        return view('report/laporan-surat-masuk');
    }

    public function generateReport()
    {
        $MasukModel = new MasukModel();

        // Ambil input tanggal dari form
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Jika tanggal tidak diisi, tampilkan semua data
        if ($startDate && $endDate) {
            $students = $masukModel->getByDateRange($startDate, $endDate);
        } else {
            $students = $masukModel->findAll();
        }

        return view('students/index', ['students' => $students]);
    }
    
    public function downloadExcel($start_date, $end_date)
    {
        $suratModel = new MasukModel();
        $masukData = $suratModel->getSuratMasukByDate($start_date, $end_date);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'No Agenda');
        $sheet->setCellValue('C1', 'Nomor Surat');
        $sheet->setCellValue('D1', 'Tanggal Surat');
        $sheet->setCellValue('E1', 'Pengirim');
        $sheet->setCellValue('F1', 'Perihal');

        $row = 2;
        $no = 1;
        foreach ($masukData as $data) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $data->no_agenda);
            $sheet->setCellValue('C' . $row, $data->nomor_surat);
            $sheet->setCellValue('D' . $row, $data->tgl_surat);
            $sheet->setCellValue('E' . $row, $data->pengirim);
            $sheet->setCellValue('F' . $row, $data->perihal);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Surat_Masuk_' . date('Ymd') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit();
    }

    public function downloadPdf($start_date, $end_date)
    {
        $suratModel = new MasukModel();
        $masukData = $suratModel->getSuratMasukByDate($start_date, $end_date);

        $dompdf = new Dompdf();
        $html = view('report/report_pdf', ['masukData' => $masukData]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Laporan_Surat_Masuk_' . date('Ymd') . '.pdf');
    }
}
