<?php

namespace App\Imports;

use Spatie\Permission\Models\Permission;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PermissionsImport
{
    public static function importFromExcel($filePath)
    {
        // Load the spreadsheet
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Get the highest row and column
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Loop through each row starting from row 2 (assuming row 1 is headers)
        for ($row = 2; $row <= $highestRow; $row++) {
            $name = $sheet->getCell('A' . $row)->getValue();
            $groupName = $sheet->getCell('B' . $row)->getValue();

            // Skip rows with empty values
            if (empty($name) || empty($groupName)) {
                continue;
            }

            // Create or update the permission in the database
            Permission::updateOrCreate(
                ['name' => $name, 'group_name' => $groupName],
                ['updated_at' => now()]
            );
        }
    }
}
