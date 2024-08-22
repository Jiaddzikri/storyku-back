<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $categories = [
            'Fiksi',
            'Non-Fiksi',
            'Sains',
            'Sejarah',
            'Biografi',
            'Fantasi',
            'Horor',
            'Misteri',
            'Romansa',
            'Petualangan',
            'Filsafat',
            'Psikologi',
            'Bisnis',
            'Teknologi',
            'Seni',
            'Musik',
            'Puisi',
            'Drama',
            'Kesehatan',
            'Keluarga',
            'Agama',
            'Pendidikan',
            'Komik',
            'Memoir',
            'Politik',
            'Ekonomi',
            'Hukum',
            'Sosial',
            'Antologi',
            'Ensiklopedia'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }
    }
}
