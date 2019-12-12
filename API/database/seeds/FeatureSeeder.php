<?php

use Illuminate\Database\Seeder;
use App\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "id" => 1,
                "feature" => "Menambah Task",                     
            ],
            [
                "id" => 2,
                "feature" => "Menghapus Task",                     
            ],
            [
                "id" => 3,
                "feature" => "Melihat Task",                     
            ],
            [
                "id" => 4,
                "feature" => "Mengedit Task",                     
            ],
            [
                "id" => 5,
                "feature" => "Menambah Role",                     
            ],
            [
                "id" => 6,
                "feature" => "Menghapus Role",                     
            ],
            [
                "id" => 7,
                "feature" => "Melihat Role",                     
            ],
            [
                "id" => 8,
                "feature" => "Mengedit Role",                     
            ],
            [
                "id" => 9,
                "feature" => "Menambah Permission",                     
            ],
            [
                "id" => 10,
                "feature" => "Menghapus Permission",                     
            ],
            [
                "id" => 11,
                "feature" => "Melihat Permission",                     
            ],
            [
                "id" => 12,
                "feature" => "Mengedit Permission",                     
            ],
            [
                "id" => 13,
                "feature" => "Menambah Tugas",                     
            ],
            [
                "id" => 14,
                "feature" => "Menghapus Tugas",                     
            ],
            [
                "id" => 15,
                "feature" => "Melihat Tugas",                     
            ],
            [
                "id" => 16,
                "feature" => "Mengedit Tugas",                     
            ]
        ];
        
        foreach($data as $saveTo) {
            $feature = new Feature();
            $feature->id = $saveTo['id'];
            $feature->feature = $saveTo['feature'];
            $feature->active = 1;
            $feature->save();
        }
    }
}
