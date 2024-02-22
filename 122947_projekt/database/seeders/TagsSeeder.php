<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tags;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Games',
            'Art',
            'Architecture',
            'Culture',
            'Heritage',
            'Exhibition',
            'Landmark',
            'Sculpture',
            'Painting',
            'Ancient',
            'Modern',
            'Interactive',
            'Educational',
            'Monument',
            'Tourism',
            'Travel',
            'Museum',
            'Historical Site',
            'Archeology',
            'Cultural Heritage',
            'National Park',
            'Sightseeing',
            'Visitor Center',

        ];

        foreach ($tags as $tagName) {
            Tags::create([
                'name' => $tagName,
            ]);
        }
    }
}
