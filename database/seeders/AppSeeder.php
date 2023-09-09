<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class AppSeeder extends Seeder
{
    protected function read_json($fileName)
    {
        if (Storage::disk('data')->exists($fileName))
        {
            $jsonData = Storage::disk('data')->get($fileName);
            $data = json_decode($jsonData, true);
            return $data;
        }

        throw new FileNotFoundException('THe file does not exist.');
    }
}
