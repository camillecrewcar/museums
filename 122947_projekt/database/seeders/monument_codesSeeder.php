<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class monument_codesSeeder extends Seeder
{

    public function run()
    {
        $csvFile = database_path('seeders/zestawienie_zabytki_nieruchome.csv');
        $file = fopen($csvFile, 'r');

        if ($file !== false) {
            $header = fgetcsv($file); // Read the header row
            $inspireIds = [];

            // Find the index of the "code" column
            $inspireIdIndex = array_search('code', $header);

            while (($row = fgetcsv($file)) !== false) {
                $inspireId = $row[$inspireIdIndex];
                $inspireIds[] = $inspireId;
            }

            fclose($file);

            foreach ($inspireIds as $inspireId) {
                DB::table('monument_codes')->insert([
                    'code' => $inspireId,
                    // Add other columns if needed
                ]);
            }
        }
    }
}
