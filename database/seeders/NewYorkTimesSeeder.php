<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Source;
use App\Models\Category;
use App\Models\Article;

class NewYorkTimesSeeder extends AppSeeder
{
    private $excluded_cats = [
        'NYTNow',
        'Corrections',
        'U.S.',
        'Express',
        'OpEd',
        'BookReview',
        'RealEstate',
        'Real Estate',
        'Summary'
    ];

    private $articles_to_include = 100;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->read_json("the_new_york_times.json");

        $source = Source::firstOrCreate([
            'name' => $data['source'],
            'website_url' => $data['source_url'],
        ]);


        $multimedia_path = $data["static_path"];
        $index = 0;
        foreach ($data['response']['docs'] as $document) {

            // We want to create exact $articles_to_include articles
            if($index > $this->articles_to_include) break;

            // Validate category
            $category_name = $document['news_desk'];
            if (empty($category_name) || in_array($category_name, $this->excluded_cats)) continue;

            // Create category
            $category = Category::firstOrCreate([
                'name' => $document['news_desk'],
            ]);

            // Set multimedia
            $multimedia_url = isset($document['multimedia'][0]['url'])
                ? $multimedia_path.'/'.$document['multimedia'][0]['url']
                : "";

            // VCreate article
            Article::create([
                'title' => $document['headline']['main'],
                'multimedia_url' => $multimedia_url,
                'except' => $document['snippet'],
                'url' => $document['web_url'],
                'source_id' => $source->id,
                'category_id' => $category->id,
                'published_at' => $document['pub_date'],
            ]);

            $index++;
        }
    }
}
