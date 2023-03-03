<?php

namespace Database\Seeders;

use App\Models\Category as ModelsCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'name'      => 'man',
                'enable'    => 1
            ],
            [
                'name'      => 'women',
                'enable'    => 1
            ],
        ];

        foreach ($data as $value) {
            ModelsCategory::create($value);
            $this->command->info('Category '.$value['name'].' has been saved.');
        }
    }
}
