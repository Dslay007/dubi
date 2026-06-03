<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunityStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $structures = [
            // Founders
            ['type' => 'founder', 'title' => 'Founder 1', 'subtitle' => 'Visioner', 'name' => 'Nama Founder 1', 'photo' => null],
            ['type' => 'founder', 'title' => 'Founder 2', 'subtitle' => 'Strategis', 'name' => 'Nama Founder 2', 'photo' => null],
            ['type' => 'founder', 'title' => 'Founder 3', 'subtitle' => 'Kreatif', 'name' => 'Nama Founder 3', 'photo' => null],
            ['type' => 'founder', 'title' => 'Founder 4', 'subtitle' => 'Teknis', 'name' => 'Nama Founder 4', 'photo' => null],
            
            // Core
            ['type' => 'core', 'title' => 'KETUA', 'subtitle' => 'Ketua Umum', 'name' => 'Nama Ketua', 'photo' => null],
            ['type' => 'core', 'title' => 'WAKIL', 'subtitle' => 'Wakil Ketua', 'name' => 'Nama Wakil', 'photo' => null],
            ['type' => 'core', 'title' => 'SEKRE', 'subtitle' => 'Sekretaris', 'name' => 'Nama Sekretaris', 'photo' => null],
            ['type' => 'core', 'title' => 'BEND', 'subtitle' => 'Bendahara', 'name' => 'Nama Bendahara', 'photo' => null],
        ];

        foreach ($structures as $s) {
            \App\Models\CommunityStructure::create($s);
        }
    }
}
