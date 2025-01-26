<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;

class PermissionsExport
{
    public static function exportToExcel()
    {
        // Fetch permission data
        $permissions = Permission::all();

        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column headers

        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Group Name');


        // Populate data rows
        $row = 2; // Starting from row 2 
        foreach ($permissions as $permission) {
            $sheet->setCellValue('A' . $row, $permission->name);
            $sheet->setCellValue('B' . $row, $permission->group_name);
            $row++;
        }

        // Write to a temporary file
        $filename = 'permissions_' . now()->format('YmdHis') . '.xlsx';
        $filePath = storage_path("app/public/{$filename}");
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filename;
    }
}
