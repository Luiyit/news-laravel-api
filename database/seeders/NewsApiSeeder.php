<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Source;
use App\Models\Category;
use App\Models\Article;

class NewsApiSeeder extends AppSeeder
{
    private $file_names = [
        'news_api_business.json',
        // 'news_api_politics.json',
        // 'news_api_science.json',
        // 'news_api_technology.json',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        forEach($this->file_names as $fileName) {

            $data = $this->read_json($fileName);
            if(empty($data['category'])) continue;

            $category = Category::firstOrCreate([
                'name' => $data['category'],
            ]);

            foreach ($data['articles'] as $document) {

                if(!isset($document['source']['name'])) continue;

                // Create source
                $parsedUrl = parse_url($document['url']);

                $source = Source::firstOrCreate([
                    'name' => $document['source']['name'],
                    'website_url' => $parsedUrl['host'],
                ]);

                // Create article
                Article::create([
                    'title' => $document['title'],
                    'multimedia_url' => empty($document['urlToImage']) ? "": $document['urlToImage'],
                    'except' => empty($document['description']) ? "": $document['description'],
                    'url' => $document['url'],
                    'source_id' => $source->id,
                    'category_id' => $category->id,
                    'published_at' => $document['publishedAt'],
                ]);
            }
        }
    }
}
