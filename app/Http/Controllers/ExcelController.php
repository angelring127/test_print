<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExcelController extends Controller
{
    public function index()
    {
        return view('excel.select');
    }

    public function excelView()
    {
        return view('excel.excel_view');
    }

    public function pdfView()
    {
        return view('excel.pdf_view');
    }

    public function processExcel(Request $request): JsonResponse
    {
        $excelPath = storage_path('app/excel/sample.xlsx');

        try {
            $spreadsheet = IOFactory::load($excelPath);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = [];

            foreach ($worksheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function convertToPdf(Request $request)
    {
        $excelPath = storage_path('app/excel/sample.xlsx');

        try {
            $spreadsheet = IOFactory::load($excelPath);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = [];

            foreach ($worksheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            // HTML 테이블 생성
            $html = '<style>
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style>';

            $html .= '<table>';
            foreach ($data as $i => $row) {
                $html .= '<tr>';
                foreach ($row as $cell) {
                    if ($i === 0) {
                        $html .= '<th>' . htmlspecialchars($cell) . '</th>';
                    } else {
                        $html .= '<td>' . htmlspecialchars($cell) . '</td>';
                    }
                }
                $html .= '</tr>';
            }
            $html .= '</table>';

            // PDF 생성
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            // PDF를 base64로 인코딩
            $pdfContent = base64_encode($dompdf->output());

            return response()->json([
                'success' => true,
                'pdfContent' => $pdfContent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
