<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class referenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedFromCSV('references/ref_sgds.csv', 'ref_sgds', ['sgd_code', 'sgd_desc']);
        $this->seedFromCSV('references/ref_organizations.csv', 'ref_organizations', ['organization_code', 'organization_desc']);




    }
    private function seedFromCSV(string $filePath, string $tableName, array $columns): void
    {
        $path = database_path($filePath);
        if (!file_exists($path)) {
            Log::error("CSV file not found: {$path}");
            return;
        }

        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data); // Skip header if present

        foreach ($data as $row) {
            if (count($row) < count($columns)) {
                Log::warning('Skipping row due to insufficient columns: ', $row);
                continue;
            }

            $insertData = [];
            foreach ($columns as $index => $column) {
                $insertData[$column] = isset($row[$index]) ? $row[$index] : null;
            }

            DB::table($tableName)->insert($insertData);
        }
    }
}

