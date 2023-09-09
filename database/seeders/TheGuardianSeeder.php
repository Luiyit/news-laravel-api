<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Source;
use App\Models\Category;
use App\Models\Article;

class TheGuardianSeeder extends AppSeeder
{
    private $file_counts = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i <= $this->file_counts; $i++) {

            $data = $this->read_json("the_guardian_".$i.".json");

            $source = Source::firstOrCreate([
                'name' => $data['source'],
                'website_url' => $data['source_url'],
            ]);

            $multimedia_path = $data["static_path"];
            foreach ($data['results'] as $document) {

                // Create category
                $category = Category::firstOrCreate([
                    'name' => $document['sectionName']
                ]);

                // Create article
                Article::create([
                    'title' => $document['webTitle'],
                    'multimedia_url' => "",
                    'except' => "",
                    'url' => $document['webUrl'],
                    'source_id' => $source->id,
                    'category_id' => $category->id,
                    'published_at' => $document['webPublicationDate'],
                ]);
            }
        }
    }

    protected function read_json($fileName)
    {
        $data = parent::read_json($fileName);
        return $data['response'];
    }
}
